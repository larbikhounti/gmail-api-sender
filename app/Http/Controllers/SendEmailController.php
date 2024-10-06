<?php

namespace App\Http\Controllers;

use App\Jobs\ProcessRecepients;
use App\Jobs\SendEmailJob;
use App\Models\EmailList;
use App\Models\EmailToken;
use App\Models\SendJobs;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class SendEmailController extends Controller
{  
  


    public function send_page() {
        return view('sendPage', [
            'emails' => EmailToken::all(),
            'email_list' => EmailList::all()
        ]);
    }
    public function send_test(Request $request) {
        
        $senders = $request->sender;
        $subject = $request->subject;
        $from_name = $request->from_name;
        $body= $request->message;
        $list_ids = $request->list_ids;
        $test_after = $request->test_after;
        $test_email = $request->test_email;
        $send_option = $request->send_option;


   

        //dispatch the job
        ProcessRecepients::dispatch(
            $from_name,
            $body,
            $subject,
            $senders,
            $list_ids,
            $test_after,
            $test_email,
            $send_option
        );
        


        //return with json with status code 200
        return response()->json([
            'message' => 'Emails sent for proccessing successfully'
        ], 200);
    }


   
}
