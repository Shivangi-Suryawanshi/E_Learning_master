<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Facades\Auth;
use PDF;

class UserRegistrationMail extends Mailable
{
  use Queueable, SerializesModels;

  private $_user;
  private $_key;
  private $_tokens;
  private $_amount;
  
  /**
   * Create a new message instance.
   *
   * @return void
   */
  public function __construct($key, $user){


    $this->_user = $user;
    $this->_key = $key;
  
  }

  /**
   * Build the message.
   *
   * @return $this
   */
  public function build(){
    switch ($this->_key) {
    
      case 'register-notification':
        return $this->_registerNotification();
      break;     
      case 'user-password-reset':
        return $this->_sendPasswordResetMail();
      break; 
      case 'course-purchase':
        return $this->_coursePurchase();
        break;
        case 'course-confirmation' :
          return $this->courseConfirmation();
          break;
          case 'complete-course': 
            return $this->completeCourse();
            break;
            case 'certificate-upload' :
              return $this->certificateUpload();
            break;
        }
  }


    private function _registerNotification()
    {

    $emailTemplate = \App\EmailTemplates::where('key', $this->_key)->first();
     $this->subject('Traivis - '.$emailTemplate->subject);
    if($emailTemplate)
          {
      $template = $emailTemplate->email_body;
      $template = str_replace('[Name]',$this->_user->name, $template);
      $template = str_replace('[Email]',$this->_user->email, $template);

      return $this->from('mail@example.com', env('MAIL_FROM_NAME'))
          ->view('emails.welcome')->with(['template' => $template]);

      // return $this->view('emails.welcome')->with(['template' => $template]);
           }
     }   

     private function _sendPasswordResetMail(){
      $emailTemplate = \App\EmailTemplates::where('key', $this->_key)->first();
      $this->subject('Traivis - '.$emailTemplate->subject);
      if($emailTemplate){
        $template = $emailTemplate->email_body;
  
        $template = str_replace('[Name]',$this->_user['user_name'], $template);
        $template = str_replace('[activation_token]', env('ASSET_URL').('/forgot-password/reset/'.$this->_user['token'].'?email='.$this->_user['to']), $template);
        return $this->from('mail@example.com', env('MAIL_FROM_NAME'))
        ->view('emails.user-password-reset')->with(['template' => $template]);
        // return $this->view('emails.user-password-reset')->with(['template' => $template]);
      }
    }
      // course purchase maill
      private function _coursePurchase()
      {
  
      $emailTemplate = \App\EmailTemplates::where('key', $this->_key)->first();
    
       $this->subject('Traivis - '.$emailTemplate->subject);
      if($emailTemplate)
            {
             
        $template = $emailTemplate->email_body;
        $template = str_replace('[fullname]',Auth::user()->name, $template);
        $template = str_replace('[course]',$this->_user->title, $template);
        // dd($template);
  
        return $this->from('mail@example.com', env('MAIL_FROM_NAME'))
            ->view('emails.welcome')->with(['template' => $template]);
  
             }

    }
  

     // course confirmation maill
     private function courseConfirmation()
     {
 
     $emailTemplate = \App\EmailTemplates::where('key', $this->_key)->first();
   
      $this->subject('Traivis - '.$emailTemplate->subject);
     if($emailTemplate)
           {
            
       $template = $emailTemplate->email_body;
       $template = str_replace('[name]',$this->_user['name'], $template);
       $template = str_replace('[user]',Auth::user()->name, $template);
       $template = str_replace('[status]',$this->_user['status'], $template);
       $template = str_replace('[course]',$this->_user['course'], $template);
       $template = str_replace('[purchaseDate]',$this->_user['date'], $template);
       $template = str_replace('[purchasedTime]',$this->_user['time'], $template);


       // dd($template);
 
       return $this->from('mail@example.com', env('MAIL_FROM_NAME'))
           ->view('emails.welcome')->with(['template' => $template]);
 
            }
   }



    // course complete maill
    private function completeCourse()
    {

    $emailTemplate = \App\EmailTemplates::where('key', $this->_key)->first();
  
     $this->subject('Traivis - '.$emailTemplate->subject);
    if($emailTemplate)
          {
           
      $template = $emailTemplate->email_body;
      $template = str_replace('[user]',Auth::user()->name, $template);
      $template = str_replace('[course]',$this->_user->title, $template);
      return $this->from('mail@example.com', env('MAIL_FROM_NAME'))
          ->view('emails.welcome')->with(['template' => $template]);
           }
  }


   // certificate upload maill
   private function certificateUpload()
   {
// dd('hai');
   $emailTemplate = \App\EmailTemplates::where('key', $this->_key)->first();
 
    $this->subject('Traivis - '.$emailTemplate->subject);
   if($emailTemplate)
         {
          
     $template = $emailTemplate->email_body;
     $template = str_replace('[user]',$this->_user['name'], $template);
     $template = str_replace('[name]',Auth::user()->name, $template);

     $template = str_replace('[course]',$this->_user['course'], $template);
     return $this->from('mail@example.com', env('MAIL_FROM_NAME'))
         ->view('emails.welcome')->with(['template' => $template]);

          }

 }


  
}