@include('template.admin_header')

<div class="main-panel">
    <div class="content-wrapper">
        <div class="row">
            <div class="col-md-8">
                <div class="card mb-3">
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table ">
                                <thead>
                                    <tr>
                                        <th>S.No</th>
                                        <th>Ticket ID</th>
                                        <th>Status</th>
                                        <th>Assigning Admin</th>
                                        <th> Date</th>


                                    </tr>
                                </thead>
                                <tbody>
                                    
                                        @foreach($history as $item)
                                        <tr>
                                        <td>
                                            {{ $item->id }}
                                        </td>   
                                        <td>
                                            {{ $item->ticket_id }}
                                        </td>
                                        <td>
                                            {{ $item->status }}
                                        </td>
                                        @if($item->status == 'pending')
                                                <td> Not Assigned </td>
                                            @else
                                                <td> {{$adminName }} </td>
                                            @endif
                                       


                                        <td>
                                            {{ $item->date }}
                                        </td>
                                        </tr>
                                        @endforeach
                                    
                                </tbody>
                            </table>


                        </div>
                    </div>
                </div>
            </div>
        </div>


        @include('template.footer')