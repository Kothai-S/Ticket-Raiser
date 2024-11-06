@include('template.admin_header')

<div class="main-panel">
  <div class="content-wrapper">
    <div class="row">
      <div class="col-md-12 grid-margin stretch-card">
        <div class="card">
          <div class="card-body">
            <h4 class="card-title">Tickets</h4>
            <div class="row">
              <div class="col-md-3">
                <div class="input-group mb-3">
                  <input type="text" class="form-control rounded-pill form-input" id="searchStatus"
                    placeholder="Search Status" aria-label="search" aria-describedby="search">
                </div>
              </div>
              <div class="col-md-3">
                <div class="input-group mb-3">
                  <input type="text" class="form-control rounded-pill form-input" id="searchTicket"
                    placeholder="Search Ticket" aria-label="search" aria-describedby="search">
                </div>
              </div>
            </div>


            <div class="row">
              <div class="col-md-12">
                <div class="table-responsive">
                  <table class="table" id="ticketsTable">
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
                    @if(isset($tickets) && $tickets->count() > 0)
            <tbody id="ticketsBody">
              @foreach($tickets as $ticket)

          <tr class="ticket-row">
          <td>{{ $ticket->id }}</td>
          <td>{{ isset($usernames[$ticket->userid]) ? $usernames[$ticket->userid] : 'N/A' }}</td>
          <td>{{ $ticket->reason }}</td>
          <td>{{ $ticket->current_date }}</td>
          <td>{{ $ticketStatuses[$ticket->id] }}</td>
          <td>
          <a href="{{ route('employee_view_ticket', $ticket->id) }}"
          class="btn btn-sm btn-outline-light"><i class="fa-solid fa-eye"
            style="color: #5e8d66;"></i></a>
          <a href="{{ route('employee_view_history', $ticket->id) }}"
          class="btn btn-sm btn-outline-light"><i class="fa-solid fa-clipboard-list "
            style="color: #75a0ea;"></i></a>
          </td>
          </tr>

        @endforeach


              @if(Auth::check() && Auth::user()->parent_id == 1)
          @if (is_array($assign_teamTicket) || is_object($assign_teamTicket))
        @foreach($assign_teamTicket as $ticket)
      <tr class="ticket-row">
      <td>{{ $ticket->id }}</td>
      <td>{{ isset($usernames[$ticket->userid]) ? $usernames[$ticket->userid] : 'N/A' }}</td>
      <td>{{ $ticket->reason }}</td>
      <td>{{ $ticket->current_date }}</td>
      <td>{{ $ticketStatuses[$ticket->id] }}</td>
      <td>
      <a href="{{ route('employee_view_ticket', $ticket->id) }}"
      class="btn btn-sm btn-outline-light"><i class="fa-solid fa-eye"
      style="color: #5e8d66;"></i></a>
      <a href="{{ route('employee_view_history', $ticket->id) }}"
      class="btn btn-sm btn-outline-light"><i class="fa-solid fa-clipboard-list "
      style="color: #75a0ea;"></i></a>
      </td>
      </tr>
    @endforeach
      @endif
        @endif
            </tbody>

          @else
      <tr>
        <td colspan="6">No tickets found.</td>
      </tr>
    @endif

                  </table>
                </div>
                <div class="pagination-wrapper offset-5">
                  <button id="prevPage" class="btn btn-outline-light">Previous</button>
                  <button id="nextPage" class="btn btn-outline-light">Next</button>
                </div>
              </div>
              </di>
            </div>
          </div>

        </div>
      </div>
    </div>
 

@include('template.footer')

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script>
  $(document).ready(function () {
    const rowsPerPage = 10;
    let currentPage = 1;

    function showPage(page) {
      const rows = $('.ticket-row');
      rows.hide();
      rows.slice((page - 1) * rowsPerPage, page * rowsPerPage).show();
    }

    function updatePaginationButtons() {
      $('#prevPage').prop('disabled', currentPage === 1);
      $('#nextPage').prop('disabled', currentPage === Math.ceil($('.ticket-row').length / rowsPerPage));
    }

    $('#searchInput').on('input', function () {
      var searchText = $(this).val().toLowerCase();
      $('.ticket-row').each(function () {
        var employeeName = $(this).find('td:nth-child(2)').text().toLowerCase();
        if (employeeName.includes(searchText) || searchText === '') {
          $(this).show();
        } else {
          $(this).hide();
        }
      });
      currentPage = 1;
      showPage(currentPage);
      updatePaginationButtons();
    });

    $('#prevPage').on('click', function () {
      if (currentPage > 1) {
        currentPage--;
        showPage(currentPage);
        updatePaginationButtons();
      }
    });

    $('#nextPage').on('click', function () {
      if (currentPage < Math.ceil($('.ticket-row').length / rowsPerPage)) {
        currentPage++;
        showPage(currentPage);
        updatePaginationButtons();
      }
    });

    showPage(currentPage);
    updatePaginationButtons();
  });
</script>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script>
  $(document).ready(function () {
    $('#searchStatus').on('keyup', function () {
      var value = $(this).val().toLowerCase();
      $('table tbody tr').filter(function () {
        $(this).toggle($(this).find('td').eq(4).text().toLowerCase().indexOf(value) > -1)
      });
    });

    $('#searchTicket').on('keyup', function () {
      var value = $(this).val().toLowerCase();
      $('table tbody tr').filter(function () {
        $(this).toggle($(this).find('td').eq(2).text().toLowerCase().indexOf(value) > -1)
      });
    });
  });
</script>