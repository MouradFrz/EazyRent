@extends('layouts.workerLayout')
@section('headTags')
<title>admin - joining requests</title>
<link rel="stylesheet" href="https://cdn.datatables.net/1.12.0/css/jquery.dataTables.css">
<link rel="stylesheet" href="{{ asset('css/app.css') }}">
<link rel="stylesheet" href="{{ asset('css/admin/index.css') }}">
@endsection
@section('content')
<div class="joining-requests">
  <div class="container">
    <h2>joining Requests</h2>
    <table class="table table-striped" id="joiningRequests">
      <thead>
        <tr>
          <th scope="col">ID</th>
          <th>Name</th>
          <th>Registry NB</th>
          <th>Registeration date</th>
          <th>Creation year</th>
          <th>Owner</th>
          <th>Action</th>
        </tr>
      </thead>
      <tbody>
        @foreach ($joiningRequests as $jr)
        <tr>
          <th scope="row">{{$jr -> requestID}}</th>
          <td>{{$jr -> name}}</td>
          <td>{{$jr -> registeryNB}}</td>
          <td>{{$jr -> registrationDate}}</td>
          <td>{{$jr -> creationYear}}</td>
          <td>{{$jr -> ownerUsername}}</td>
          <td class="d-flex justify-content-between">
            {{-- <a class="logout" href="{{ route('admin.accept') }}" onclick="event.preventDefault();
                document.getElementById('logout-form').submit();" >
              accept
            </a>
            <form action="{{ route('admin.accept') }}" id="logout-form" method="post">@csrf</form></td> --}}
            {{-- @php $requestID = $jr-> requestID @endphp --}}
            <form action="{{route('admin.acceptAgency', ['id' => $jr -> requestID ]  ) }}" method="post">
              @csrf
              @method('POST')
              <button type="sybmit" class="btn btn-primary" href="{{route('admin.acceptAgency', $jr->requestID) }}">accept</button>
            </form>
            <form action="{{route('admin.refuseAgency', ['id' => $jr -> requestID ]  ) }}" method="post">
              @csrf
            <button type="submit" class="btn btn-danger" href="{{route('admin.refuseAgency', $jr->requestID)}}">
              refuse
            </button>
          </form>
        </tr>
        @endforeach
      </tbody>
    </table>
    {{$joiningRequests->links()}}
  </div>
</div>

@endsection
@section('scripts')
<script src="https://code.jquery.com/jquery-3.6.0.slim.min.js" integrity="sha256-u7e5khyithlIdTpu22PHhENmPcRdFiHRjhAuHcs05RI=" crossorigin="anonymous"></script>
<script src="https://cdn.datatables.net/1.12.0/js/jquery.dataTables.min.js" crossorigin="anonymous"></script>
<script>
//   $(document).ready( function () {
//     $('#joiningRequests').DataTable();
// } );
let table = new DataTable('#joiningRequests');
</script>
@endsection

