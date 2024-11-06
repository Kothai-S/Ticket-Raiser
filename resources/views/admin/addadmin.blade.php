@include('template.admin_header')

<div class="main-panel">        
  <div class="content-wrapper">
    <div class="row">
      <div class="col-md-12 grid-margin stretch-card">
        <div class="card">
          <div class="card-body">
            <h4 class="card-title">Add Admin</h4>
            @if(session('error'))
              <div class="alert alert-danger">
                {{ session('error') }}
              </div>
            @endif
            <form class="forms-sample" action="{{route('addadmin')}}" method="post">
              @csrf
              <div class="form-group">
                <label for="name">Admin name</label> <span class="text-danger">*</span>
                <input type="text" class="form-control form-input" id="name" placeholder="Name" name="admin_name" value="{{old('admin_name')}}">
                @error('admin_name')
                  <p class="text-danger">{{ $message }}</p>
                @enderror
              </div>
                    
              <div class="form-group">
                <label for="email">Email address</label> <span class="text-danger">*</span>
                <input type="email" class="form-control form-input" id="email" placeholder="Email" name="admin_email" value="{{old('admin_email')}}">
                @error('admin_email')
                  <p class="text-danger">{{ $message }}</p>
                @enderror
              </div>
                    
              <div class="form-group">
                <label for="password">Password</label> <span class="text-danger">*</span>
                <input type="password" class="form-control form-input" id="password" placeholder="Password" name="password" value="{{old('password')}}">
                @error('password')
                  <p class="text-danger">{{ $message }}</p>
                @enderror    
              </div>  
                    
              <div class="form-group">
                <label for="status">Status</label>
                <select class="form-control form-input" id="status" name="status">
                  <option>Select status</option>
                  <option value="Active" {{ old('status') == 'Active' ? 'selected' : '' }}>Active</option>
                  <option value="Inactive" {{ old('status') == 'Inactive' ? 'selected' : '' }}>Inactive</option>
                </select>
                @error('status')
                  <p class="text-danger">{{ $message }}</p>
                @enderror
              </div>

              <div class="form-group">
                <label for="searchAdmin">Reporting person</label>
                <input type="text" class="form-control " id="searchAdmin" placeholder="Type a name" value="{{ Auth::guard('admin')->user()->name }}" readonly>
                <input type="hidden" id="parent_id" name="parent_id" value="{{ Auth::guard('admin')->user()->id }}">
                @error('parent_id')
                  <p class="text-danger">{{ $message }}</p>
                @enderror
              </div>

              <button type="submit" class="btn btn-primary mr-2">Save</button>
            </form>
          </div>
        </div>
      </div>
    </div>
 
    
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
@include('template.footer')