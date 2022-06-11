@extends('layouts.workerLayout')

@section('headTags')
<link rel="stylesheet" href="https://cdn.datatables.net/1.12.0/css/jquery.dataTables.css">
<meta name="_token" content="{{ csrf_token() }}">
@endsection

@section('content')
<div>
  <script>
    let reservations = document.querySelector('#reservations')
    reservations.classList.add('active')
  </script>
  <div class="container">
    @foreach ($fails as $fail)
    <div class="alert alert-warning w-100 alert-dismissible fade show m-2 " role="alert">
      <p>There was a failed attempt to unlock the car {{ $fail->brand }} {{ $fail->model }}
        ({{ $fail->plateNb }}), rented by {{ $fail->firstName }}
        {{ $fail->lastName }} at {{ $fail->failedDate }}.</p>
      <a class="text-decoration-underline seen" style="cursor: pointer" data-bs-dismiss="alert"
        data-bookingid="{{ $fail->bookingID }}">Set as seen</a>
    </div>
    @endforeach
    <h2>Reservation requests</h2>
    <table class="table table-striped" id="restable">
      <thead>
        <tr>
          <th>Vehicle</th>
          <th>Plate number</th>
          <th>Clients full name</th>
          <th>Pick-up location</th>
          <th>Pick-up date</th>
          <th>Action</th>
        </tr>
      </thead>
      <tbody>
        @foreach ($bookings as $element)
        <tr>
          <td>{{ $element->model }} {{ $element->brand }}</td>
          <td>{{ $element->vehiculePlateNB }}</td>
          <td>{{ $element->firstName }} {{ $element->lastName }}</td>
          <td>{{ $element->pickUpLocation }}</td>
          <td>{{ $element->pickUpDate }}</td>
          <td><a href="{{ route('secretary.reservationDetails', $element->bookingID) }}" class="link">View details</a>
          </td>
        </tr>
        @endforeach
      </tbody>
    </table>
    {{ $bookings->links() }}
  </div>
</div>
@endsection
@section('scripts')
<script src="https://code.jquery.com/jquery-3.6.0.slim.min.js"
  integrity="sha256-u7e5khyithlIdTpu22PHhENmPcRdFiHRjhAuHcs05RI=" crossorigin="anonymous"></script>
<script src="https://cdn.datatables.net/1.12.0/js/jquery.dataTables.min.js" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.4.1/jquery.js"
  integrity="sha256-WpOohJOqMqqyKL9FccASB9O0KwACQJpFTUBLTYOVvVU=" crossorigin="anonymous"></script>
<script>
  let restable = new DataTable('#restable');
      let seens = document.querySelectorAll('.seen')
      seens.forEach((e)=>{
        e.addEventListener('click',()=>{
          $.ajax({
            type: "POST",
            dataType: "json",
            url: "http://localhost:8000/secretary/setSeen",
            data: {
                '_token': $('meta[name="_token"]').attr('content'),
                'bookingID': e.dataset.bookingid
            },
        });
        })
      });

</script>
@endsection
