

@include('template.admin_header')

<div class="main-panel">        
  <div class="content-wrapper">
    <div class="row">
      <div class="col-md-12 grid-margin stretch-card">
        <div class="card">
          <div class="card-body">
              <h4 class="card-title">Tickets</h4>
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
                        <th>Reason</th>
                        <th>Category</th>
                        <th>Action</th>
                      </tr>
                  </thead>
                  <tbody id="view-reason">
                    @include('partials.reason', ['reasons' => $reasons])
                  </tbody>
                </table>
              </div>
              <div class="pagination-wrapper offset-5">
                @include('partials.reasonpagination', ['reasons' => $reasons])
              </div>
            </div>
          </div>
        </div>
      </div>


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
                url:"{{ url('admin/viewreason?page=') }}"+page,
                success:function(data)
                {
                    $('#view-reason').html(data.reasons);
                    $('.pagination-wrapper').html(data.pagination);
                }
            });
        }
    });
</script>

@include('template.footer')
