@include('template.admin_header')

<div class="main-panel">
  <div class="content-wrapper">
    <div class="row">
      <div class="col-md-12 grid-margin stretch-card">
        <div class="card">
          <div class="card-body">
            <h4 class="card-title">Update Password</h4>
            @if(session()->has('message'))
              <div class="alert alert-success">
                {{ session()->get('message') }}
              </div>
            @endif
            <form class="forms-sample" action="{{route('UpdatePasswordCheck')}}" method="post">
              @csrf

              <div class="form-group">
                <label for="password">Password</label>
                <input type="password" class="form-control form-input" id="password" placeholder="password" name="password"
                  value="{{old('password')}}">
                @error('password')
                  <p class="text-danger">{{ $message }}</p>
                @enderror  
              </div>

              <div class="form-group">
                <label for="confirm password">Confirm Password</label>
                <input type="password" class="form-control form-input" id="confirm password" placeholder="confirm password"
                  name="confirm_password" value="{{old('confirm_password')}}">
                @error('confirm_password')
                  <p class="text-danger">{{ $message }}</p>
                @enderror
              </div>

              <button type="submit" class="btn btn-primary mr-2">Update</button>

            </form>
          </div>
        </div>
      </div>
    </div>

    @include('template.footer')   




