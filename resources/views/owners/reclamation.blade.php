@extends('layouts.workerLayout')
@section('headTags')
<link rel="stylesheet" href="https://cdn.datatables.net/1.12.0/css/jquery.dataTables.css">
@endsection
@section('content')
<div class="joining-requests">
    <div class="container">
      <h2>Complaints</h2>
      <table class="table table-striped" id="complaints">
        <thead>
          <tr>
            <th>Sender</th>
            <th>Type</th>
            <th>Date</th>
            <th>Message</th>
          </tr>
        </thead>
        <tbody>
          @foreach ($list as $element)
          <tr>
            <th scope="row">{{$element ->sender}}</th>
            <td>{{$element->problemType}}</td>
            <td>{{$element ->created_at}}</td>
            <td><a href="{{ route('owner.reclamation',$element->id) }}">Details</a></td>
          </tr>
          @endforeach
        </tbody>
      
      </table>
      {{$list->links()}}
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
let table = new DataTable('#complaints');
</script>
@endsection