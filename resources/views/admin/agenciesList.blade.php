@extends('layouts.workerLayout')
@section('headTags')
<title>admin - agencies</title>
<link rel="stylesheet" href="https://cdn.datatables.net/1.12.0/css/jquery.dataTables.css">
<link rel="stylesheet" href="{{ asset('css/app.css') }}">
<link rel="stylesheet" href="{{ asset('css/admin/index.css') }}">
@endsection
@section('content')
<script>
  let agencies = document.querySelector('#agencies')
  agencies.classList.add('active')
</script>
<div class="agencies-list">
  <div class="container">
    <h2>agencies list</h2>
    @if (Session::get('fail'))
    <div class="alert alert-danger w-100 alert-dismissible fade show" role="alert">
      {{ Session::get('fail') }}
      <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
    @endif
    @if (Session::get('success'))
    <div class="alert alert-success w-100 alert-dismissible fade show" role="alert">
      {{ Session::get('success') }}
      <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
    @endif
    <table class="table table-striped" id="agenciesList">
      <thead>
        <tr>
          <th scope="col">ID</th>
          <th>name</th>
          <th>owner</th>
          <th>rating</th>
          <th>rating NB</th>
          <th>Creation year</th>
          <th>joining date</th>
        </tr>
      </thead>
      <tbody>
        @foreach ($agencies as $agency)
        <tr>
          <th scope="row">{{$agency -> agencyID}}</th>
          <td>{{$agency -> name}}</td>
          <td>{{$agency -> firstName }} {{$agency -> lastName }}</td>
          <td> @if(is_null($agency -> rating)) No rating @endif</td>
          <td>@if (is_null($agency -> ratingNB)) no rating @endif</td>
          <td>{{$agency -> creationYear}}</td>
          <td>{{$agency -> created_at}}</td>
          </form>
        </tr>
        @endforeach
      </tbody>
    </table>
    {{$agencies->links()}}
  </div>
</div>

@endsection
@section('scripts')
<script src="https://code.jquery.com/jquery-3.6.0.slim.min.js"
  integrity="sha256-u7e5khyithlIdTpu22PHhENmPcRdFiHRjhAuHcs05RI=" crossorigin="anonymous"></script>
<script src="https://cdn.datatables.net/1.12.0/js/jquery.dataTables.min.js" crossorigin="anonymous"></script>
<script>
  //   $(document).ready( function () {
//     $('#joiningRequests').DataTable();
// } );
let table = new DataTable('#agenciesList');
</script>
@endsection
