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

        foreach ($messages as $message) {
          //Log::info($message->getSubject());
          $destinations = $message->getTo();
          $attachments = $message->getAttachments();
          if(!$message->isSeen()){
            foreach ($attachments as $attachment) { 
              $data = '';
              $file_name = $attachment->getFilename();
              Log::info($file_name);
              //$decode_content = $attachment->getDecodedContent();
              //$blob_encode_content = gzdeflate($decode_content, 9);
              $flag_call = false;
              $xml = '';
              $pdf = '';
              $arr_file_name = explode('.',$file_name);
              if(count($arr_file_name)>1){
                $flag_call = true;
                if(strtolower($arr_file_name[count($arr_file_name)-1])=='xml'){
                  $xml = $attachment->getContent();
                }
                if(strtolower($arr_file_name[count($arr_file_name)-1])=='pdf'){
                  $pdf = $attachment->getContent();
                }
              }
              if($xml != '' || $pdf != ''){
                foreach ($destinations as $destination) {
                  $account_mails = Cimail::where('cim_mail',$destination)->get();
                  foreach ($account_mails as $account_mail) {
                    $url_aux = config('app.advans_apps_url.'.$account_mail->cim_account_prefix);
                    if($url_aux){
                      $wsdl = $url_aux.'/pushMail?wsdl';
                    }
                    if(!preg_match('%^[a-zA-Z0-9/+]*={0,2}$%', $xml)){
                      $xml = base64_encode($xml)
                    }
                    if(!preg_match('%^[a-zA-Z0-9/+]*={0,2}$%', $pdf)){
                      $pdf = base64_encode($pdf)
                    }
                    Log::info($xml);
                    Log::info($pdf);
                    $params = array(
                        'hash' => 'aW55ZWN0b3JJbWFw',
                        'bdname' => base64_encode($account_mail->cim_rfc_account.'_'.$account_mail->cim_rfc_client.'_'.$account_mail->cim_account_prefix),
                        'name' => base64_encode($attachment->getFilename()),
                        'xml' => $xml,
                        'pdf' => $pdf
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
              }else{
                
                if(strtolower($arr_file_name[count($arr_file_name)-1])=='zip'){
                  Storage::put($attachment->getFilename(), $attachment->getDecodedContent());
                  array_push($to_delete_files,$attachment->getFilename());
                  $path = base_path('storage'.DIRECTORY_SEPARATOR.'app');
                  Log::info($path);
                  $zip = zip_open($path.DIRECTORY_SEPARATOR.$attachment->getFilename());
                  if($zip)
                  {
                      while ($zip_entry = zip_read($zip))
                      {
                            $xml_zip = '';
                            $pdf_zip = '';
                            Log::info($zip_entry);
                            $arr_file_name_zip = explode('.',zip_entry_name($zip_entry));
                            Log::info($arr_file_name_zip);
                            if(count($arr_file_name_zip)>1){
                              if(strtolower($arr_file_name_zip[count($arr_file_name_zip)-1])=='xml'){
                                $xml_zip = zip_entry_read($zip_entry);
                              }
                              if(strtolower($arr_file_name_zip[count($arr_file_name_zip)-1])=='pdf'){
                                $pdf_zip = zip_entry_read($zip_entry);
                              }
                            }

                           foreach ($destinations as $destination) {
                              $account_mails = Cimail::where('cim_mail',$destination)->get();
                              foreach ($account_mails as $account_mail) {
                                $url_aux = config('app.advans_apps_url.'.$account_mail->cim_account_prefix);
                                if($url_aux){
                                  $wsdl = $url_aux.'/pushMail?wsdl';
                                }
                                $params = array(
                                    'hash' => 'aW55ZWN0b3JJbWFw',
                                    'bdname' => base64_encode($account_mail->cim_rfc_account.'_'.$account_mail->cim_rfc_client.'_'.$account_mail->cim_account_prefix),
                                    'name' => base64_encode(zip_entry_name($zip_entry)),
                                    'xml' => base64_encode($xml_zip),
                                    'pdf' => base64_encode($pdf_zip)
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
                      }
                  }
                  zip_close($zip);
                }
              }
              
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
