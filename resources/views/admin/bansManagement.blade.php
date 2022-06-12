@extends('layouts.workerLayout')
@section('headTags')
<link rel="stylesheet" href="https://cdn.datatables.net/1.12.0/css/jquery.dataTables.css">
<link rel="stylesheet" href="{{ asset('css/admin/index.css') }}">
@endsection
@section('content')
<script>
  let bannedUsers = document.querySelector('#bannedUsers')
  bannedUsers.classList.add('active')
</script>
<div class="modal fade" id="banUser" tabindex="-1" aria-labelledby="banUserLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">User ban confirmation</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <p>Are you sure you want to ban this user? </p>
        <form action="{{ route('admin.ban') }}" method="POST" id="hello">
          @csrf
          <input type="text" name="username" style="display: none" class="form-control usernamefield">
          <input type="text" disabled class="form-control usernamefield">
          <label for="">Reason :</label>
          <textarea name="reason"></textarea>
        </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="link link-secondary" data-bs-dismiss="modal">Close</button>
        <button type="button" class="link"
          onclick="document.querySelector('#hello').submit()">Confirm</button>
      </div>
    </div>
  </div>
</div>
<div class="modal fade" id="unbanUser" tabindex="-1" aria-labelledby="unbanUserLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Unban user confirmation</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <p>Are you sure you want to unban this user? </p>
        <form action="{{ route('admin.unban') }}" method="POST" id="unban">
          @csrf
          <input type="text" name="username" style="display: none" class="form-control unban-usernamefield">
          <input type="text" disabled class="form-control unban-usernamefield">

        </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="link link-secondary" data-bs-dismiss="modal">Close</button>
        <button type="button" class="link"
          onclick="document.querySelector('#unban').submit()">Confirm</button>
      </div>
    </div>
  </div>
</div>
<div>
  <div class="container">
    @if (Session::get('message'))
    <div class="alert alert-danger alert-dismissible fade show w-100" role="alert">
      <strong>{{ Session::get('message') }}</strong>
      <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
    @endif
    <h2 class="mb-4">Agency bans</h2>
    <table class="table table-striped" id="usersList">
      <thead>
        <tr>
          <th>Banned user</th>
          <th>Bans count</th>
          <th>Ban reason</th>
          <th>Action</th>
        </tr>
      </thead>
      <tbody>
        @foreach ($bans as $ban)
        <tr>
          <td>{{$ban -> firstName}} {{$ban -> lastName}}</td>
          <td>{{$ban -> nbBan}}</td>
          <td style="position: relative" class="trigger">
            <p class="view-more fullname">View more</p>
            <div class="dropmenu">
              <div class="drop-align">
                {{ $ban->reason }}
              </div>
            </div>
          </td>
          <td>
            <button class="custom-btn custom-btn-dagner" data-fullname="{{ $ban->firstName }} {{ $ban->lastName }}"
              data-un="{{ $ban->username }}" data-bs-toggle="modal" data-bs-target="#banUser">Ban</button></td>
        </tr>
        @endforeach
      </tbody>
    </table>
    {{$bans->links()}}
    <h2 class="mb-4">Banned users</h2>
    <table class="table table-striped" id="bansList">
      <thead>
        <tr>
          <th>Banned user</th>
          <th>Ban reason</th>
          <th>Action</th>
        </tr>
      </thead>
      <tbody>
        @foreach ($appbans as $ban)
        <tr>
          <td>{{$ban -> firstName}} {{$ban -> lastName}}</td>
          <td style="position: relative" class="trigger">
            <p class="view-more fullname">View more</p>
            <div class="dropmenu">
              <div class="drop-align">
                {{ $ban->reason }}
              </div>
            </div>
          </td>
          <td><button class="custom-btn custom-btn-success unbanbtn" data-fullname="{{ $ban->firstName }} {{ $ban->lastName }}"
              data-un="{{ $ban->username }}" data-bs-toggle="modal" data-bs-target="#unbanUser">Unban</button></td>
        </tr>
        @endforeach
      </tbody>
    </table>
    {{$bans->links()}}
  </div>
</div>
@endsection

@section('scripts')
<script src="https://code.jquery.com/jquery-3.6.0.slim.min.js"
  integrity="sha256-u7e5khyithlIdTpu22PHhENmPcRdFiHRjhAuHcs05RI=" crossorigin="anonymous"></script>
<script src="https://cdn.datatables.net/1.12.0/js/jquery.dataTables.min.js" crossorigin="anonymous"></script>
<script>
  let table = new DataTable('#usersList');
let bantable = new DataTable('#bansList');
const banbtns = document.querySelectorAll(".banbtn");
const fields = document.querySelectorAll(".usernamefield");


banbtns.forEach((e)=>{
    e.addEventListener('click',()=>{

        fields[0].value=e.dataset.un
        fields[1].value=e.dataset.fullname
        })
})

const unbanbtns = document.querySelectorAll(".unbanbtn");
const unfields = document.querySelectorAll(".unban-usernamefield");
unbanbtns.forEach((e)=>{
    e.addEventListener('click',()=>{
      unfields[0].value=e.dataset.un
      unfields[1].value=e.dataset.fullname
    })
})
document.querySelector('#usersList_wrapper').classList.add('mb-4')
</script>
@endsection
