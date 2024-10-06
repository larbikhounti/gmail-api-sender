<?php

namespace App\Http\Controllers;

use App\Models\EmailToken;
use Dacastro4\LaravelGmail\Facade\LaravelGmail;
use Illuminate\Http\Request;
use Symfony\Component\Mime\Email;

class EmailTokenController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $list = EmailToken::All('email');
        return $list;
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store()
    {    
        
        $email = new Email();
        $token = LaravelGmail::makeToken();
        
        $email = $token['email'];

        
        $is_email_exsist =  EmailToken::where('email',$email)->first();
        if($is_email_exsist){
              $is_email_exsist->update([
                'token' => $token,
              ]);
              
         }else{
            EmailToken::create([
                'email' => $email,
                'token' => json_encode($token),
            ]);
            
        }
        // retdirect to view welcome
        return redirect('/');        
    }
    // add alias to email
    public function add_alias(Request $request){
        $email = $request->email;
        $alias = $request->alias;
        $is_email_exsist =  EmailToken::where('email',$email)->first();
        if($is_email_exsist){
              $is_email_exsist->update([
                'alias' => $alias,
              ]);
              
         }else{
            EmailToken::create([
                'email' => $email,
                'alias' => $alias,
            ]);
            
        }
        
        return response()->json(['success'=>'data changed successfully.']);
                
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\EmailToken  $emailToken
     * @return \Illuminate\Http\Response
     */
    public function show(EmailToken $emailToken)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\EmailToken  $emailToken
     * @return \Illuminate\Http\Response
     */
    public function edit(EmailToken $emailToken)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\EmailToken  $emailToken
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, EmailToken $emailToken)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\EmailToken  $emailToken
     * @return \Illuminate\Http\Response
     */
    public function destroy(EmailToken $emailToken)
    {
        //
    }
}
