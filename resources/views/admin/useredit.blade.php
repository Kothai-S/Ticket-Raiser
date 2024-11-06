
@include('template.admin_header')

<div class="main-panel">        
  <div class="content-wrapper">
    <div class="row">
      <div class="col-md-12 grid-margin stretch-card">
        <div class="card">
          <div class="card-body">
            <h4 class="card-title">Edit Employee</h4>
            <!-- @if(session('error'))
              <div class="alert alert-danger">
                {{ session('error') }}
              </div>
            @endif -->
            <form class="forms-sample" action="{{ route('updateuser', $user->id) }}" method="post">
              @csrf
              <div class="form-group">
                <label for="name">Employee name</label>
                <input type="text" class="form-control form-input" id="name" placeholder="name" name="user_name" value="{{$user->name}}">
                @error('user_name')
                <p class="text-danger">{{ $message }}</p>
                @enderror
              </div>
                    
              <div class="form-group">
                <label for="email">Email address</label>
                <input type="email" class="form-control form-input" id="email" placeholder="Email" name="user_email" value="{{$user->email}}">
                @error('user_email')
                  <p class="text-danger">{{ $message }}</p>
                @enderror
              </div>
                    
              <div class="form-group">
                <label for="password">Password</label>
                <input type="password" class="form-control form-input" id="password" placeholder="Password" name="password" value="">
                @error('password')
                <p class="text-danger">{{ $message }}</p>
                @enderror    
              </div>  

              <div class="form-group">
                <label for="status">Status</label>
                <select class="form-control " id="status" name="status">
                  <option value="Active" {{ $user->status_user == 0 ? 'selected' : '' }}>Active</option>
                  <option value="Inactive" {{ $user->status_user == 1 ? 'selected' : '' }}>Inactive</option>
                </select>
              </div>
                    
                                
              <button type="submit" class="btn btn-primary mr-2">Update</button>
                    
              </form>
            </div>
          </div>
        </div>
        </div>
@include('template.footer')   




