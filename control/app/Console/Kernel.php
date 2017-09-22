<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

use SoapClient;
use Ddeboer\Imap\Server;
use Ddeboer\Imap\SearchExpression;
use Ddeboer\Imap\Search\Email\To;
use Ddeboer\Imap\Search\Text\Body;
use Ddeboer\Imap\Search\Text\Subject;

use App\Cimail;

class Kernel extends ConsoleKernel
{
    /**
     * The Artisan commands provided by your application.
     *
     * @var array
     */
    protected $commands = [

    ];

    public function createRecursiveAccountTimeLine(){
        Log::info('************************************* Init AccountTl Recursive Cron *****************************************');
        $rec_ctas_id_arr = array();
        $rec_ctas = \DB::table('cta')->where('cta_estado','Activa')->where('cta_recursive',1)->get();
        foreach ($rec_ctas as $rec) {
            array_push($rec_ctas_id_arr, $rec->id);
        }
        Log::info($rec_ctas_id_arr);
        $rec_ctas_dets = \DB::table('accounttl')->whereIn('cta_id',$rec_ctas_id_arr)->where('acctl_f_fin',date('Y-m-d'))->get();
        Log::info($rec_ctas_dets);
        foreach ($rec_ctas_dets as $dets) {
            $acctl = new AccountTl();
            $acctl->acctl_estado = 'Pendiente';
            $acctl->cta_id = $dets->cta_id;
            $acctl->acctl_f_ini = mktime(0, 0, 0, date("m"), date("d")+1,date("Y"));
            $acctl->acctl_f_fin = mktime(0, 0, 0, date("m")+3, date("d"),date("Y"));
            $acctl->acctl_f_corte = mktime(0, 0, 0, date("m")+3, date("d"),date("Y"));
            $acctl->save();
        }
        Log::info('************************************* End Cron *****************************************');
    }

    public function readImapMails(){
        Log::info('************************************* Init Read Imap Mails Cron *****************************************');
        $to_delete_files = [];
        $server = new Server(
                      'mail.advans.mx', 
                      '143',     
                      '/novalidate-cert',
                      []
                  );
        $connection = $server->authenticate('boveda.advans', 'uJ4TJ$4&QZhu');
        $mailbox = $connection->getMailbox('INBOX');
        $messages = $mailbox->getMessages();
        $wsdl = 'http://192.168.10.129/advans/bov/public/pushMail?wsdl';
        $pair_xml_pdf_list = array();
        $to_delete_files = array();
        $account_mail = false;
        foreach ($messages as $message) {
          if(!$message->isSeen()){
            $destinations = $message->getTo();
            $attachments = $message->getAttachments();         
            foreach ($destinations as $destination){
              $account_mail = Cimail::where('cim_mail',$destination)->get();
              if(count($account_mail) > 0){
                $account_mail = $account_mail[0];
                foreach ($attachments as $attachment){
                  $file_type = '';
                  $complete_file_name = strtolower($attachment->getFilename());
                  $file_name = '';
                  $list_xml = explode('.xml',$complete_file_name);
                  $list_pdf = explode('.pdf',$complete_file_name);
                  $list_zip = explode('.zip',$complete_file_name);
                  
                  if(count($list_xml) > 1){
                    $file_name = $list_xml[0];
                    $file_type = 'xml';
                    $data_content = $attachment->getContent();
                    if(!base64_decode($data_content, true)){
                        $data_content = $attachment->getDecodedContent();
                        $data_content = base64_encode($data_content);
                      }
                    if(array_key_exists($file_name,$pair_xml_pdf_list)){
                      $pair_xml_pdf_list[$file_name]['xml'] = $data_content;
                    }else{
                      $pair_xml_pdf_list[$file_name] = ['xml' => $data_content];
                    }
                  }else if(count($list_pdf) > 1){
                    $file_name = $list_pdf[0];
                    $file_type = 'pdf';
                    $data_content = $attachment->getContent();
                    if(!base64_decode($data_content, true)){
                      $data_content = $attachment->getDecodedContent();
                      $data_content = base64_encode($data_content);
                    }
                    if(array_key_exists($file_name,$pair_xml_pdf_list)){
                      $pair_xml_pdf_list[$file_name]['pdf'] = $data_content;
                    }else{
                      $pair_xml_pdf_list[$file_name] = ['pdf' => $data_content];
                    }
                  }else if(count($list_zip) > 1){
                    $file_name = $list_zip[0];
                    $file_type = 'zip';
                    Storage::put($attachment->getFilename(), $attachment->getDecodedContent());
                    array_push($to_delete_files,$attachment->getFilename());
                    $path = base_path('storage'.DIRECTORY_SEPARATOR.'app');
                    $zip = zip_open($path.DIRECTORY_SEPARATOR.$attachment->getFilename());
                    if($zip){
                      while ($zip_entry = zip_read($zip)){
                        $zip_complete_file_name = zip_entry_name($zip_entry);
                        $zip_file_name = '';
                        $zip_list_xml = explode('.xml',$zip_complete_file_name);
                        $zip_list_pdf = explode('.pdf',$zip_complete_file_name);
                        $data_content = zip_entry_read($zip_entry);
                        if(count($zip_list_xml) > 1){
                          $zip_file_name = $zip_list_xml[0];                         
                          if(array_key_exists($zip_file_name,$pair_xml_pdf_list)){
                            $pair_xml_pdf_list[$zip_file_name]['xml'] = $data_content;
                          }else{
                            $pair_xml_pdf_list[$zip_file_name] = ['xml' => $data_content];
                          }
                        }else if(count($zip_list_pdf) > 1){
                          $zip_file_name = $zip_list_pdf[0];
                          if(array_key_exists($zip_file_name,$pair_xml_pdf_list)){
                            $pair_xml_pdf_list[$zip_file_name]['pdf'] = $data_content;
                          }else{
                            $pair_xml_pdf_list[$zip_file_name] = ['pdf' => $data_content];
                          }
                        }
                      }
                    }
                    zip_close($zip);
                  }
                }
              }
            }
          }          
        }
        if($account_mail){
          $url_aux = config('app.advans_apps_url.'.$account_mail->cim_account_prefix);
          if($url_aux){
            $wsdl = $url_aux.'/pushMail?wsdl';
          }
          foreach ($pair_xml_pdf_list as $key => $value) {
            $params = array(
                'hash' => 'aW55ZWN0b3JJbWFw',
                'bdname' => base64_encode($account_mail->cim_rfc_account.'_'.$account_mail->cim_rfc_client.'_'.$account_mail->cim_account_prefix),
                'name' => base64_encode($key),
                'xml' => base64_encode($value['xml']),
                'pdf' => base64_encode($value['pdf'])
            );
            try {
                $soap = new SoapClient($wsdl);
                $data = $soap->__soapCall("addData", $params);
                $message->getBodyHtml();
            }
            catch(Exception $e) {
                die($e->getMessage());
            }
          }
        }
        
        Storage::delete($to_delete_files);
        Log::info('************************************* End Cron *****************************************');
    }

    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
        $schedule->call(function () {
            $this->createRecursiveAccountTimeLine();
        })->daily();
        $schedule->call(function () {
            $this->readImapMails();
        })->everyMinute();
          
    }

    /**
     * Register the Closure based commands for the application.
     *
     * @return void
     */
    protected function commands()
    {
        require base_path('routes/console.php');
    }
}
