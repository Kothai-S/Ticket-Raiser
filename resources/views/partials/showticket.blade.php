@foreach($ticket_raise as $ticket)
                          <tr class="product" data-employee="{{ $usernames[$ticket->userid] }}" data-assign-admin="{{ $ticket->assign_admin }}">
                            <td>{{ $ticket->id }}</td>
                            <td>{{ $usernames[$ticket->userid] }}</td>
                            <td>{{ $ticket->reason }}</td>
                            <td>
                              <select class="form-control admin-select" data-ticket-id="{{ $ticket->id }}">
                                @foreach($adminNames as $adminId => $adminName)
                                  <option value="{{ $adminId }}" {{ $adminId == $ticket->assign_admin ? 'selected' : '' }}>{{ $adminName }}</option>
                                @endforeach
                              </select>
                            </td>
                            <td>
                              <button class="btn btn-outline-secondary assign-btn" @if($ticket->assign_admin) disabled @endif>Assign</button>
                            </td>
                            @if($showLink)
                              <td>
                                @if($ticket->link)
                                  <a href="{{ $ticket->link }}">{{ $ticket->link }}</a>
                                @endif
                              </td>
                            @endif
                            @if($showImage)
                              <td>
                                @if($ticket->image)
                                  <img src="{{ asset('images/' . $ticket->image) }}" alt="Ticket Image" width="50" height="50">
                                @endif
                              </td>
                            @endif
                          </tr>
                        @endforeach