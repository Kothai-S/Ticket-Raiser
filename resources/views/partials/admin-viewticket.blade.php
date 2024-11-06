@foreach($tickets as $ticket)
                      <tr>
                          <td>{{ $ticket->id }}</td>
                          <td>{{ isset($usernames) ? $usernames: 'N/A' }}</td>
                          <td>{{ $ticket->reason }}</td>
                          <td>{{ $ticket->current_date }}</td>
                          <td>{{ $ticket->status }}</td>                            
                          <td>
                              <a href="{{ route('employee_view_ticket', $ticket->id) }}" class="btn btn-sm btn-outline-light"><i class="fa-solid fa-eye" style="color: #5e8d66;"></i></a>
                              <a href="{{ route('employee_view_history', $ticket->id) }}" class="btn btn-sm btn-outline-light"><i class="fa-solid fa-clipboard-list " style="color: #75a0ea;"></i></a>
                          </td>
                      </tr>
                    @endforeach


                      @if(Auth::check() && Auth::user()->parent_id == 1)
                        @foreach($assign_teamTicket as $ticket)
                          <tr>
                            <td>{{ $ticket->id }}</td>
                            <td>{{ $usernames}}</td>
                            <td>{{ $ticket->reason }}</td>
                            <td>{{ $ticket->current_date }}</td>
                            <td>{{ $ticket->status }}</td>                            
                            <td>
                              <a href="{{ route('employee_view_ticket', $ticket->id) }}" class="btn btn-sm btn-outline-light"><i class="fa-solid fa-eye" style="color: #5e8d66;"></i></a>
                              <a href="{{ route('employee_view_history', $ticket->id) }}" class="btn btn-sm btn-outline-light"><i class="fa-solid fa-clipboard-list " style="color: #75a0ea;"></i></a>
                            </td>
                          </tr>
                        @endforeach
                      @endif
                      
                     




