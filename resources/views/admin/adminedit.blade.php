@include('template.admin_header')

<div class="main-panel">        
  <div class="content-wrapper">
    <div class="row">
      <div class="col-md-12 grid-margin stretch-card">
        <div class="card">
          <div class="card-body">
            <h4 class="card-title">Edit Admin</h4>
            @if(session('error'))
            <div class="alert alert-danger">
              {{ session('error') }}
            </div>
            @endif
            <form class="forms-sample" action="{{ route('adminupdate', $admin->id) }}" method="post">
              @csrf
              <div class="form-group">
                <label for="name">Admin name</label>
                <input type="text" class="form-control form-input" id="name" placeholder="name" name="admin_name" value="{{$admin->name}}">
                @error('admin_name')
                <p class="text-danger">{{ $message }}</p>
                @enderror
              </div>
                    
              <div class="form-group">
                <label for="email">Email address</label>
                <input type="email" class="form-control form-input" id="email" placeholder="Email" name="admin_email" value="{{$admin->email}}">
                @error('admin_email')
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
                  <select class="form-control" id="status" name="status">
                    <option value="Active" {{ $admin->status == 0 ? 'selected' : '' }}>Active</option>
                    <option value="Inactive" {{ $admin->status == 1 ? 'selected' : '' }}>Inactive</option>
                  </select>
                  @error('status')
                    <p class="text-danger">{{ $message }}</p>
                  @enderror
                </div>

                <div class="form-group">
                  <label for="report">Reporting Person</label>
                  <input type="text" class="form-control form-input" id="searchAdmin" placeholder="Type a name" name="parent_id" value="{{optional($admin->parent)->name}}">
                  <input type="hidden" id="parent_id" name="parent_id" value="{{old('parent_id')}}">
                  <div id="adminSelect" class="list-group" style="display: none;"></div>
                </div>
                      
                <div class="form-group">
                  <button type="submit" class="btn btn-primary mr-2">Update</button>
                </div>
              </form>
            </div>
          </div>
        </div>
        </div>

        <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<script>

$(document).ready(function() {
    $('#searchAdmin').on('input', function() {
        var query = $(this).val();
        if (query.length >= 2) { 
            $.ajax({
                url: '/getAdminSuggestions',
                method: 'GET',
                data: { query: query },
                success: function(response) {
                    populateSuggestions(response);
                }
            });
        } else {
            $('#adminSelect').empty().hide();
        }
    });

    function populateSuggestions(suggestions) {
        var suggestionBox = $('#adminSelect');
        suggestionBox.empty();
        suggestions.forEach(function(admin) {
            suggestionBox.append('<a href="#" class="list-group-item list-group-item-action" data-id="' + admin.id + '">' + admin.name + '</a>');
        });
        suggestionBox.show();
    }

    $('#adminSelect').on('click', '.list-group-item', function(e) {
        e.preventDefault();
        var selectedId = $(this).data('id');
        var selectedName = $(this).text();
        $('#searchAdmin').val(selectedName);
        $('#parent_id').val(selectedId);
        $('#adminSelect').hide();
    });

    $(document).on('click', function(e) {
        if (!$(e.target).closest('#searchAdmin, #adminSelect').length) {
            $('#adminSelect').hide();
        }
    });
});

</script>
@include('template.footer')
