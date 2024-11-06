@include('template.admin_header')

<div class="main-panel">        
  <div class="content-wrapper">
    <div class="row">
      <div class="col-md-12 grid-margin stretch-card">
        <div class="card">
          <div class="card-body">
            <h4 class="card-title">Add Employee</h4>
            @if(session('error'))
            <div class="alert alert-danger">
              {{ session('error') }}
            </div>
            @endif
            <form class="forms-sample" action="{{route('storeuser')}}" method="post">
              @csrf
              <div class="form-group">
                <label for="name">Username</label><span class="text-danger">*</span>
                <input type="text" class="form-control form-input" id="name" placeholder="Username" name="user_name" value="{{old('user_name')}}">
                @error('user_name')
                <p class="text-danger">{{ $message }}</p>
                @enderror
              </div>

              <div class="form-group">
                <label for="email">Email address</label><span class="text-danger">*</span>
                <input type="email" class="form-control form-input" id="email" placeholder="Email" name="user_email" value="{{old('user_email')}}">
                @error('user_email')
                <p class="text-danger">{{ $message }}</p>
                 @enderror
              </div>

              <div class="form-group">
                <label for="password">Password</label><span class="text-danger">*</span>
                <input type="password" class="form-control form-input" id="password" placeholder="Password" name="password" value="{{old('password')}}">
                @error('password')
                  <p class="text-danger">{{ $message }}</p>
                @enderror
              </div>

              <div class="form-group">
                <label for="status">Status</label>
                <select class="form-control" id="status" name="status">
                  <option>select status</option>
                  <option value="Active" {{ old('status') == 'Active' ? 'selected' : '' }}>Active</option>
                  <option value="Inactive" {{ old('status') == 'Inactive' ? 'selected' : '' }}>Inactive</option>
                </select>
                @error('status')
                  <p class="text-danger">{{ $message }}</p>
                @enderror
              </div>
              

              <button type="submit" class="btn btn-primary mr-2">Submit</button>
              
            </form>
          </div>
        </div>
      </div>
</div>
@include('template.footer')








