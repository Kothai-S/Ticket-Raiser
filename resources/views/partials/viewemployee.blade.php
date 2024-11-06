@if(count($users) > 0)
    @foreach($users as $user)
        <tr>
            <td>{{ $user->id }}</td>
            <td>{{ $user->name }}</td>
            <td>{{ $user->email }}</td>
            <td>{{ $user->status}}</td>
            <td>
                <a href="{{ route('edituser', $user->id) }}" class="btn btn-outline-secondary btn-sm"><i class="fa-solid fa-pen-to-square"></i></a>
                <a href="{{ route('deleteuser', $user->id) }}" class="btn btn-outline-danger btn-sm"><i class="fa-solid fa-trash fa-2xs"></i></a>
            </td>
            <!-- <td>
                <a href="{{ route('ticket_details', ['id' => $user->id]) }}" class="btn btn-outline-light btn-sm"><i class="fa-solid fa-clipboard-list fa-lg" style="color: #75a0ea;"></i></a>
            </td> -->

        </tr>
    @endforeach
@endif