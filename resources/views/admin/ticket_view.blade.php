@include('template.admin_header')

<div class="main-panel">
  <div class="content-wrapper">
    <div class="row">
      <div class="col-md-6 grid-margin">
        <h5>Employee Ticket History</h5>
        <div class="card mb-3">
          <div class="card-body">
            @if($tickets->isEmpty())
              <p>No tickets raised by the employee.</p>
            @else
              <div class="table-responsive">
                <table class="table">
                  <thead>
                    <tr>
                      <th>Ticket ID</th>
                      <th>Ticket Reason</th>
                      <th>Raising Date</th>
                    </tr>
                  </thead>
                  <tbody>
                  @foreach($tickets as $ticket)
                    <tr style="cursor:pointer;">
                      <td>{{ $ticket->id }}</td>   
                      <td>{{ $ticket->reason }}</td>
                      <td>{{ $ticket->current_date }}</td>
                    </tr>
                  @endforeach

                  </tbody>
                </table>
              </div>
            @endif
          </div>
        </div>
      </div>
      
    </div>
  </div>
</div>

@include('template.footer')
