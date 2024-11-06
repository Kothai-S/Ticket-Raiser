<?php

namespace App\Http\Controllers;
use App\Mail\SampleMail;

use Mail;

use Illuminate\Http\Request;

class MailController extends Controller
{
    public function index($data)
    {
        $mailData = [
            'title' => 'Tickets Details',
            'body' => 'Ticket Raise for the Employee.',
            'subject' => 'User Login Details',
            'view' => 'admin.adminlogin', 
            'url' => url(''),
            'home_url' => url(''),   
        ];
         
        Mail::to('kothai@velozion.com')->send(new SampleMail($mailData));
           
        dd("Email is sent successfully.");
    }

}
