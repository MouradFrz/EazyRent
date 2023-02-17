@extends('layouts.workerLayout')


@section('content')
<script>
  let branches = document.querySelector('#branches')
  branches.classList.add('active')
</script>
<div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">You are about to delete this branch </h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <p>Are you sure you want to delete this branch ? <br> Deleting the branch will DELETE all of its employees, and
          their accounts will no longer be functional</p>
      </div>
      <div class="modal-footer">
        <button type="button" class="link link-secondary" data-bs-dismiss="modal">Close</button>
        <button type="button" class="link link-danger"
          onclick="document.querySelector('#form').submit()">Confirm</button>
        <form action="{{ route('owner.deleteBranch',$branch->brancheID) }}" id="form" method="POST">@csrf</form>
      </div>
    </div>
  </div>
</div>
<div>
  <div class="container">
    <h2 class="title">Branch details</h2>
    <div>
      <p class="tag">Region:</p>
      <p class="value">{{ $branch->region }}</p>
      <p class="tag">Address:</p>
      <p class="value">{{ $branch->address }}</p>
      <p class="tag">Id:</p>
      <p class="value">{{ $branch->brancheID }}</p>
      <p class="tag">Employees count:</p>
      <p class="value">{{ count($secretaries)+count($garagists) }} ({{ count($secretaries) }} Secretaries And {{
        count($garagists) }} Garagists)</p>
    </div>
    <p class="tag">Employees list:</p>
    <div class="mt-3">
      <table class="table table-striped " id="emplist">
        <thead>
          <tr>
            <th>First name</th>
            <th>Last name</th>
            <th>Role</th>
          </tr>
        </thead>
        <tbody>
          @foreach ($secretaries as $element)
          <tr>
            <td scope="row">{{$element ->firstName}}</th>
            <td>{{$element->lastName}}</td>
            <td>Secretary</td>
          </tr>
          @endforeach
          @foreach ($garagists as $element)
          <tr>
            <td scope="row">{{$element ->firstName}}</th>
            <td>{{$element->lastName}}</td>
            <td>Garagist</td>
          </tr>
          @endforeach
        </tbody>

      </table>
    </div>
    {{$secretaries->links()}}
    {{$garagists->links()}}
    <a href="{{ route('owner.addEmployee') }}" class="btn btn-primary my-3" style="float: right">Add a new employee</a>
    <button type="button" class="btn btn-danger my-3" data-bs-toggle="modal" data-bs-target="#exampleModal">
      Delete this branch
    </button>
  </div>

</div>
@endsection

@section('headTags')
<title>Branch Details</title>
<link rel="stylesheet" href="{{ asset('css/owner/index.css') }}">
@endsection
@section('scripts')
<script src="https://code.jquery.com/jquery-3.6.0.slim.min.js"
  integrity="sha256-u7e5khyithlIdTpu22PHhENmPcRdFiHRjhAuHcs05RI=" crossorigin="anonymous"></script>
<script src="https://cdn.datatables.net/1.12.0/js/jquery.dataTables.min.js" crossorigin="anonymous"></script>
<script>
  //   $(document).ready( function () {
//     $('#joiningRequests').DataTable();
// } );
let table = new DataTable('#emplist');


</script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"
  integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>

@endsection
