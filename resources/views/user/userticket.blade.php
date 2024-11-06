@include('template.header')

<div class="main-panel">
  <div class="content-wrapper">
    <div class="row">
      <div class="col-md-10 grid-margin">
        <h5>Raising Ticket History</h5>
        @foreach($usernames as $userid => $username)
          <div class="card mb-3">
            <div class="card-body">
              <p>Total Tickets: {{ $ticketCounts[$userid] }}</p>
              <div class="table-responsive">
                <table class="table">
                  <thead>
                    <tr>
                      <th>Ticket ID</th>
                      <th>Ticket Reason</th>
                      <th>Raising Date</th>
                      <th>Status</th>
                      <th>Action</th>
                    </tr>
                  </thead>
                  @if($ticketCounts[$userid] > 0)
                    <tbody id="view-ticket"> 
                      @include('partials.user-ticket', ['tickets' => $tickets])
                    </tbody>
                  @else
                    <tr>
                      <td colspan="6">No tickets found.</td>
                    </tr>
                  @endif
                </table>
              </div>
              <div id="pagination-wrapper" class="offset-5">
                {!! $tickets->links('pagination::bootstrap-4') !!}
              </div>
              
            </div>
          </div>
        @endforeach
      </div>
    </div>
    @include('template.footer')     


