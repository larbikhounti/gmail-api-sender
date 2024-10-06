<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use App\Models\EmailList;
use App\Models\EmailToken;
use App\Models\SendJobs;
use Dacastro4\LaravelGmail\Facade\LaravelGmail;
use Illuminate\Support\Facades\Log;

class ProcessRecepients implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

        public $from_name;
        public $body;
        public $subject;
        public $senders;
        public $list_ids;
        public $test_after;
        public $test_email;
        public $send_option;
   
        static $test_count = 0;



    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($from_name, $body, $subject, $senders, $list_ids, $test_after, $test_email, $send_option)
    {
        $this->from_name = $from_name;
        $this->body = $body;
        $this->subject = $subject;
        $this->senders = $senders;
        $this->list_ids = $list_ids;
        $this->test_after = $test_after;
        $this->test_email = $test_email;
        $this->send_option = $send_option;

    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $recipients =  $this->get_all_emails_from_lists($this->list_ids);
        // create a new job in the send_jobs table
        $this->create_process_job($recipients);

        // every sender has his own set of recipients
        $recipients_per_sender =  round(count($recipients) / count($this->senders)); // 2
        $recipients = array_chunk($recipients, $recipients_per_sender); // 6 / 2 = 3 chunks of 2 recipients each per sender 
        $sender_recepients = array_combine($this->senders, $recipients); // ['sender1' => ['recipient1', 'recipient2'], 'sender2' => ['recipient3', 'recipient4']
        
       

        if ($this->send_option == 'drop') {
            foreach ($sender_recepients as $sender => $recipients) {

                // Get the token for the current sender
                $credentials = $this->getToken($sender);
                // Loop through each recipient for the current sender
                foreach ($recipients as $recipient) {

                    $this->send_test($credentials);
                    SendEmailJob::dispatch($recipient, $this->from_name, $this->body, $this->subject, $credentials->token, $credentials->alias? $credentials->alias : $credentials->email);  
                }
        }
            $this->job_status('completed');
        //if it a test send the email to the test email
        }else{
            foreach ($sender_recepients as $sender => $recipients) { 
                // Get the token for the current sender
                $credentials = $this->getToken($sender);
                // send to test email using the senders selected in the form
                try {
                    SendEmailJob::dispatch($this->test_email, $this->from_name, $this->body, $this->subject, $credentials->token, $credentials->alias? $credentials->alias : $credentials->email);  
                } catch (\Throwable $th) {
                    Log::error($th->getMessage() . ' ' . $credentials->email );
                }
              
            }
        }
    }

    private function get_all_emails_from_lists($list_ids)
    {
        // Get all lists with their emails
        $mail_List = EmailList::whereIn('id', $list_ids)->with('emails')->get();
        // Pluck all email addresses from the emails relationship
        $allEmails = $mail_List->pluck('emails.*.email')->flatten()->toArray();

        return $allEmails;
    }

    private function getToken($sender)
    {
        $token = EmailToken::where('email',$sender)->first();
        return $token;
    }

    private function create_process_job($total_recipients)
    {
        $send_job = new SendJobs();
        $send_job->email_list_id = $this->list_ids[0];
        $send_job->total_recipients = count($total_recipients);
        $send_job->progress = 0;
        $send_job->status = 'inprogress';
        $send_job->save();
    }
    // change the status of the job to completed
    private function job_status($status)
    {
        $send_job = SendJobs::latest()->first();
        $send_job->status = $status;
        $send_job->save();
    }
    private function send_test($credentials)
    {
        ProcessRecepients::$test_count++;
        if (ProcessRecepients::$test_count == $this->test_after) {
            SendEmailJob::dispatch($this->test_email, $this->from_name, $this->body, $this->subject, $credentials->token, $credentials->email);
            ProcessRecepients::$test_count = 0;
        }
    }

   

   
    
   


}
