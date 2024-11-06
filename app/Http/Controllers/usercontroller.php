<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\adminmodel;
use App\Models\usermodel;
use App\Models\ticketreasonmodel;
use App\Models\ticket_raise;
use App\Models\history_model;
use Illuminate\Support\Str;
use Mail;
use App\Mail\SampleMail;
use App\Models\MailModel;
use App\Http\Controllers\admincontroller;

class UserController extends Controller
{
    public function index()
    {
        return view('user.login');
    }


    public function userLoginCheck(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        $credentials = $request->only('email', 'password');

        if (Auth::guard('web')->attempt($credentials)) {

            $user = Auth::guard('web')->user();
            if ($user->status == 1) {
                $request->session()->regenerate();
                return redirect()->route('dashboard');
            } else {
                return back()->with('error', 'You are not authorized to access this area')->withInput($request->only('email'));
            }
        }

        return back()->with('error', 'Wrong login details')->withInput($request->only('email'));
    }

    public function dashboard()
    {
        return view('user.dashboard');
    }


    public function ticketpage(Request $request)
    {
        $tickets = ticketreasonmodel::where('category', 0)->get(['id', 'reason', 'instruction']);
        $userId = Auth::user()->id;
        return view('user.ticket_raise', compact('tickets', 'userId'));
    }


    public function addticket(Request $request)
    {
        $request->validate([
            'reason' => 'required',
            'sub_reason' => 'required',
            // 'image' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
            // 'link' => 'required',
        ]);

        $userId = Auth::user()->id;


        if ($request->has('reason')) {
            $imageName = '';

            if ($request->hasFile('image')) {
                $imageName = time() . '.' . $request->file('image')->getClientOriginalExtension();
                $request->file('image')->move(public_path('images'), $imageName);
            }
            $link = $request->filled('link') ? $request->link : '';

            $data = ticket_raise::create([
                'userid' => $userId,
                'category_id' => $request->reason,
                'reason' => $request->sub_reason,
                'image' => $imageName,
                'link' => $link,
                'current_date' => now(),
            ]);

            $lastInsert =  ticket_raise::orderBy('id', 'desc')->first('id');
            $lastId = $lastInsert['id'];

        }
        
        $parentId = '0';
        $assign_admin ='null';
        $d = history_model::create([
            'ticket_id' => $lastId,
            'user_id' => $userId,
            'date' => now(),
            'parent_id' => $parentId,
            'status' => 'pending',
            'assign_admin'=> $assign_admin,
        ]);

        $admins = AdminModel::where('parent_id', '=', '1')->get();  
  
        if ($admins->count() > 0) {  
            $admin = $admins->first();  
            $email = $admin->email;  
        }                    

        $Mail =[
            'userid' =>$userId,
            'reason' => $request->sub_reason,
            'email' =>$email,
            'ticket_id' => $lastId,
       ];
        //   echo "<pre>";print_r($Mail);exit; 

       $maildata = MailModel::mailData($Mail);

       //    echo "<pre>";print_r($maildata);exit; 


        return redirect()->route('userticket', ['userId' => $userId])->with('success', 'Ticket raised successfully');
    }


    public function fetchSubReasons(Request $request)
    {
        $reasonId = $request->input('reason_id');
        $subReasons = ticketreasonmodel::where('category', $reasonId)->get(['id', 'reason', 'instruction']);
        return response()->json($subReasons);
    }



    public function userticket(Request $request)
    {
        $user = auth()->user();
    
        $tickets = ticket_raise::orderBy('id', 'desc')
                               ->where('userid', $user->id)
                               ->paginate(10); 
        if ($request->ajax()) {
            return response()->json([
                'tickets' => view('partials.user-ticket', compact('tickets'))->render(),
                'pagination' => $tickets->links()->toHtml(),
            ]);
        }
        $ticketStatuses = []; 
    
        foreach ($tickets as $ticket) {
            $status = history_model::where('ticket_id', $ticket->id)->orderBy('id', 'desc')->first();
            if ($status) {
                $ticketStatuses[$ticket->id] = $status->status;
            } else {
                $ticketStatuses[$ticket->id] = 'No status found';
            }
        }
    
    
        $usernames = [$user->id => $user->name]; 
        $ticketCounts = [$user->id => $tickets->total()]; 
    
        return view('user.userticket', compact('usernames', 'ticketCounts', 'tickets','ticketStatuses'));
    }


    public function view_ticket($id)
    {
        $ticket = ticket_raise::find($id);
        $usernames = [];
        $categoryName = [];
        $assignedcategoryName = '';
        if ($ticket->category_id) {
            $ticketReason = TicketReasonModel::find($ticket->category_id);
            if ($ticketReason) {
                $assignedcategoryName = $ticketReason->reason;
            }
            if ($ticket->category_id == 'other') {
                $assignedcategoryName = 'New';
            }
        }

        if ($ticket->userid) {
            $user = usermodel::find($ticket->userid);
            if ($user) {
                $usernames[$ticket->userid] = $user->name;
            }
        }
        if (!$ticket) {
            return redirect()->back()->with('error', 'Ticket not found');
        }
        $history = history_model::find($id);
        $status = history_model::where('ticket_id', $id)->orderBy('id','desc')->first();
        $current_status = $status['status'];


        return view('user.view_ticket', compact('ticket', 'usernames', 'assignedcategoryName', 'history','current_status',));
    }


    public function logout(Request $request)
    {
        Auth::logout();
        return redirect()->route('index');
    }

    public function user_ticket_history($id)
    {       
        $ticketHistory = history_model::where('ticket_id',$id)->get(); 
        
        $Admin = history_model::where('ticket_id', $id)->orderBy('id','desc')->first();
        $admin_id = $Admin['assign_admin'];

          $admin_name = AdminModel::where('id', $admin_id)->pluck('name')->first();   

        if($admin_name == 'null'){
            $adminName = "NotAssigned";
        } else{
            $adminName = $admin_name;
        }       

        return view('user.userticket_history', ['ticketHistory' => $ticketHistory , 'adminName' => $adminName ]);
    }
}



