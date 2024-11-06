
@include('template.admin_header')

<div class="main-panel">
<div class="content-wrapper">
    <div class="row">
        <div class="col-md-10 grid-margin stretch-card">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title">Tickets</h4>
                    <div class="row">
                        <div class="col-md-3">
                            <div class="input-group mb-3">
                            <input type="text" class="form-control rounded-pill form-input" id="searchStatus" placeholder="Search Status" aria-label="search" aria-describedby="search">
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="input-group mb-3">
                            <input type="text" class="form-control rounded-pill form-input" id="searchTicket" placeholder="Search Ticket" aria-label="search" aria-describedby="search">
                            </div>
                        </div>
                    </div>

                    <div class="table-responsive">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>S.No</th>
                                    <th>Employee Name</th>
                                    <th>Ticket Reason</th>
                                    <th>Raising Date</th>
                                    <th>Status</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>

                                @if(isset($ticketFull) && $ticketFull->count() > 0)
                                @foreach($ticketFull as $ticket)
                                <tr class="product" data-employee="{{ $usernames[$ticket->userid] }}">
                                    <td>{{ $ticket->id }}</td>
                                    <td>{{ $usernames[$ticket->userid] }}</td>
                                    <td>{{ $ticket->reason }}</td>
                                    <td>{{ $ticket->current_date }}</td>
                                    <td>{{  $ticketStatuses[$ticket->id] }}</td>

                                    <td>
                                        <a href="{{ route('employee_view_ticket', $ticket->id) }}" class="btn btn-sm btn-outline-light"><i class="fa-solid fa-eye" style="color: #5e8d66;"></i></a>
                                        <a href="{{ route('employee_view_history', $ticket->id) }}" class="btn btn-sm btn-outline-light"><i class="fa-solid fa-clipboard-list" style="color: #75a0ea;"></i></a>
                                    </td>
                                </tr>
                                @endforeach
                                @else
                                <tr>
                                    <td colspan="6">No tickets found.</td>
                                </tr>
                                @endif

                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>



<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
  <script>
    $(document).ready(function() {
        $('#searchStatus').on('keyup', function() {
            var value = $(this).val().toLowerCase();
            $('table tbody tr').filter(function() {
                $(this).toggle($(this).find('td').eq(4).text().toLowerCase().indexOf(value) > -1)
            });
        });

        $('#searchTicket').on('keyup', function() {
            var value = $(this).val().toLowerCase();
            $('table tbody tr').filter(function() {
                $(this).toggle($(this).find('td').eq(2).text().toLowerCase().indexOf(value) > -1)
            });
        });
    });
  </script>

@include('template.footer')
