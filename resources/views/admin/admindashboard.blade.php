@include('template.admin_header')
<div class="main-panel">    
    <div class="content-wrapper">
        <h3 class="text-secondary">My Profile </h3>
        @if(session()->has('success'))
            <div class="alert alert-success">
              {{ session()->get('success') }}
            </div>
        @endif
        <div class="row">
            <div class="col-md-6 grid-margin stretch-card">
                <div class="card">
                    <div class="card-body float-start"> 
                        <img src="{{url('assets/images/adminprofile.jpg')}}" alt="profile" width="200" height="250">            
                        <div class="card m-4 border-none float-right">
                            <div class="card-body">
                                <h6>Id : {{Auth::guard('admin')->user()->id}}</h6>
                                <h6>{{Auth::guard('admin')->user()->name }}</h6>
                                <p>{{Auth::guard('admin')->user()->email }}</p>
                            </div>
                        </div>
                    </div>
                </div>
    
                @if(Auth::check() && Auth::user()->parent_id == 0)
                <div class="col-md-6 mt-3">
                    <div class="card grid-margin stretch-card">
                        <div class="card-body">
                            <h4 class="card-title text-bold text-secondary">Ticket List :</h4>  
                            <p>Total Tickets: {{ $ticketRaiseCount }}</p>  
                        </div>
                    </div>
                    <div class="card"> 
                        <div class="card-body">
                            <h4 class="card-title text-bold text-secondary">Pending Ticket List :</h4>  
                            <p>Total Tickets: {{ $pending_tickets_id }}</p> 
                        </div>
                    </div>
                </div>
                @endif
            </div>
        </div>
    

@include('template.footer')

    