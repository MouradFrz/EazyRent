@extends('layouts.workerLayout')
@section('headTags')
<link rel="stylesheet" href="{{ asset('css/app.css') }}">
{{-- <link rel="stylesheet" href="{{ asset('css/bootstrap.css') }}"> --}}
<link rel="stylesheet" href="{{ asset('css/owner/index.css') }}">
@endsection
@section('content')
<script>
  let branches = document.querySelector('#branches')
  branches.classList.add('active')
</script>
<!-- Button trigger modal -->


<!-- Modal -->
<div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Create a branch </h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <form action="{{ route('owner.addBranchePost') }}" method="POST" id="form">
          @csrf
          <label for="">Region</label>
          <input type="text" class="form-control" name="region">
          <label for="">Address</label>
          <input type="text" class="form-control" name="address">
        </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary" onclick="document.querySelector('#form').submit()">Confirm</button>
      </div>
    </div>
  </div>
</div>
<div class="joining-requests">
    <div class="container">
      @if(Session::get('alert'))
      <div class="alert alert-danger w-100" role="alert">
      {{ Session::get('alert') }}
      </div>
      @endif
      @if(Session::get('message'))
      <div class="alert alert-success w-100" role="alert">
      {{ Session::get('message') }}
      </div>
      @endif
      <h2>Branches management</h2>
      <hr>

      <div class="cards ">
          @if (count($branches)!=0)
          @foreach ($branches as $branche )
          <div class="card-custom">
            <ul>
                <li>Branche id : <span class="value">{{ $branche->brancheID }}</span></li>
                <li>Region: <span class="value">{{ $branche->region }}</span></li>
                <li>Address: <span class="value">{{ $branche->address }}</span></li>
                <li><a href="{{ route('owner.showBranch',$branche->brancheID) }}">View more</a></span></li>
            </ul>
        </div>
          @endforeach

          <button type="button" class="btn btn-primary" style="min-height:150px" data-bs-toggle="modal" data-bs-target="#exampleModal">
            Add a new branch
          </button>



          @else
          <p>You have no branches!</p>
          <button type="button" class="btn btn-primary"  data-bs-toggle="modal" data-bs-target="#exampleModal">
            Add a new branch
          </button>
          @endif

      </div>
    </div>
  </div>
@endsection
@section('scripts')
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
@endsection
