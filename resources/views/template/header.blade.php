<!DOCTYPE html>
<html lang="en">

<head>  
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <title>Ticket Raise</title>  
  <link rel="stylesheet" href="{{url('assets/ti-icons/css/themify-icons.css')}}">
  <link rel="stylesheet" href="{{url('assets/base/vendor.bundle.base.css')}}"> 
  <link rel="stylesheet" href="{{url('assets/css/style.css')}}">
  <link rel="shortcut icon" href="{{url('assets/images/favicon.png')}}" />
  <script src="https://kit.fontawesome.com/5e52e61886.js" crossorigin="anonymous"></script>
  
</head>

<body>
  <div class="container-scroller ">   
    <nav class="navbar col-lg-12 col-12 p-0  d-flex flex-row">
      <div class="text-center navbar-brand-wrapper d-flex align-items-center justify-content-center">
        <a class="navbar-brand brand-logo mr-5" href=""><img src="{{url('assets/images/logo.png')}}" class="mr-2" alt="logo"/></a>
        <a class="navbar-brand brand-logo-mini" href=""><img src="{{url('assets/images/logo-mini.svg')}}" alt="logo"/></a>
      </div>
      <div class="navbar-menu-wrapper d-flex align-items-center justify-content-start">
        <button class="navbar-toggler navbar-toggler align-self-center" type="button" data-toggle="minimize">
          <span class="ti-view-list"></span>
        </button>        
      </div>
    </nav>

    <div class="container-fluid page-body-wrapper  bg-white">
      
      <nav class="sidebar sidebar-offcanvas" id="sidebar">
        <ul class="nav">
          <li class="nav-item">
            <a class="nav-link" href="{{route('dashboard')}}">
              <i class="ti-shield menu-icon"></i>
              <span class="menu-title">Dashboard</span>
            </a>
          </li>      
         
          <li class="nav-item">
            <a class="nav-link" href="{{route('ticketpage')}}">
              <i class="ti-write menu-icon"></i>
              <span class="menu-title">Raise Tickets</span>
            </a>
          </li>

           <li class="nav-item">
            <a class="nav-link" href="{{route('userticket')}}">
              <i class="ti-comment-alt menu-icon"></i>
              <span class="menu-title"> Ticket History</span>
            </a>
          </li> 
    

          <li class="nav-item">
            <a class="nav-link" href="{{route('logout')}}">
              <i class="ti-power-off text-danger menu-icon"></i>
              <span class="menu-title">Logout</span>
            </a>
          </li>
          
         
        </ul>
      </nav>
 


