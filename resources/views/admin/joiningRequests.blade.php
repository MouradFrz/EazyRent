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
    <table class="table" id="joiningRequests">
      <thead>
        <tr>
          <th scope="col">ID</th>
          <th scope="col">name</th>
          <th scope="col">Registry NB</th>
          <th scope="col">registeration date</th>
          <th scope="col">creation Year</th>
          <th scope="col">owner</th>
        </tr>
      </thead>
      <tbody>
        @foreach ($joiningRequests as $request)
        <tr>
          <th scope="row">{{$request -> requestID}}</th>
          <td>{{$request -> name}}</td>
          <td>{{$request -> registeryNB}}</td>
          <td>{{$request -> registrationDate}}</td>
          <td>{{$request -> creationYear}}</td>
          <td>{{$request -> ownerUsername}}</td>
        </tr>
        @endforeach
      </tbody>
    </table>
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

