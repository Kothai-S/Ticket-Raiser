<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\usercontroller;
use App\Http\Controllers\admincontroller;
use App\Http\Controllers\MailController;
use Illuminate\Http\Request; 
use Illuminate\Support\Facades\Auth;
    

Route::get('/user/login', [usercontroller::class, 'index'])->name('index');
Route::post('/user/login', [usercontroller::class, 'userLoginCheck'])->name('userLoginCheck');   
Route::get('/logout', [usercontroller::class, 'logout'])->name('logout');
Route::group(['middleware' => 'auth:web'], function () {
    Route::get('user/dashboard', [usercontroller::class, 'dashboard'])->name('dashboard');
    Route::get('user/ticket_raise', [usercontroller::class, 'ticketpage'])->name('ticketpage');
    Route::post('user/ticket_raise', [usercontroller::class, 'addticket'])->name('addticket');
    Route::get('/fetch-sub-reasons', [usercontroller::class,'fetchSubReasons'])->name('fetchSubReasons');
    Route::get('user/userticket', [usercontroller::class, 'userticket'])->name('userticket');
    Route::get('user/userticket/{id}', [UserController::class, 'view_ticket'])->name('view_ticket');
    Route::get('user/userticket/history/{id}', [UserController::class, 'user_ticket_history'])->name('user_ticket_history');
    
});






// ------------------------------- Admin -------------------

Route::get('admin/adminlogin', [AdminController::class, 'adminloginForm'])->name('login');
Route::post('admin/adminlogin', [AdminController::class, 'adminlogincheck'])->name('adminlogincheck');


Route::group(['middleware' => ['auth:admin']], function () {
    Route::get('admin/updatelogin', [AdminController::class,'UpdatePassword'])->name('UpdatePassword');
    Route::post('admin/updatelogin', [AdminController::class,'UpdatePasswordCheck'])->name('UpdatePasswordCheck');
    Route::get('admin/admindashboard', [AdminController::class, 'admindashboard'])->name('admindashboard');
    Route::get('/', [AdminController::class, 'adminlogout'])->name('adminlogout');
    Route::get('admin/addadmin', [AdminController::class, 'adminform'])->name('adminform');
    Route::post('admin/addadmin', [AdminController::class, 'addadmin'])->name('addadmin');
    Route::get('/getAdminSuggestions', [AdminController::class,'getAdminSuggestions']);
    Route::get('admin/viewadmin', [AdminController::class, 'showadmin'])->name('showadmin');
    Route::get('admin/adminedit/{id}', [AdminController::class, 'adminedit'])->name('adminedit');
    Route::post('admin/update/{id}', [AdminController::class, 'adminupdate'])->name('adminupdate');
    Route::get('admin/delete/{id}', [AdminController::class, 'admindelete'])->name('admindelete');
    Route::get('admin/adduser', [AdminController::class, 'userform'])->name('userform');
    Route::post('admin/adduser', [AdminController::class, 'storeuser'])->name('storeuser');
    Route::get('admin/viewuser', [AdminController::class, 'showuser'])->name('showuser');
    Route::get('admin/useredit/{id}', [AdminController::class, 'edituser'])->name('edituser');
    Route::post('admin/updateuser/{id}', [AdminController::class, 'updateuser'])->name('updateuser');
    Route::get('admin/deleteuser/{id}', [AdminController::class, 'deleteuser'])->name('deleteuser');
 
    Route::get('admin/reason_ticket',[AdminController::class,'reason'])->name('reason');

    Route::post('admin/reason_ticket',[AdminController::class,'showreason'])->name('showreason');
    
    Route::get('admin/viewreason',[AdminController::class,'viewreason'])->name('viewreason');
    Route::get('admin/reasonedit/{id}', [AdminController::class, 'editReason'])->name('editReason');
    Route::post('admin/updateReason/{id}', [AdminController::class, 'updateReason'])->name('updateReason');
    Route::get('admin/deleteReason/{id}', [AdminController::class, 'deleteReason'])->name('deleteReason');
    
    Route::post('/assign-ticket/{id}', [AdminController::class, 'assignTicket'])->name('assignTicket');
 



    Route::get('admin/ticket', [AdminController::class, 'ticket'])->name('ticket');
    Route::get('admin/ticket-details/{id}', [AdminController::class, 'ticket_details'])->name('ticket_details');
    Route::get('admin/ticket/{id}',  [AdminController::class,'show_all_details'])->name('ticket_history');
    Route::post('/update-ticket-status',  [AdminController::class,'updateStatus'])->name('updateStatus');
    Route::get('/ticket/view/{id}', [AdminController::class, 'employee_view_ticket'])->name('employee_view_ticket');
    Route::get('/ticket/history/{id}', [AdminController::class, 'employee_view_history'])->name('employee_view_history');
 
    Route::post('/update-Status/{id}', [AdminController::class, 'updateStatus'])->name('updateStatus');  

    Route::get('admin/ticket/paginate', [AdminController::class, 'ticketPaginate'])->name('admin.ticket.paginate');
    Route::get('Ticket_Report',[AdminController::class, 'TicketReport'])->name('TicketReport');
   
});