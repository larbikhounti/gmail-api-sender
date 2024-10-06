<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use App\Models\config;
use App\Models\SendJobs;
use Dacastro4\LaravelGmail\Services\Message\Mail;
use Illuminate\Support\Str;

class SendEmailJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $to;
    public $fromName;
    public $body;
    public $subject;
    public $token;
    public $email;
    public $functions_tag = ['[username]'=>'get_username','[date]'=>'get_date','[a_2]'=>'get_random'];

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($to, $fromName, $body, $subject, $token, $email)
    {
        $this->to = $to;
        $this->fromName = $fromName;
        $this->body = $body;
        $this->subject = $subject;
        $this->token = $token;
        $this->email = $email;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {   
         // check if there is a placeholder in the subjectand replace them with the right value
        $subject = $this->check_placeholders($this->subject);
        $body = $this->check_placeholders($this->body); 

        $mail = new Mail;
        $mail->using($this->token);
        $mail->to($this->to, $name = null);
        $mail->from($this->email,$this->fromName);
        $mail->message($body);
        $mail->subject($subject);
        $mail->send();
        
        $send_job = SendJobs::latest()->first();
        $send_job->progress = $send_job->progress + 1;
        $send_job->save();
    }
    private function shouldStop()
    {
        // Implement your logic to check if the job should be stopped
        // For example, check a database flag or a configuration setting
          // Check the database flag
        $stopEmailJobs = Config::get('stop_email_jobs');
        
        if ($stopEmailJobs) {
            return true;
        }
    
    }

     // check subject and body if there is a palce hodler [username]
     private function check_placeholders($data)
     {
 
         // use regex to get if there a placeholder in the subject
         preg_match_all('/\[(.*?)\]/', $data, $matches);
         // if there is  no placeholder in the subject
         if (count($matches[0]) == 0) {
             return $data;
         }
         // if there is a placeholders in the subject
         foreach ($matches[0] as $tags)  {
              //check check for _ tag 
             if (strpos($tags, '_') !== false) {
                 $get_fucntion = "get_random"; // get_random function
             }else{

                 $get_fucntion = $this->functions_tag[$tags]; // get_username or get_date function
             }
 
 
 
             switch ($get_fucntion) {
                 case 'get_username':
                     $data = $this->get_username($tags, $data,$this->to);
                     break;
                 case 'get_date':
                     $data = $this->get_date($tags, $data);
                     break;
                 case 'get_random':
                     $data = $this->get_random($tags, $data);
                     break;    
 
                 default:
                     break;
             }
         }
 
         return $data;
     }
     // get_username function
     private function get_username($tags, $data, $to)
     {
        // split to and get username
        $username = explode('@', $to)[0];
        $data = str_replace($tags,$username,$data);
        return $data;
     }
     // get_date function
     private function get_date($tags, $data)
     {
         $date = now();
         $data = str_replace($tags,$date,$data);
         return $data;
     }
     // get_random function that check that the tag is
     private function get_random($tags, $data)
     {
         //check if lowercade and if number and if charachter
         $tag = explode('_', $tags);
         // delete [ and ] from the tag
         $tag[0] = substr($tag[0], 1);
         $tag[1] = substr($tag[1], 0, -1);
 
 
         if ($tag[0] == 'a') {
             // generate alphabet randomly
             $alpha_random =   strtolower(Str::random($tag[1]));
             $data = str_replace($tags,$alpha_random,$data); 
         }if ($tag[0] == 'n') {
             //convert string to number
             $number = (int)$tag[1] -1;
             // generate  number randomly
             $number_random =  rand(pow(10, $number), pow(10, $number + 1 )-1);
             $data = str_replace($tags,$number_random,$data); 
         }if ($tag[0] == 'An') {
             // generate charachter randomly TO UPPERCASE
 
             $charachter_random =  strtoupper(Str::random($tag[1]));
             
             $data = str_replace($tags,$charachter_random,$data); 
         }
        
         return $data;
        
     }
}
