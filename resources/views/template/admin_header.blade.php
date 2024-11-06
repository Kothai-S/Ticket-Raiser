<!DOCTYPE html>
<html lang="en">

<head>  
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <title>Ticket Raise</title>  
  <link rel="stylesheet" href="{{ asset('assets/ti-icons/css/themify-icons.css') }}">
  <link rel="stylesheet" href="{{ asset('assets/base/vendor.bundle.base.css') }}"> 
  <link rel="stylesheet" href="{{ asset('assets/css/style.css') }}">
  <link rel="shortcut icon" href="{{ asset('assets/images/favicon.png') }}" />
  <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
  <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.bundle.min.js"></script>
  <script src="https://kit.fontawesome.com/5e52e61886.js" crossorigin="anonymous"></script>
</head>

<body>
  <div class="container-scroller ">   
    <nav class="navbar col-lg-12 col-12 p-0  d-flex flex-row  ">
    
      <div class="text-center navbar-brand-wrapper d-flex align-items-center justify-content-center">
        <a class="navbar-brand brand-logo mr-5" href=""><img src="{{ asset('assets/images/logo.png') }}" class="mr-2" alt="logo"/></a>
        <a class="navbar-brand brand-logo-mini" href=""><img src="{{ asset('assets/images/logo.png') }}" alt="logo"/></a>
      </div>
      <div class="navbar-menu-wrapper d-flex align-items-end justify-content-start">
        <button class="navbar-toggler navbar-toggler align-self-center" type="button" data-toggle="minimize">
          <span class="ti-view-list"></span>
        </button>       
      </div>
    </nav>
 
   
    @if(Auth::check() && in_array(Auth::user()->id, config('app.superadmin', [])))
    <div class="container-fluid page-body-wrapper bg-white">
      <nav class="sidebar sidebar-offcanvas" id="sidebar">      
        <ul class="nav">
          <li class="nav-item">
            <a class="nav-link" href="{{ route('admindashboard') }}">
              <i class="ti-shield menu-icon"></i>
              <span class="menu-title  fs-1">Dashboard</span>
            </a>
          </li>          

          <li class="nav-item">
            <a class="nav-link" data-toggle="collapse" href="#adminDropdown" aria-expanded="false" aria-controls="adminDropdown">
              <i class="ti-user menu-icon"></i>
              <span class="menu-title ">Admin</span>
              <i class="menu-arrow"></i>
            </a>
            <div class="collapse" id="adminDropdown">
              <ul class="nav flex-column sub-menu">
                <li class="nav-item"> 
                  <a class="nav-link" href="{{ route('addadmin') }}">
                    <span class="menu-title ">Add Admin</span>
                  </a>
                </li>
                <li class="nav-item"> 
                  <a class="nav-link" href="{{ route('showadmin') }}">                 
                    <span class="menu-title ">View Admin</span>
                  </a>
                </li>

              </ul>
            </div>
          </li>
 
 
          
          <li class="nav-item">
              <a class="nav-link" href="{{ route('ticket') }}">
                <i class="ti-receipt menu-icon"></i>
                <span class="menu-title ">Tickets</span>
              </a>
          </li>

          <li class="nav-item">
            <a class="nav-link" href="{{route('UpdatePassword')}}">
              <i class="ti-key menu-icon" ></i>
              <span class="menu-title ">Update Password</span>
            </a>
          </li>  

          <li class="nav-item">
                <a class="nav-link" href="{{ route('TicketReport') }}">
                  <i class="ti-pencil-alt menu-icon"></i>
                  <span class="menu-title ">Reports</span>
                </a>
          </li>
        
          <li class="nav-item">
            <a class="nav-link" href="{{ route('adminlogout') }}">
              <i class="ti-power-off text-danger menu-icon "></i>
              <span class="menu-title ">Logout</span>
            </a>
          </li>
        </ul>
      </nav>
    @elseif(Auth::check() && Auth::user()->parent_id == 1)
    <div class="container-fluid page-body-wrapper bg-white">
        <nav class="sidebar sidebar-offcanvas" id="sidebar">
          <ul class="nav">
            <li class="nav-item">
              <a class="nav-link" href="{{ route('admindashboard') }}">
                <i class="ti-shield menu-icon"></i>
                <span class="menu-title">Dashboard</span>
              </a>
            </li>

            <li class="nav-item">
            <a class="nav-link" data-toggle="collapse" href="#adminDropdown" aria-expanded="false" aria-controls="adminDropdown">
              <i class="ti-user menu-icon"></i>
              <span class="menu-title">Admin</span>
              <i class="menu-arrow"></i>
            </a>
            <div class="collapse" id="adminDropdown">
              <ul class="nav flex-column sub-menu">
                <li class="nav-item"> 
                  <a class="nav-link" href="{{ route('addadmin') }}">
                    <span class="menu-title">Add Admin</span>
                  </a>
                </li>
                <li class="nav-item"> 
                  <a class="nav-link" href="{{ route('showadmin') }}">                 
                    <span class="menu-title">View Admin</span>
                  </a>
                </li>
              </ul>
            </div>
          </li>

            <li class="nav-item">
              <a class="nav-link" data-toggle="collapse" href="#employeeDropdown" aria-expanded="false" aria-controls="employeeDropdown">
                <i class="ti-id-badge menu-icon"></i>
                <span class="menu-title">Employee</span>
                <i class="menu-arrow"></i>
              </a>
              <div class="collapse" id="employeeDropdown">
                <ul class="nav flex-column sub-menu">
                  <li class="nav-item"> 
                    <a class="nav-link" href="{{ route('storeuser') }}">                
                      <span class="menu-title">Add Employee</span>
                    </a>
                  </li>
                  <li class="nav-item"> 
                    <a class="nav-link" href="{{ route('showuser') }}">                   
                      <span class="menu-title">View Employee</span>
                    </a>
                  </li>
                </ul>
              </div>
            </li>

            <li class="nav-item">
              <a class="nav-link" data-toggle="collapse" href="#instructionDropdown" aria-expanded="false" aria-controls="instructionDropdown">
                <i class="ti-write menu-icon"></i>
                <span class="menu-title">Instruction</span>
                <i class="menu-arrow"></i>
              </a>
              <div class="collapse" id="instructionDropdown">
                <ul class="nav flex-column sub-menu">
                  <li class="nav-item">
                    <a class="nav-link" href="{{route('reason')}}">
                      <span class="menu-title">Add Instruction</span>
                    </a>
                  </li>
                  <li class="nav-item">
                    <a class="nav-link" href="{{route('viewreason')}}">
                      <span class="menu-title">View Instruction</span>
                    </a>
                  </li>
                </ul>
              </div>
            </li> 

            <li class="nav-item">
                <a class="nav-link" href="{{ route('ticket') }}">
                  <i class="ti-receipt menu-icon"></i>
                  <span class="menu-title">Tickets</span>
                </a>
            </li>

            <li class="nav-item">
                <a class="nav-link" href="{{ route('TicketReport') }}">
                  <i class="ti-pencil-alt menu-icon"></i>
                  <span class="menu-title">Reports</span>
                </a>
            </li>

            <li class="nav-item">
            <a class="nav-link" href="{{route('UpdatePassword')}}">
              <i class="ti-key menu-icon"></i>
              <span class="menu-title">Update Password</span>
            </a>
          </li>  
            <li class="nav-item">
              <a class="nav-link" href="{{ route('adminlogout') }}">
                <i class="ti-power-off text-danger menu-icon"></i>
                <span class="menu-title">Logout</span>
              </a>
            </li>
          </ul>
        </nav>
        
        @else
          <div class="container-fluid page-body-wrapper bg-white">
            <nav class="sidebar sidebar-offcanvas" id="sidebar">
              <ul class="nav">
                <li class="nav-item">
                  <a class="nav-link" href="{{ route('admindashboard') }}"> 
                    <i class="ti-shield menu-icon"></i>
                    <span class="menu-title">Dashboard</span>
                  </a>
                </li>          

                <li class="nav-item">
                    <a class="nav-link" href="{{ route('ticket') }}">
                      <i class="ti-receipt menu-icon"></i>
                      <span class="menu-title">Tickets</span>
                    </a>
                </li>

                <li class="nav-item">
                  <a class="nav-link" href="{{ route('adminlogout') }}">
                    <i class="ti-power-off text-danger menu-icon"></i>
                    <span class="menu-title">Logout</span>
                  </a>
                </li>
              </ul>
            </nav>
    
    @endif
  

  

