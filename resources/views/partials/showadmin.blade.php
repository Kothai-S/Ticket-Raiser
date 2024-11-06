
@foreach($admins as $admin)
    <tr>
        <td>{{ $admin->id }}</td>
        <td>{{ $admin->name }}</td>
        <td>{{ $admin->email }}</td>
        <td>{{ optional($admin->parent)->name }}</td>
        <td>{{ $admin->status_admin}}</td>
        <td>
            <a href="{{route('adminedit', $admin->id)}}" class="btn btn-outline-secondary btn-sm"><i class="fa-solid fa-pen-to-square"></i></a>
            <a href="{{route('admindelete', $admin->id)}}" class="btn btn-outline-danger btn-sm"><i class="fa-solid fa-trash"></i></a>
        </td>
    </tr>
@endforeach