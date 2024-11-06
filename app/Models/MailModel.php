<?php

namespace App\Models;
use Mail;
use App\Mail\SampleMail;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MailModel extends Model
{
  
    public static function mailData($data)
    {
        $mailData = [
            'title' => 'Tickets Details',
            'body' => 'Ticket Raise for the Employee.',
            'subject' => 'User Login Details',
            'view' => 'mail.ticket-raise', 
            'Employee_id' =>$data['userid'],
            'ticket_id'=>$data['ticket_id'],
            'reason' =>$data['reason'],
            'email' =>$data['email'],
            'url' => url('admin/adminlogin'),
            'home_url' => url(''),   
        ];
        // echo "<pre>";print_r($mailData);
        Mail::to($data['email'])->send(new SampleMail($mailData));
           

    }

    public static function AssignData($data)
    {
        $mailData = [
            'title' => 'Ticket Assign Details',
            'body' => 'Ticket Assigned For You',
            'subject' => 'Ticket Details',
            'view' => 'mail.ticket-assign',
            'ticket_id' => $data['ticket_id'],
            'Employee_Id' => $data['user_id'],
            'email' => $data['email'],
            'url' => url('admin.adminlogin'),
            'home_url' => url(''),  
        ];
   
        
        Mail::to($data['email'])->send(new SampleMail($mailData));
    }
    


    public static function CompletedData($data)
    {
        $mailData = [
            'title' => 'Ticket Details',
            'body' => 'Ticket Status Is Completed',
            'subject' => 'Ticket Details',
            'view' => 'mail.ticket-completed', 
            'ticket_id'=>$data['ticket_id'],
            'status'=>$data['status'],
            'email' =>$data['email'],
            'url' => url('user/login'),
            'home_url' => url(''),   
        ];


       
        Mail::to($data['email'])->send(new SampleMail($mailData));
           
    }

    public static function SendData($data)
    {
     
        $mailData = [
            'title' => 'Update Details',
            'body' => 'Your Password is updated',
            'subject' => 'Successfully Update your password',
            'view' => 'mail.update-password', 
            'Update password'=>$data['password'],
            'email' =>$data['email'],
            'url' => url('admin.adminlogin'),
            'home_url' => url(''),   
        ];
        
        Mail::to($data['email'])->send(new SampleMail($mailData));
           
        // return view( $mailData['view'] , $data = array('mailData'=> $mailData)) ;

    }

    use HasFactory;
}
