@include('template.header')

<div class="main-panel">
    <div class="content-wrapper">
        <div class="row">
            <div class="col-md-8">
                <div class="card mb-3">
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th>S.No</th>
                                        <th>Ticket ID</th>
                                        <th>Assigning Admin</th>
                                        <th>Date</th>
                                        <th>Status</th>
                                    </tr>
                                </thead>
                                @if(isset($ticketHistory) && $ticketHistory->count() > 0)
                                    @foreach($ticketHistory as $history)

                                        <tr>
                                            <td>
                                                {{ $history->id }}
                                            </td>
                                            <td>
                                                {{ $history->ticket_id }}
                                            </td>
                                            @if($history->status == 'pending')
                                                <td> Not Assigned </td>
                                            @else
                                                <td> {{$adminName }} </td>
                                            @endif

                                            <td>
                                                {{ $history->date }}
                                            </td>
                                            <td>
                                                {{ $history->status }}
                                            </td>
                                        </tr>
                                    @endforeach
                                @else
                                    <tr>
                                        <td colspan="6">No tickets found.</td>
                                    </tr>
                                @endif
                            </table>

                        </div>
                    </div>
                </div>
            </div>
        </div>

        @include('template.footer')