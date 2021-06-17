<?php
//  Send a test email
 function sendTestEmail(Illuminate\Http\Request $request)
{

   //  Just to check the current email host - shows the proper host 
   //  from the database - i.e. smtp.mailtrap.io

   //  Make sure that all of the information properly validates
  $devapi= new App\Http\Controllers\Controller();

    	$settings = $devapi->getFromApi('GET', 'settings');

   //  Temporarily set the email settings
   config([
       'mail.host'       => $settings[0]->mail_server_hosts,
       'mail.port'       => $settings[0]->mail_server_port,
       'mail.encryption' => $settings[0]->mail_server_encryption,
       'mail.username'   => $settings[0]->mail_server_user,
   ]);
   //  Only update the password if it has been changed
   if(!empty($settings[0]->mail_server_pass))
   {
       config(['mail.password' => $settings[0]->mail_server_pass]);
   }

   //  Try and send the test email
   try
   {
       \Log::info(config('mail.host'));
\Log::info(config('mail.port'));
\Log::info(config('mail.encryption'));
\Log::info(config('mail.username'));
       //  Just to check the new setting - this also shows the correct
       //  email host - which is the newly assigned one via the form 
       //  i.e. smtp.google.com

 Log::notice('Test Email: ');

 //Mail::to($request->to)->send(new App\Mail\NormalEmail($request->all()));


    // $text             = new App\Mail\NormalEmail($request->all());
        $mail             = new PHPMailer\PHPMailer\PHPMailer(true); // create a n
if(strtolower(config('mail.encryption'))=='smtp'){
      $mail->IsSMTP();
}
      $mail->SMTPDebug  = 1; // debugging: 1 = errors and messages, 2 = messages only
        $mail->SMTPAuth   = true; // authentication enabled
       // $mail->SMTPSecure = 'ssl'; // secure transfer enabled REQUIRED for Gmail
        $mail->Host       = config('mail.host');
        $mail->Port       = config('mail.port'); // or 587
        $mail->IsHTML(true);
        $mail->Username = config('mail.username');
        $mail->Password =  $settings[0]->mail_server_pass;
        $mail->SetFrom(config('mail.username'), $settings[0]->mail_server_from_email);
        $mail->Subject = $request->subject;
        $mail->Body    = $request->message;
        $mail->AddAddress($request->to, $request->to);
        if ($mail->Send()) {
           Log::notice('Email SEND ');
        } else {
            Log::notice('Failed to Send Email'.$mail->ErrorInfo);
        }

       return response()->json([
           'success' => true,
           'sentTo'  => $request->to
       ]);
   }
   catch(Exception $e)
   {
       Log::notice('Test Email Failed.  Message: '.$e);
       $msg = '['.$e->getCode().'] "'.$e->getMessage().'" on line '.
            $e->getTrace()[0]['line'].' of file '.$e->getTrace()[0]['file'];
       return response()->json(['message' => $msg]);
   }
}

?>
