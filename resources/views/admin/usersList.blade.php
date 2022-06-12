@extends('layouts.workerLayout')
@section('headTags')
<title>admin - joining requests</title>
<link rel="stylesheet" href="https://cdn.datatables.net/1.12.0/css/jquery.dataTables.css">
<link rel="stylesheet" href="{{ asset('css/app.css') }}">
<link rel="stylesheet" href="{{ asset('css/admin/index.css') }}">
@endsection
@section('content')
<script>
  let users = document.querySelector('#users')
  users.classList.add('users')
</script>
<div class="users-list">
  <div class="container">
    <h2 class="nb-4">Users list</h2>
    <table class="table table-striped" id="usersList">
      <thead>
        <tr>
          <th scope="col">ID</th>
          <th>Username</th>
          <th>First name</th>
          <th>Last name</th>
          <th>bans number</th>
        </tr>
      </thead>
      <tbody>
        @foreach ($users as $user)
        <tr>
          <th scope="row">{{$user -> id}}</th>
          <td>{{$user -> username}}</td>
          <td>{{$user -> firstName}}</td>
          <td>{{$user -> lastName}}</td>
          <td>{{$user -> nbBan}}</td>
        </tr>
        @endforeach
      </tbody>
    </table>
    {{$users->links()}}
  </div>
</div>

@endsection
@section('scripts')
<script src="https://code.jquery.com/jquery-3.6.0.slim.min.js" integrity="sha256-u7e5khyithlIdTpu22PHhENmPcRdFiHRjhAuHcs05RI=" crossorigin="anonymous"></script>
<script src="https://cdn.datatables.net/1.12.0/js/jquery.dataTables.min.js" crossorigin="anonymous"></script>
<script>
let table = new DataTable('#usersList');
</script>
@endsection


