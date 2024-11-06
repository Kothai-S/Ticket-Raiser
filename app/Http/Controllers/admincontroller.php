<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\UserModel;
use App\Models\AdminModel;
use App\Models\ticketreasonmodel;
use App\Models\ticket_raise;
use App\Models\history_model;
use App\Models\TicketCommentModel;
use App\Models\MailModel;
use Illuminate\Support\Str;
use Mail;
use App\Mail\SampleMail;

class AdminController extends Controller
{

    public function adminlogout(Request $request)
    {
        Auth::guard('admin')->logout();


        return redirect()->route('login');
    }


    public function adminloginForm()
    {
        return view('admin.adminlogin', ['email' => '', 'password' => '']);
    }

    public function adminLoginCheck(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        $credentials = $request->only('email', 'password');

        if (Auth::guard('admin')->attempt($credentials)) {
            $user = Auth::guard('admin')->user();
            if ($user->status == 0) {
                $request->session()->regenerate();
                return redirect()->route('admindashboard');
            } else {
                return back()->with('error', 'You are not authorized to access this area')->withInput($request->only('email'));
            }
        }

        return back()->with('error', 'Wrong login details')->withInput($request->only('email'));
    }

    public function UpdatePassword()
    {
        return view('admin.updatelogin');
    }

    public function UpdatePasswordCheck(Request $request)
    {
        $request->validate([

            'password' => 'required',
            'confirm_password' => 'required',
        ]);

        $Id = Auth::guard('admin')->user()->id;

        $password = $request->input('password');
        $c_password = $request->input('confirm_password');

        if ($password != $c_password) {
            return view('admin.updatelogin')->with('message', 'Password and Confrim password not mathched');
        }

        $admin = AdminModel::find($Id);
        $admin_find_mail = AdminModel::where('id', $Id)->first();
        $admin_email = $admin_find_mail['email'];



        $admin->update([
            'password' => bcrypt($password),
        ]);

        $Data = [
            'password' => $request->input('password'),
            'email' => $admin_email,
        ];

        $mail = MailModel::SendData($Data);

        return view('admin.admindashboard')->with('success', 'Admin updated successfully');
    }

    public function admindashboard()
    {
        $ticketRaiseCount = ticket_raise::count();
        $pending_tickets_id = 0;
        $unique_ticket = history_model::select('ticket_id')->distinct()->pluck('ticket_id');
        foreach ($unique_ticket as $ticket_id) {
            $status_count = history_model::where('ticket_id', $ticket_id)->count();
            if ($status_count == 1) {
                $pending_tickets_id += 1;
            }
        }

        return view('admin.admindashboard', compact('ticketRaiseCount', 'pending_tickets_id'));
    }


    public function ticket(Request $request)
    {
        $adminId = Auth::guard('admin')->user()->id;
        $check_parentid = AdminModel::where('parent_id', $adminId)->pluck('id');
        $admin = AdminModel::find($adminId);
        $usernames = [];
        $assignedAdminNames = [];
        $ticketStatuses = [];
        $comment = [];

        $tickets = ticket_raise::orderBy('id', 'desc')->get();
        $ticketIds = $tickets->pluck('id');


        foreach ($tickets as $ticket) {
            $Ticket_comments = TicketCommentModel::where('ticket_id', $ticket->id)->first();

            if ($Ticket_comments) {
                $comment[$ticket->id] = $Ticket_comments->comments;

            } else {
                $comment[$ticket->id] = 'No comments';
            }

        }

        foreach ($tickets as $ticket) {
            $status = history_model::where('ticket_id', $ticket->id)->orderBy('id', 'desc')->first();
            if ($status) {
                $ticketStatuses[$ticket->id] = $status->status;
            } else {
                $ticketStatuses[$ticket->id] = 'No status found';
            }
        }

        foreach ($tickets as $ticket) {
            $user = UserModel::find($ticket->userid);
            if ($user) {
                $usernames[$ticket->userid] = $user->name;
            }
            if ($ticket->assign_admin) {
                $assignedAdmin = AdminModel::find($ticket->assign_admin);
                $assignedAdminNames[$ticket->assign_admin] = $assignedAdmin ? $assignedAdmin->name : null;
            }
        }

        if ($admin->parent_id == 0) {

            $ticket_count = ticket_raise::orderBy('id', 'desc')->count();
            return view('admin.ticket', compact('tickets', 'usernames', 'assignedAdminNames', 'ticketStatuses'));
        } elseif ($admin->parent_id == 1) {
            $ticketIds = $tickets->pluck('id')->toArray();
            $parentid_check = history_model::whereIn('parent_id', $ticketIds)->pluck('parent_id')->toArray();

            $pending_tickets = $tickets->whereNotIn('id', $parentid_check);

            $adminticket = history_model::where('assign_admin', $adminId)
                ->orWhereIn('assign_admin', $check_parentid)
                ->pluck('parent_id')
                ->toArray(); // Convert the collection to an array

            $assign_teamTicket = ticket_raise::whereIn('id', $adminticket) // Use whereIn instead of where
                ->orderBy('id', 'desc')
                ->count();

            return view('admin.ticket', compact('tickets', 'usernames', 'assignedAdminNames', 'ticketStatuses', 'pending_tickets', 'assign_teamTicket'));
        } else {

            $ticketRaiseIds = history_model::where('assign_admin', $adminId)
                ->where('status', 'inprogress')
                ->pluck('parent_id');

            $ticket_count = history_model::where('assign_admin', $adminId)->count();
            if ($ticket_count == 0) {
                return view('admin.subadmin_ticket');
            }
            $ticketFull = ticket_raise::whereIn('id', $ticketRaiseIds)
                ->orderBy('id', 'desc')
                ->get();

            return view('admin.subadmin_ticket', compact('ticketRaiseIds', 'usernames', 'tickets', 'ticketFull', 'ticketStatuses'));
        }
    }



    public function adminform()
    {
        return view('admin.addadmin', ['admin_name' => '', 'admin_email' => '', 'password' => '', 'status' => '']);
    }

    public function addadmin(Request $request)
    {
        $request->validate([
            'admin_name' => 'required',
            'admin_email' => 'required|email',
            'password' => 'required',
            'status' => 'required|in:Active,Inactive',
            'parent_id' => 'required',
        ]);
        $email_id = $request->input('admin_email');
        $existingAdmin = AdminModel::where('email', $email_id)->first();

        if ($existingAdmin) {
            return back()->withInput()->with('error', 'Admin with this email already exists.');
        }
        $adminData = $request->only(['admin_name', 'admin_email', 'password', 'status', 'parent_id']);
        $adminData['password'] = bcrypt($adminData['password']);
        $admin = AdminModel::create($adminData);

        if ($admin) {
            return redirect()->route('showadmin')->with('success', 'Admin added successfully');
        } else {
            return back()->withInput()->with('error', 'Failed to add admin');
        }
    }


    public function showadmin(Request $request)
    {
        $admins = AdminModel::orderBy('id', 'desc')->paginate(10);

        if ($request->ajax()) {
            $adminsView = view('partials.showadmin', compact('admins'))->render();
            $paginationView = view('partials.pagination1', compact('admins'))->render();

            return response()->json([
                'admins' => $adminsView,
                'pagination' => $paginationView
            ]);
        }

        return view('admin.viewadmin', compact('admins'));
    }


    public function adminedit($id)
    {
        $admin = AdminModel::findOrFail($id);
        return view('admin.adminedit', compact('admin'));
    }

    public function adminupdate(Request $request, $id)
    {
        $request->validate([
            'admin_name' => 'required',
            'admin_email' => 'required',
            'status' => 'required|in:Active,Inactive',
        ]);

        $admin = AdminModel::findOrFail($id);
        $admin->update([
            'name' => $request->input('admin_name'),
            'email' => $request->input('admin_email'),
            'status_admin' => $request->input('status'),
        ]);

        return redirect()->route('showadmin')->with('success', 'Admin updated successfully');
    }


    public function admindelete($id)
    {
        $admin = AdminModel::findOrFail($id);
        $admin->delete();

        return redirect()->route('showadmin')->with('success', 'Deleted Successfully');
    }

    public function userForm()
    {
        return view('admin.adduser', ['user_name' => '', 'user_email' => '', 'password' => '', 'status' => '']);
    }

    public function storeuser(Request $request)
    {
        $request->validate([
            'user_name' => 'required',
            'user_email' => 'required',
            'password' => 'required',
            'status' => 'required|in:Active,Inactive',
        ]);

        $email_id = $request->input('user_email');
        $existingAdmin = UserModel::where('email', $email_id)->first();

        if ($existingAdmin) {
            return back()->withInput()->with('error', 'Admin with this email already exists.');
        }

        $userData = $request->only(['user_name', 'password', 'status']);
        $userData['password'] = bcrypt($userData['password']);
        $userData['name'] = $request->user_name;
        $userData['email'] = $request->user_email;
        $userData['status_user'] = $request->status;
        UserModel::create($userData);

        return redirect()->route('showuser')->with('success', 'Employee added successfully');
    }
    public function showuser(Request $request)
    {
        $users = UserModel::orderBy('id', 'desc')->paginate(10);
        if ($request->ajax()) {
            return response()->json([
                'users' => view('partials.viewemployee', compact('users'))->render(),
                'pagination' => view('partials.pagination', compact('users'))->render()
            ]);
        }

        return view('admin.viewuser', compact('users'));
    }



    public function edituser($id)
    {
        $user = UserModel::findOrFail($id);
        return view('admin.useredit', compact('user'));
    }

    public function updateuser(Request $request, $id)
    {
        $request->validate([
            'user_name' => 'required',
            'user_email' => 'required',
            'status' => 'required|in:0,1',
        ]);

        $user = UserModel::findOrFail($id);
        $user->update([
            'name' => $request->input('user_name'),
            'email' => $request->input('user_email'),
            'status' => $request->input('status'),
        ]);

        return redirect()->route('showuser')->with('success', 'User updated successfully');
    }


    public function deleteuser($id)
    {
        $user = UserModel::findOrFail($id);
        $user->delete();

        return redirect()->route('showuser')->with('success', 'Deleted Successfully');
    }



    public function getAdminSuggestions(Request $request)
    {
        $query = $request->input('query');
        $admins = AdminModel::where('name', 'like', '%' . $query . '%')->get(['id', 'name']);
        return response()->json($admins);
    }

    public function reason()
    {
        $reasons = ticketreasonmodel::where('category', 0)->get(['id', 'reason']);
        return view('admin.reason_ticket', compact('reasons'));
    }



    public function showreason(Request $request)
    {
        $request->validate([
            'reason' => 'required',
            'instruction' => 'required',
            'parent_id' => 'required',
        ]);


        $reason = new ticketreasonmodel();
        $reason->reason = $request->input('reason');
        $reason->instruction = $request->input('instruction');
        $reason->category = $request->input('parent_id');
        $reason->save();

        return redirect()->route('viewreason')->with('success', 'Instruction added successfully');
    }

    public function viewreason(Request $request)
    {
        $reasons = ticketreasonmodel::orderBy('id', 'desc')->paginate(10);
        if ($request->ajax()) {
            return response()->json([
                'reasons' => view('partials.reason', compact('reasons'))->render(),
                'pagination' => view('partials.reasonpagination', compact('reasons'))->render()
            ]);
        }
        return view('admin.viewreason', compact('reasons'));
    }




    public function editReason($id)
    {
        $reason = TicketReasonModel::findOrFail($id);
        $categories = ticketreasonmodel::where('category', 0)->get(['id', 'reason']);
        return view('admin.reasonedit', compact('reason', 'categories'));
    }


    public function updateReason(Request $request, $id)
    {
        $request->validate([
            'reason' => 'required',
            'instruction' => 'required',
            'category' => 'required',
        ]);

        $reason = ticketreasonmodel::findOrFail($id);
        $reason->update([
            'reason' => $request->input('reason'),
            'instruction' => $request->input('instruction'),
            'category' => $request->input('partent_id'),
        ]);

        return redirect()->route('viewreason')->with('success', 'Reason updated successfully');
    }

    public function deleteReason($id)
    {
        $reason = ticketreasonmodel::findOrFail($id);
        $reason->delete();

        return redirect()->route('viewreason')->with('success', 'Reason deleted successfully');
    }



    public function ticket_details(Request $request, $id)
    {
        $tickets = ticket_raise::where('userid', $id)->get();
        return view('admin.ticket_view', compact('tickets'));
    }

    public function show_all_details($id)
    {

        $ticket = ticket_raise::findOrFail($id);
        $usernames = [];
        $assignedAdminNames = [];


        $assignedAdminName = '';
        if ($ticket->assign_admin) {
            $assignedAdmin = AdminModel::find($ticket->assign_admin);
            $assignedAdminName = $assignedAdmin->name;
        }

        if ($ticket->userid) {
            $user = usermodel::find($ticket->userid);
            if ($user) {
                $usernames[$ticket->userid] = $user->name;
            }
        }

        return view('admin.ticket_history', compact('ticket', 'usernames', 'assignedAdminNames'));

    }
    // --------------------------------------------------------------------------------------
    // public function employee_view_ticket(Request $request, $id)
    // {
    //     $ticket = ticket_raise::find($id);
    //     $history = history_model::find($id);

    //     $tickets = ticket_raise::orderBy('id', 'desc')->get();
    //     $ticketIds = $tickets->pluck('id');



    //     foreach ($tickets as $ticket_id) {
    //         $Ticket_comments = TicketCommentModel::where('ticket_id', $ticket_id->id)->first();

    //         if ( $Ticket_comments) {
    //             $comment[$ticket_id->id] =  $Ticket_comments->comments;

    //         } else {
    //             $comment[$ticket_id->id] = 'No comments';
    //         }

    //     }

    //     $tickets = $ticket['reason'];
    //     $reason = TicketCommentModel::where('ticket_reason', $tickets)->get(['comments', 'ticket_id']);
    //     $ticketid = $reason->pluck('ticket_id')->toArray(); 


    //     $id = history_model::whereIn('ticket_id', $ticketid)
    //                         ->where('status', 'completed')
    //                         ->get(['assign_admin']); 

    //     if ($id->isNotEmpty()) {

    //         $assignAdmin = $id->pluck('assign_admin');
    //     }






    //     if (!$ticket) {
    //         return redirect()->back()->with('error', 'Ticket not found');
    //     }

    //     $adminId = Auth::guard('admin')->user()->id;

    //     $adminNames = AdminModel::where('parent_id', $adminId)->orWhere('id', $adminId)->pluck('name', 'id');
    //     $usernames = [];
    //     $categoryName = [];
    //     $assignedcategoryName = '';


    //     if ($ticket->category_id) {
    //         $ticketReason = TicketReasonModel::find($ticket->category_id);
    //         if ($ticketReason) {
    //             $assignedcategoryName = $ticketReason->reason;
    //         } elseif ($ticket->category_id == 'other') {
    //             $assignedcategoryName = 'New';
    //         }
    //     }

    //     $user = UserModel::find($ticket->userid);
    //     if ($user) {
    //         $usernames = $user->name;
    //     }
    //     $status = history_model::where('ticket_id', $id)->orderBy('id', 'desc')->first();
    //     $current_status = $status['status'];
    //     $complete_date = $status['created_at']; 

    //     $admin = $status['assign_admin'];

    //     if ($adminId == $admin) {
    //         $this_admin = 'true';
    //     } else {
    //         $this_admin = 'false';
    //     }

    //     return view('admin.emp_ticket_view', compact('complete_date', 'comment','reason','ticket', 'usernames', 'adminNames', 'current_status', 'assignedcategoryName', 'history', 'this_admin'));
    // }

    public function employee_view_ticket(Request $request, $ticketId)
    {
        $ticket = ticket_raise::find($ticketId);
        $history = history_model::find($ticketId);

        $tickets = ticket_raise::orderBy('id', 'desc')->get();
        $ticketIds = $tickets->pluck('id');

        $comment = [];

        foreach ($tickets as $ticket_item) {
            $ticketComment = TicketCommentModel::where('ticket_id', $ticket_item->id)->first();

            if ($ticketComment) {
                $comment[$ticket_item->id] = $ticketComment->comments;
            } else {
                $comment[$ticket_item->id] = 'No comments';
            }
        }

        $ticketReasonText = $ticket['reason'];
        $reason = TicketCommentModel::where('ticket_reason', $ticketReasonText)->get(['comments', 'ticket_id', 'assign_person']);
        $relatedTicketIds = $reason->pluck('assign_person')->toArray();
        $assignedadminNames = AdminModel::whereIn('id', $relatedTicketIds)->pluck('name', 'id')->toArray();

        $commentAdminPairs = $reason->map(function ($item) use ($assignedadminNames) {

            return [
                'admin_name' => $assignedadminNames[$item->assign_person] ?? 'Unknown',
                'comments' => $item->comments,
            ];
        });



        $adminId = Auth::guard('admin')->user()->id;
        $adminNames = AdminModel::where('parent_id', $adminId)->orWhere('id', $adminId)->pluck('name', 'id');
        $usernames = [];
        $assignedcategoryName = '';

        if ($ticket->category_id) {
            $ticketReason = TicketReasonModel::find($ticket->category_id);
            if ($ticketReason) {
                $assignedcategoryName = $ticketReason->reason;
            } elseif ($ticket->category_id == 'other') {
                $assignedcategoryName = 'New';
            }
        }

        $user = UserModel::find($ticket->userid);
        if ($user) {
            $usernames = $user->name;
        }

        $latestHistory = history_model::where('ticket_id', $ticketId)->orderBy('id', 'desc')->first();
        $current_status = $latestHistory ? $latestHistory['status'] : null;
        $complete_date = $latestHistory ? $latestHistory['created_at'] : null;

        $admin = $latestHistory ? $latestHistory['assign_admin'] : null;

        $this_admin = ($adminId == $admin) ? 'true' : 'false';

        return view('admin.emp_ticket_view', compact('commentAdminPairs', 'assignedadminNames', 'complete_date', 'comment', 'reason', 'ticket', 'usernames', 'adminNames', 'current_status', 'assignedcategoryName', 'history', 'this_admin'));
    }


    //   -----------------------------------------------------------------------------------------------------



    public function assignTicket(Request $request, $id)
    {
        $adminId = Auth::guard('admin')->user()->id;
        $ticket_id = $request->input('ticket_id');
        $ticket = ticket_raise::findOrFail($id);
        $assign_admin = $request->input('assign_admin');


        $ticket_raise = ticket_raise::where('id', $ticket_id)->pluck('userid')->first();

        $existingAssignment = history_model::where('ticket_id', $ticket_id)
            ->where('status', 'inprogress')
            ->first();
        if ($existingAssignment) {
            $existingAssignment->status = 'denied';
            $existingAssignment->save();
        }
        $history = new history_model();
        $history->ticket_id = $ticket_id;
        $history->assign_admin = $assign_admin;
        $history->parent_id = $ticket_id;
        $history->user_id = $ticket_raise;
        $history->date = now();
        $history->status = 'inprogress';
        $history->save();

        $assignedAdmin = AdminModel::where('id', $adminId)->first();

        if ($assignedAdmin) {
            $email = $assignedAdmin->email;
            $AssignData = [
                'ticket_id' => $ticket_id,
                'user_id' => $ticket_raise,
                'email' => $email,
            ];

            MailModel::AssignData($AssignData);
        }


        return redirect()->route('employee_view_ticket', ['id' => $id])->with(['success' => 'Ticket assigned successfully!']);
    }



    public function updateStatus(Request $request, $id)
    {


        $status = $request->input('status');
        $ticket_id = $request->input('ticket_id');
        $comment = $request->input('comment');
        $reason = $request->input('reason');

        if ($reason) {
            $ticket_reason = ticket_raise::find($ticket_id);
            $ticket_reason->update([
                'reason' => $reason
            ]);
        }

        $ticket = ticket_raise::where('id', $ticket_id)->first();

        $tickets = history_model::find($id);
        $ticket_assign = history_model::where('parent_id', $ticket_id)->first();
        $history = new history_model();
        $history->status = $status;
        $history->ticket_id = $ticket_id;
        $history->parent_id = $ticket_id;
        $history->user_id = $ticket_assign['user_id'];
        $history->assign_admin = $ticket_assign['assign_admin'];
        $history->date = now();
        $history->save();

        $Ticket_comment = new TicketCommentModel();
        $Ticket_comment->ticket_id = $ticket_id;
        $Ticket_comment->comments = $comment;
        $Ticket_comment->assign_person = $ticket_assign['assign_admin'];
        $Ticket_comment->ticket_reason = $ticket['reason'];
        if ($reason) {
            $Ticket_comment->ticket_reason = $reason;
        }

        $Ticket_comment->save();


        $userName = usermodel::where('id', $history->user_id)->get();
        if ($userName->count() > 0) {
            $user = $userName->first();
            $email = $user->email;
        }

        $Data = [
            'ticket_id' => $request->input('ticket_id'),
            'status' => $request->input('status'),
            'email' => $email,
        ];

        $maildata = MailModel::CompletedData($Data);

        return redirect()->route('employee_view_ticket', ['id' => $id]);

    }




    public function employee_view_history($id)
    {
        $history = history_model::where('ticket_id', $id)->get();

        $Admin = history_model::where('ticket_id', $id)->orderBy('id', 'desc')->first();
        $admin_id = $Admin['assign_admin'];

        $admin_name = AdminModel::where('id', $admin_id)->pluck('name')->first();

        if ($admin_name == 'null') {
            $adminName = "NotAssigned";
        } else {
            $adminName = $admin_name;
        }
        return view('admin.emp_view_history', compact('history', 'adminName'));
    }


    public function TicketReport()
{
    $adminsWithCount = [];
    $id = Auth::guard('admin')->user()->id;
    $team_members = AdminModel::where('parent_id', $id)->get();
    foreach ($team_members as $team_member) {

        $adminId = $team_member->id;
        $name = $team_member->name;

        $total_ticket = history_model::where('assign_admin', $adminId)->distinct('ticket_id')->count();
        $completed_ticket = history_model::where('assign_admin', $adminId)->where('status', "completed")->count();
        
        $team_mate_total_ticket = 0;
        $team_mate_completed_ticket = 0;

        if ($id == 1) {  
            $team_mates = AdminModel::where('parent_id', $adminId)->get();
            
            foreach ($team_mates as $team_mate) {
                $userId = $team_mate->id;
                $team_mate_total_ticket += history_model::where('assign_admin', $userId)->distinct('ticket_id')->count();
                $team_mate_completed_ticket += history_model::where('assign_admin', $userId)->where('status', "completed")->count();
            }
        }

        $adminWithTicket = [];
        $adminWithTicket['name'] = $name;
        $adminWithTicket['total_count'] = $total_ticket + $team_mate_total_ticket;
        $adminWithTicket['completed_ticket'] = $completed_ticket + $team_mate_completed_ticket;
        $adminsWithCount[] = $adminWithTicket;
    }
    return view('admin.Ticket_Report', compact('adminsWithCount'));
}



}




