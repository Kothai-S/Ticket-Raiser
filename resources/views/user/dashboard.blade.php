<!-- @include('template.header')

<div class="main-panel">
  <div class="content-wrapper">
    <div class="row">
      <div class="col-md-12 grid-margin">
        <div class="d-flex justify-content-between align-items-center">
       
            <h3 class=" mb-4 text-secondary ">My Profile</h3>
          
        <div>
      </div>
    </div>
 
    <div class="row">
      <div class="col-md-6 grid-margin stretch-card">
        <div class="card">
          <div class="card-body ">
            <img src="{{url('assets/images/profile.png')}}" alt="profile" width="200" height="200">
            <div class="card m-3 float-right">
              <div class="card-body ">
                <h6>Employee Id : {{ Auth::user()->id}}</h6>
                <h6>Name: {{ Auth::user()->name }}</h6>
                <p>Email: {{ Auth::user()->email }}</p>       
              </div>
            </div>
          </div>
        </div>  
      </div>  
    </div>
  </div>
  @include('template.footer') 




    
            
           
          
           
          

 -->

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
                    <img src="{{url('assets/images/profile.png')}}" alt="profile" width="200" height="200">
                        <div class="card m-4 border-none float-right">
                            <div class="card-body">
                            <h6>Employee Id : {{ Auth::user()->id}}</h6>
                <h6>Name: {{ Auth::user()->name }}</h6>
                <p>Email: {{ Auth::user()->email }}</p>  
                            </div>
                        </div>
                    </div>
                </div>
    
                
            </div>
        </div>
    

@include('template.footer')

    
