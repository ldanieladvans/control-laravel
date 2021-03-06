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


    function mkdirr($pn,$mode=null) {

      if(is_dir($pn)||empty($pn)) return true;
      $pn=str_replace(array('/', ''),DIRECTORY_SEPARATOR,$pn);

      if(is_file($pn)) {trigger_error('mkdirr() File exists', E_USER_WARNING);return false;}

      $next_pathname=substr($pn,0,strrpos($pn,DIRECTORY_SEPARATOR));
      if($this->mkdirr($next_pathname,$mode)) {if(!file_exists($pn)) {return mkdir($pn,$mode);} }
      return false;
    }

    function unzip($file){

        $zip=zip_open(realpath(".")."/".$file);
        if(!$zip) {return("Unable to proccess file '{$file}'");}

        $e='';

        while($zip_entry=zip_read($zip)) {
           $zdir=dirname(zip_entry_name($zip_entry));
           $zname=zip_entry_name($zip_entry);

           if(!zip_entry_open($zip,$zip_entry,"r")) {$e.="Unable to proccess file '{$zname}'";continue;}
           if(!is_dir($zdir)) $this->mkdirr($zdir,0777);

           #print "{$zdir} | {$zname} \n";

           $zip_fs=zip_entry_filesize($zip_entry);
           if(empty($zip_fs)) continue;

           $zz=zip_entry_read($zip_entry,$zip_fs);

           $z=fopen($zname,"w");
           fwrite($z,$zz);
           fclose($z);
           zip_entry_close($zip_entry);

        } 
        zip_close($zip);

        return($e);
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
        $cim_rfc_account = '';
        $cim_rfc_client = '';
        $cim_account_prefix = '';

        $pdf_complete_list_name = array();

        $zip_files_list = array();
        $path = base_path('storage'.DIRECTORY_SEPARATOR.'app');

        foreach ($messages as $message) {
          if(!$message->isSeen()){
            $destinations = $message->getTo();
            $attachments = $message->getAttachments();         
            foreach ($destinations as $destination){
              $account_mail = Cimail::where('cim_mail',$destination)->get();
              if(count($account_mail) > 0){
                $account_mail = $account_mail[0];
                $cim_rfc_account = $account_mail->cim_rfc_account;
                $cim_rfc_client = $account_mail->cim_rfc_client;
                $cim_account_prefix = $account_mail->cim_account_prefix;
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
                    Log::info('!!!!!!!!!!! Entro a XML !!!!!!!!');
                    $data_content = $attachment->getContent();
                    Log::info($data_content);
                    if(!base64_decode($data_content, true)){
                        Log::info('!!!!!!!!!!! Entro a If base64_decode !!!!!!!!');
                        $data_content = $attachment->getDecodedContent();
                        $data_content = base64_encode($data_content);
                      }
                    Log::info(base64_decode($data_content));
                    if(array_key_exists($file_name,$pair_xml_pdf_list)){
                      $pair_xml_pdf_list[$file_name]['xml'] = $data_content;
                    }else{
                      $pair_xml_pdf_list[$file_name] = ['xml' => $data_content];
                    }
                  }else if(count($list_pdf) > 1){
                    $file_name = $list_pdf[0];
                    $file_type = 'pdf';
                    Log::info('!!!!!!!!!!! Entro a PDF !!!!!!!!');
                    $data_content = $attachment->getDecodedContent();
                    Storage::disk('sftp')->put($file_name.'.pdf', $data_content);
                    Storage::disk('sftp')->put('tttttt.txt', 'drdrdrdrd');
                    if(array_key_exists($file_name,$pair_xml_pdf_list)){
                      $pair_xml_pdf_list[$file_name]['pdf'] = $file_name.'.pdf';
                    }else{
                      $pair_xml_pdf_list[$file_name] = ['pdf' => $file_name.'.pdf'];
                    }
                  }else if(count($list_zip) > 1){
                    $file_name = $list_zip[0];
                    $file_type = 'zip';
                    Log::info('!!!!!!!!!!! Entro a ZIP !!!!!!!!');
                    Storage::disk('local')->put($attachment->getFilename(), $attachment->getDecodedContent());

                    array_push($to_delete_files,$attachment->getFilename());
                    

                    $aux_file_name = $attachment->getFilename();
                    $zip_list = explode('.zip',$aux_file_name);

                    array_push($zip_files_list, $path.DIRECTORY_SEPARATOR.$attachment->getFilename());

                    Log::info($path.DIRECTORY_SEPARATOR.$attachment->getFilename());

                    
                  }
                }
              }
            }
          }          
        }

        $dir_zip_list = array();

        $zip = new \ZipArchive;

        foreach ($zip_files_list as $zf) {
          $zip_list = explode('.zip',$zf);
          if(count($zip_list) > 1){
            array_push($dir_zip_list, $zip_list[0]);
          }

          $res = $zip->open($zf);
          if ($res === TRUE) {
            $zip->extractTo($path);
            $zip->close();
          }
        }

        Log::info('***************************');
        Log::info($dir_zip_list);
        Log::info('***************************');

        foreach ($dir_zip_list as $dz) {
          $ficheros  = scandir($dz);
          Log::info('····················································');
          Log::info($ficheros);
          Log::info('····················································');

          foreach ($ficheros as $fch) {
            Log::info($dz.DIRECTORY_SEPARATOR.trim($fch));
            if(is_file($dz.DIRECTORY_SEPARATOR.trim($fch))){
              $zip_list_xml = explode('.xml',$dz.DIRECTORY_SEPARATOR.trim($fch));
              $zip_list_pdf = explode('.pdf',$dz.DIRECTORY_SEPARATOR.trim($fch));

              if(count($zip_list_xml) > 1){
                $doc = new \DOMDocument();
                $doc->load($dz.DIRECTORY_SEPARATOR.trim($fch));

                $zip_file_name = explode('.xml',$fch)[0];                         
                if(array_key_exists($zip_file_name,$pair_xml_pdf_list)){
                  $pair_xml_pdf_list[$zip_file_name]['xml'] = base64_encode($doc->saveXML());
                }else{
                  $pair_xml_pdf_list[$zip_file_name] = ['xml' => base64_encode($doc->saveXML())];
                }
              }else if(count($zip_list_pdf) > 1){
                $zip_file_name = explode('.pdf',$fch)[0];
                if(array_key_exists($zip_file_name,$pair_xml_pdf_list)){
                  Log::info('Existe');
                  Log::info($zip_file_name);
                  $pair_xml_pdf_list[$zip_file_name]['pdf'] = $zip_file_name.'.pdf';
                  //$pair_xml_pdf_list[$zip_file_name]['pdf'] = file_get_contents($dz.DIRECTORY_SEPARATOR.trim($fch));
                }else{
                  Log::info('No existe');
                  Log::info($zip_file_name);
                  $pair_xml_pdf_list[$zip_file_name] = ['pdf' => $zip_file_name.'.pdf'];
                  //$pair_xml_pdf_list[$zip_file_name] = ['pdf' => file_get_contents($dz.DIRECTORY_SEPARATOR.trim($fch))];
                }


                Storage::disk('sftp')->put($zip_file_name.'.pdf', file_get_contents($dz.DIRECTORY_SEPARATOR.trim($fch)));

              }

            }
          }
        }

        if($account_mail!=false){
          $url_aux = config('app.advans_apps_url.'.$cim_account_prefix);
          if($url_aux){
            $wsdl = $url_aux.'/pushMail?wsdl';
          }
          foreach ($pair_xml_pdf_list as $key => $value) {
            array_push($pdf_complete_list_name, $value['pdf'].'pdf');
            $params = array(
                'hash' => 'aW55ZWN0b3JJbWFw',
                'bdname' => base64_encode($cim_rfc_account.'_'.$cim_rfc_client.'_'.$cim_account_prefix),
                'name' => base64_encode($key),
                'xml' => $value['xml'],
                'pdf' => $value['pdf']
            );
            try {
                $context = stream_context_create(array(
                  'ssl' => array(
                  'verify_peer' => false,
                  'verify_peer_name' => false,
                  'allow_self_signed' => true
                  )
                ));
                $soap = new SoapClient($wsdl,array('stream_context' => $context));
                $data = $soap->__soapCall("addData", $params);
                $message->getBodyHtml();
            }
            catch(Exception $e) {
                die($e->getMessage());
            }
          }
        }
        
        Storage::disk('sftp')->delete($pdf_complete_list_name);
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
