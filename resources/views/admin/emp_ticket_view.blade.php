@include('template.admin_header')

<div class="main-panel">
    <div class="content-wrapper">
        <div class="row">
            <div class="col-md-6">
                <div class="card mb-3">
                    <div class="card-body">
                        <p><strong>TicketID: </strong>{{ $ticket->id }}</p>
                        <p><strong>Employee Name:</strong> {{ $usernames }}</p>
                        <p><strong>Category :</strong>{{$assignedcategoryName}}</p>
                        <p><strong>Ticket Reason: </strong>{{ $ticket->reason }}</p>
                        <p><strong>Raising Date: </strong>{{ $ticket->current_date }}</p>
                        <p>
                            @if($ticket->image)
                              
                                @if($ticket->image)
                                <img style="margin: 0 auto;" class="img-fluid mb-3" height="450" width="300" alt="Image" src="{{ asset('images/'. $ticket->image) }}">
                                @endif
                            @endif
                        </p>
                        <p>
                            @if($ticket->link)
                               <strong>Link :</strong>
                               @if($ticket->link)

                               {{ $ticket->link }}
                               @endif
                            @endif

                        </p>
                        <p><button class="btn btn-danger btn-sm">{{ $current_status }}</button></p>

                    </div>
                </div>

            </div>
            <div class="col-md-6">
                <div class="card mb-3">
                    <div class="card-body">

                    @if(Auth::check() && Auth::user()->parent_id == 1 && $this_admin == 'true')
                    <h4 class="text-secondary mb-3">Ticket Assign </h4>
                            <form id="assign-ticket-form" action="{{ route('assignTicket', $ticket->id) }}" method="post">
                                @csrf
                                <input type="hidden" name="ticket_id" value="{{ $ticket->id }}">
                                <label for="ticket">Assign person :</label>
                                <select id="admin-select" class="form-control admin-select mb-3" name="assign_admin">
                                    @foreach($adminNames as $adminId => $adminName)
                                        <option value="{{ $adminId }}">{{ $adminName }}</option>
                                    @endforeach
                                </select>
                                <button type='submit' id="assign-btn" class="btn btn-outline-secondary assign-btn">Assign</button>
                            </form>
                           
                            <div class="card-new">
                            <form id="update-status-form" action="{{route('updateStatus', $ticket->id)}}" method="post">
                                @csrf
                                <input type="hidden" name="ticket_id" value="{{ $ticket->id }}">
                                <select id="status" name="status" class="form-control">
                                    <option value="Completed">Completed</option>
                                </select>
                                <br>
                                <div class="form-group">
                                    <label for="comment">Comments :</label>
                                    <textarea class="form-control" id="comment" name="comment" rows="6"></textarea>
                                    </div>
                                <button id="save-button" class="btn-light btn btn-sm" type="submit">Save</button>
                            </form>
                           
                            </div> 

                        @elseif (Auth::check() && Auth::user()->parent_id == 1)
                            <h4 class="text-secondary mb-3">Ticket Assign </h4>
                            <form id="assign-ticket-form" action="{{ route('assignTicket', $ticket->id) }}" method="post">
                                @csrf
                                <input type="hidden" name="ticket_id" value="{{ $ticket->id }}">
                                <label for="ticket">Assign person :</label>
                                <select id="admin-select" class="form-control admin-select mb-3" name="assign_admin">
                                    @foreach($adminNames as $adminId => $adminName)
                                        <option value="{{ $adminId }}">{{ $adminName }}</option>
                                    @endforeach
                                </select>
                                <button type='submit' id="assign-btn" class="btn btn-outline-secondary assign-btn">Assign</button>
                            </form>

                           
                        @elseif (Auth::check() && (Auth::user()->id == 1))
                            <div class="mt-3">
                                <h4 class="text-secondary mb-3">Ticket Assign </h4>
                                <p><strong>Raising Date :</strong> {{ $ticket->current_date }}</p>


                            </div>
                         
                        @else 
                            @if( $current_status == 'Completed') 
                                <div>
                                    <p>Completed at {{ $complete_date }}</p>
                                </div>
                            @else
                        
                                <form id="update-status-form" action="{{route('updateStatus', $ticket->id)}}" method="post">
                                    @csrf
                                    <input type="hidden" name="ticket_id" value="{{ $ticket->id }}">
                                    <div class="form-group">

                                        <label for="reason" >Change Reason :</label>
                                        <input type="text" name="reason" class="form-control my-1">
                                    </div>
                                    <div class="form-group">
                                        <label for="comment">Comments :</label>
                                        <textarea class="form-control" id="comment" name="comment" rows="6"></textarea>
                                    </div>
                                    <select id="status" name="status" class="form-control">
                                        <option value="Completed">Completed</option>
                                    </select>
                                    <br>
                                    <button id="save-button" class="btn-light btn btn-sm" type="submit">Save</button>
                                </form>
                            @endif
                        @endif
                    </div>
                </div>
            </div>
        </div>
   
        @if (Auth::check() && Auth::user()->parent_id !== 1)
@foreach($commentAdminPairs as $pair)
    <div class="card mb-5">
        <div class="card-body">
            <h5 class="text-secondary fs-1">Previous Instructions</h5>
            <p>{{ $pair['admin_name'] }}</p>
            <div>{{ $pair['comments'] }}</div>
        </div>
    </div>
@endforeach 

     
         <!-- <div class="card">
            <div class="card-body">
            <h5 class="text-secondary fs-1">Current Instructions</h5>
              <p>{{ $comment[$ticket->id]}}</p>
            </div>
        </div>  -->
@endif
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script>
    $(document).ready(function() {
        $('#searchInput').on('input', function() {
            var searchText = $(this).val().toLowerCase();
              $('.product').each(function() {
              var employeeName = $(this).data('employee').toLowerCase();
                if (employeeName.includes(searchText) || searchText === '') {
                   $(this).css('display', 'table-row');
                } else {
                   $(this).css('display', 'none');
                }
            });
        });
    });
</script>

    

</script>
<script>
  var formSubmitted = false; 
    $('#save-Button').click(function (e) {
      if (formSubmitted) {
        e.preventDefault(); 
      } else {
        formSubmitted = true; 
    }
  });
</script>
@include('template.footer')


