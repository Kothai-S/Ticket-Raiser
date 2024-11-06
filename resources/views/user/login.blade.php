<!DOCTYPE html>
<html lang="en">

<head>
  
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <title>Login</title> 
  <link rel="stylesheet" href="{{url('assets/css/style.css')}}">
  <link rel="stylesheet" href="{{url('assets/base/vendor.bundle.base.css')}}">  
  <link rel="shortcut icon" href="{{url('assets/images/favicon.png')}}" />
</head>

<body>
  <div class="container-scroller">
    <div class="container-fluid page-body-wrapper full-page-wrapper">
      <div class="content-wrapper d-flex align-items-center auth px-0">
        <div class="row w-100 mx-0">
          <div class="col-lg-4 mx-auto">
            <div class="auth-form-light text-left py-5 px-4 px-sm-5">
              <div class="brand-logo d-flex align-items-center justify-content-center">
                <img src="{{url('assets/images/logo.png')}}" alt="logo">
              </div>
              <h4 class="text-center">Hello! let's get started</h4>
              <h6 class="font-weight-light text-center">Log in to continue.</h6>
              @if(session('error'))
                <div class="alert alert-danger">
                   {{ session('error') }}
               
                </div>
              @endif

               <form class="pt-3" action="{{route('userLoginCheck')}}" method="post">
                @csrf
                <div class="form-group">
                  <input type="email" class="form-control form-control-lg bg-white" id="email" placeholder="Useremail" name="email" value="{{old('email')}}">
                  @error('email')
                  <p class="error text-danger">{{ $message }}</p>
                  @enderror
                </div>
               
                <div class="form-group">
                  <input type="password" class="form-control form-control-lg bg-white" id="Password" placeholder="Password" name="password" value="{{old('password')}}">
                  @error('password')
                  <p class="error text-danger">{{ $message }}</p>
                  @enderror
                </div>
             
                <div class="mt-3">
                  <button type='submit' class="btn btn-primary btn btn-block btn-primary btn-lg font-weight-medium auth-form-btn">LOG IN</button>
                </div>
               
               
               
              </form>
            </div>
          </div>
        </div>
      </div>
     
    </div>
   
  </div>

  <script src="{{url('assets/base/vendor.bundle.base.js')}}"></script>
  <script src="{{url('assets/js/off-canvas.js')}}"></script>
  <script src="{{url('assets/js/hoverable-collapse.js')}}"></script>
  <script src="{{url('assets/js/template.js')}}"></script>
  <script src="{{url('assets/js/todolist.js')}}"></script>
 
</body>

</html>
