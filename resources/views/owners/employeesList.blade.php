@extends('layouts.workerLayout')
@section('content')
<script>
  let employees = document.querySelector('#employees')
  employees.classList.add('active')
</script>
<div class="modal fade" id="deleteSec" tabindex="-1" aria-labelledby="deleteSecLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Delete a secretary </h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <p>Are you sure you want to delete this secretary?</p>
        <form action="{{ route('owner.deleteSecretary') }}" method="POST" id="secDeleteForm">
          @csrf
          <input type="text" disabled name="fullname" class="form-control" id="secDeleteShow">
          <input type="text" name="username" style="display:none" class="form-control" id="secDeleteHide">
        </form>
        <strong class="exclamation">This operation can not be undone</strong>
      </div>
      <div class="modal-footer">
        <button type="button" class="link link-secondary" data-bs-dismiss="modal">Close</button>
        <button type="button" class="link link-danger"
          onclick="document.querySelector('#secDeleteForm').submit()">Confirm</button>
      </div>
    </div>
  </div>
</div>
<div class="modal fade" id="deleteGar" tabindex="-1" aria-labelledby="deleteGarLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Delete a garage manager </h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <p>Are you sure you want to delete this garage manager?</p>
        <form action="{{ route('owner.deleteGaragist') }}" method="POST" id="garDeleteForm">
          @csrf
          <input type="text" disabled name="fullname" class="form-control" id="garDeleteShow">
          <input type="text" name="username" style="display:none" class="form-control" id="garDeleteHide">
        </form>
        <strong class="exclamation">Deleting this garage manager WILL delete the garage that he manages</strong>
        <strong class="exclamation">This operation can not be undone</strong>
      </div>
      <div class="modal-footer">
        <button type="button" class="link link-secondary" data-bs-dismiss="modal">Close</button>
        <button type="button" class="link link-danger"
          onclick="document.querySelector('#garDeleteForm').submit()">Confirm</button>
      </div>
    </div>
  </div>
</div>
<div class="modal fade" id="transferSec" tabindex="-1" aria-labelledby="transferSecLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Transfer a secretary </h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <p>Chose the branch where you want to transfer this secretary <span class="fw-bold" id="transferSecName"></span>
        </p>
        <form action="{{ route('owner.secTransfer') }}" method="POST" id="secTransferForm">
          @csrf
          <div class="d-flex align-items-center justify-content-center">
            <input type="text" name="username" class="inputs d-none" id="secTransferHide">
            <select name="branche" class="inputs" style="width: auto;" id="secBranchList"></select>
          </div>
        </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="link link-secondary" data-bs-dismiss="modal">Close</button>
        <button type="button" class="link"
          onclick="document.querySelector('#secTransferForm').submit()">Confirm</button>
      </div>
    </div>
  </div>
</div>
<div class="modal fade" id="transferGar" tabindex="-1" aria-labelledby="transferGarLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Transfer a garage manager </h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <p>Chose the branch where you want to transfer this garage manager <span class="fw-bold"
            id="transferGarName"></span></p>
        <form action="{{ route('owner.garTransfer') }}" method="POST" id="garTransferForm">
          @csrf
          <div class="d-flex align-items-center justify-content-center">
            <input type="text" name="username" class="inputs d-none" id="garTransferHide">
            <select name="branche" class="inputs" style="width: auto" id="garBranchList">
            </select>
          </div>
        </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="link link-secondary" data-bs-dismiss="modal">Close</button>
        <button type="button" class="link"
          onclick="document.querySelector('#garTransferForm').submit()">Confirm</button>
      </div>
    </div>
  </div>
</div>
<div>
  <div class="container">
    <div class="d-flex justify-content-between align-items-center mt-4">
      <h2 class="title">Employees management</h2>
      <div>
        <a href="{{ route('owner.addEmployee') }}" class="custom-btn custom-btn-success" >
          Add a new employee
        </a>
      </div>
    </div>
    <h3 class="title">Secretaries</h3>
    @if (Session::get('message'))
    <div class="alert alert-success w-100" role="alert">
      {{ Session::get('message') }}
    </div>
    @endif
    <div>
      <table class="table table-striped" id="seclist">
        <thead>
          <tr>
            <th>First name</th>
            <th>Last name</th>
            <th>Email</th>
            <th>Branch</th>
            <th>Actions</th>
          </tr>
        </thead>
        <tbody>
          {{ $list }}
          @foreach ($list as $element)
          <tr>
            <th scope="row">{{ $element->firstName }}</th>
            <td>{{ $element->lastName }}</td>
            <td>{{ $element->email }}</td>
            <td>{{ $element->region }}</td>
            <td>
              <button class="link link-danger" onclick="getSec({{ $element->id }})" data-bs-toggle="modal"
                data-bs-target="#deleteSec">Delete</button>
              <button class="link" onclick="getSecTransfer({{ $element->id }})" data-bs-toggle="modal"
                data-bs-target="#transferSec">Transfer</button>
            </td>
          </tr>
          @endforeach
        </tbody>
      </table>
      {{$list->links()}}
    </div>
    <div class="white-space white-space-sm"></div>
    <h3 class="title">garage managers</h3>
    <div>
      <table class="table table-striped" id="garlist">
        <thead>
          <tr>
            <th>First name</th>
            <th>Last name</th>
            <th>Email</th>
            <th>Branch</th>
            <th>Actions</th>
          </tr>
        </thead>
        <tbody>
          {{ $list }}
          @foreach ($glist as $element)
          <tr>
            <th scope="row">{{ $element->firstName }}</th>
            <td>{{ $element->lastName }}</td>
            <td>{{ $element->email }}</td>
            <td>{{ $element->region }}</td>
            <td>
              <a class="link link-danger" data-bs-toggle="modal" onclick="getGar({{ $element->id }})"
                data-bs-target="#deleteGar">Delete</a>
              <a class="link" onclick="getGarTransfer({{ $element->id }})" data-bs-toggle="modal"
                data-bs-target="#transferGar">Transfer</a>
            </td>
          </tr>
          @endforeach
        </tbody>

      </table>
      {{$list->links()}}
    </div>
    <div class="white-space"></div>
  </div>
</div>
@endsection
@section('headTags')
<link rel="stylesheet" href="{{ asset('css/app.css') }}">

<link rel="stylesheet" href="{{ asset('css/owner/index.css') }}">
<link rel="stylesheet" href="https://cdn.datatables.net/1.12.0/css/jquery.dataTables.css">
@endsection
@section('scripts')
<script src="https://code.jquery.com/jquery-3.6.0.slim.min.js"
  integrity="sha256-u7e5khyithlIdTpu22PHhENmPcRdFiHRjhAuHcs05RI=" crossorigin="anonymous"></script>
<script src="https://cdn.datatables.net/1.12.0/js/jquery.dataTables.min.js" crossorigin="anonymous"></script>

<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.js"
  integrity="sha512-n/4gHW3atM3QqRcbCn6ewmpxcLAHGaDjpEBu4xZd47N0W2oQ+6q7oc3PXstrJYXcbNU1OHdQ1T7pAP+gi5Yu8g=="
  crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"
  integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
<script>
  let sectable = new DataTable('#seclist');
  let gartable = new DataTable('#garlist');

</script>
<script>
  function getSec(e){
      $.get(`getSecUsername/${e}`,function(data){
        document.querySelector('#secDeleteShow').value=`${data.firstName} ${data.lastName} (${data.username})`
        document.querySelector('#secDeleteHide').value=data.username
      })
    }
    function getGar(e){
      $.get(`getGarUsername/${e}`,function(data){
        document.querySelector('#garDeleteShow').value=`${data.firstName} ${data.lastName} (${data.username})`
        document.querySelector('#garDeleteHide').value=data.username
      })
    }
    function getSecTransfer(e){
      $.get(`getSecTransfer/${e}`,function(data){
        document.querySelector('#transferSecName').innerText=`(${data[1].firstName} ${data[1].lastName})`
        document.querySelector('#secTransferHide').value=data[1].username
        let list = document.querySelector('#secBranchList')
        list.innerText='';
        data[0].forEach((e)=>{
          const element = document.createElement("option");
          element.value=e.brancheID;
          element.innerText=e.region;
          list.appendChild(element);
        });

      })
    }

    function getGarTransfer(e){
      $.get(`getGarTransfer/${e}`,function(data){
        document.querySelector('#transferGarName').innerText=`(${data[1].firstName} ${data[1].lastName})`
        document.querySelector('#garTransferHide').value=data[1].username
        let list = document.querySelector('#garBranchList')
        list.innerText='';
        data[0].forEach((e)=>{
          const element = document.createElement("option");
          element.value=e.brancheID;
          element.innerText=e.region;
          list.appendChild(element);
        });

      })
    }

</script>
@endsection
