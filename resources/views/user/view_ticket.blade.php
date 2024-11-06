
@include('template.header')
<div class="main-panel">
    <div class="content-wrapper">
    <div class="row">
        <div class="col-md-8">
            <div class="card mb-3">
                <div class="card-body">
                    <p><strong>TicketID: </strong>{{ $ticket->id }}</p>   
                    <p><strong>Employee Name:</strong>  {{ $usernames[$ticket->userid] }}</p> 
                    <p><strong>Category :</strong>{{$assignedcategoryName}}</p>            
                    <p><strong>Ticket Reason: </strong>{{ $ticket->reason }}</p>
                    <p><strong>Raising Date: </strong>{{ $ticket->current_date }}</p>
                    <p>
                        @if($ticket->image)
                            
                            @if($ticket->image)
                                <img style="margin: 0 auto;" class="img-fluid mb-3" height="600" width="200" alt="Image" src="{{ asset('images/'. $ticket->image) }}">
                            @endif
                        @endif   
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
       
    </div>

@include('template.footer')