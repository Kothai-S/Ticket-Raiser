@include('template.admin_header')

<div class="main-panel">
  <div class="content-wrapper">
    <div class="row">
      <div class="col-md-8">
        <h5>Ticket Details - Ticket ID: {{ $ticket->id }}</h5>
        <div class="card mb-3">
          <div class="card-body">
          <p><strong>Employee Name:</strong> {{ is_string($usernames[$ticket->userid])? $usernames[$ticket->userid] : '' }}</p>


            <p><strong>Ticket Reason:</strong> {{ $ticket->reason }}</p>
            <p><strong>Raising Date:</strong> {{ $ticket->current_date }}</p>
            <p><strong>Assigning Admin:</strong>  {{ $assignedAdminNames }}</p>
            <p><strong>Assigning Date:</strong> {{ $ticket->assign_date }}</p>
            
            <p>
              @if($ticket->image || $ticket->link)
                  <strong>ScreenShot/Image or Link :</strong>
                  @if($ticket->image)
                      <img style="margin: 0 auto;" class="img-fluid mb-3" height="100" width="100" alt="Image" src="{{ asset('images/'. $ticket->image) }}">
                  @endif
                  @if($ticket->link)
                      {{ $ticket->link }}
                  @endif
              @endif
            </p>
            <p><strong>Status:</strong> {{ $ticket->status }}</p>
        </div>
      </div>
    </div>
 

@include('template.footer')
