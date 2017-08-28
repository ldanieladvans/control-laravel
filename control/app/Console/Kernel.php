<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;
use Illuminate\Support\Facades\Log;

use SoapClient;
use Ddeboer\Imap\Server;
use Ddeboer\Imap\SearchExpression;
use Ddeboer\Imap\Search\Email\To;
use Ddeboer\Imap\Search\Text\Body;
use Ddeboer\Imap\Search\Text\Subject;

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
        /*$server = new Server(
            'mail.advans.mx', 
            '143',     
            '/novalidate-cert',
            []
        );*/
        $server = new Server('imap.gmail.com');
        $connection = $server->authenticate('user', 'pass');
        $mailbox = $connection->getMailbox('INBOX');
        $search = new SearchExpression();
        $search->addCondition(new Subject('testcdfivalidate'));
        //Produccion
        //$wsdl = 'http://192.168.10.129/pushMail?wsdl';
        //Local prueba
        $wsdl = 'http://192.168.10.129/advans/bov/public/pushMail?wsdl';
        $messages = $mailbox->getMessages($search);

        foreach ($messages as $message) {
          $attachments = $message->getAttachments();
          foreach ($attachments as $attachment) {
              $data = '';
              $file_name = $attachment->getFilename();
              $decode_content = $attachment->getDecodedContent();
              $blob_encode_content = gzdeflate($decode_content, 9);
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
              $params = array(
                  'hash' => 'aW55ZWN0b3JJbWFw',
                  'bdname' => base64_encode('MERM840926RY3_SEBR830525TD3_bov'),
                  'name' => base64_encode($attachment->getFilename()),
                  'xml' => $xml,
                  'pdf' => $pdf
              );
              try {
                  $soap = new SoapClient($wsdl);
                  $data = $soap->__soapCall("addData", $params);
              }
              catch(Exception $e) {
                  die($e->getMessage());
              }
          }
        }
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
