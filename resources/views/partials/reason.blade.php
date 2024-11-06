@foreach($reasons as $reason)
  <tr>
    <td>{{$reason->id}}</td>
    <td>{{$reason->reason}}</td>
    <td>{{ optional($reason->parent)->reason }}</td>

    
    <td>
      <a href="{{route('editReason', $reason->id)}}" class="btn btn-outline-secondary btn-sm"><i class="fa-solid fa-pen-to-square"></i></a>
      <a href="{{route('deleteReason', $reason->id)}}" class="btn btn-outline-danger btn-sm"><i class="fa-solid fa-trash"></i></a>

    </td>
  </tr>
@endforeach