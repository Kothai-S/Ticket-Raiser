@include('template.admin_header')     

<div class="main-panel">
  <div class="content-wrapper">
    <div class="row">
      <div class="col-md-12 grid-margin stretch-card">
        <div class="card">
          <div class="card-body">
            <h4 class="card-title">All Employees</h4>
            <p class="card-description">
              Count of Employees:  {{$users->total()}}
            </p>
            @if(session()->has('success'))
              <div class="alert alert-success">
                {{ session()->get('success') }}
              </div>
            @endif
            <div class="table-responsive">
              <table class="table">
                <thead>
                  <tr>
                    <th>Id</th>
                    <th>Name</th>
                    <th>Email</th>
                    <th>status</th>
                    <th>Action</th>
                    <!-- <th>Ticket</th> -->
                  </tr>
                </thead>
                <tbody id="view-users">
                  @include('partials.viewemployee', ['users' => $users])
                </tbody>
              </table>
            </div>
            <div id="pagination-links" class="offset-5">
                @include('partials.pagination', ['users' => $users])
            </div>

          </div>
        </div>
      </div>
</diV>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script>

$(document).ready(function(){
    $(document).on('click', '.pagination a', function(event){
        event.preventDefault();
        var page = $(this).attr('href').split('page=')[1];
        fetch_data(page);
    });

    function fetch_data(page)
    {
        $.ajax({
            url:"{{ url('admin/viewuser?page=') }}"+page,
            success:function(data)
            {
                $('#view-users').html(data.users);
                $('#pagination-links').html(data.pagination);
            }
        });
    }
});
</script>

@include('template.footer')