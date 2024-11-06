@foreach($tickets as $ticket)
    <tr>
        <td>{{ $ticket->id }}</td>
        <td>{{ $ticket->reason }}</td>
        <td>{{ $ticket->current_date }}</td>
        <td>{{$ticketStatuses[$ticket->id] }}</td>
        <td>
            <a href="{{ route('view_ticket', $ticket->id) }}" class="btn btn-sm btn-outline-light"><i class="fa-solid fa-eye" style="color: #5e8d66;"></i></a>
            <a href="{{ route('user_ticket_history', $ticket->id) }}" class="btn btn-sm btn-outline-light"><i class="fa-solid fa-clipboard-list" style="color: #75a0ea;"></i></a>
        </td>
    </tr>
@endforeach
