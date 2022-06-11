@extends('layouts.workerLayout')
@section('headTags')
<title>Owner - Homepage</title>
<link rel="stylesheet" href="{{ asset('css/app.css') }}">
<link rel="stylesheet" href="{{ asset('css/owner/index.css') }}">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css"
  integrity="sha512-KfkfwYDsLkIlwQp6LFnl8zNdLGxu9YAA1QvwINks4PhcElQSvqcyVLLD9aMhXd13uQjoXtEKNosOWaZqXgel0g=="
  crossorigin="anonymous" referrerpolicy="no-referrer" />
@endsection
@section('content')
@if (Auth::user()->agencyID)
<script>
  let agencyStats = document.querySelector('#agencyStats')
  agencyStats.classList.add('active')
</script>
<div class="dashboard">
  <div class="container">
    <h2 class="my-4">{{ $Request->name }}</h2>
    <div class="stats">
      <div class="stats_item" id="reservationsLastWeek">
        <h6 class="stats_header">reservations in last week</h6>
        <canvas id="lineChart"></canvas>
      </div>
      <div class="stats_item" id="reseravtionsPerBranch">
        <h6 class="stats_header">reservations per branch</h6>
        <canvas id="myChart" class="circle-chart"></canvas>
      </div>
      <div class="stats_item" id="argentPerBranch">
        <h6 class="stats_header">Argent gagne par chaque branche</h6>
        <canvas id="mpb" class="circle-chart"></canvas>
      </div>
      <div class="stats_item">
        <h6 class="stats_header">pick up locations</h6>
        <canvas id="pickUpLocations"></canvas>
      </div>
    </div>
    <div class="white-space"></div>
    <div class="row stickers">
      <div class="col sticker">
        <h6 class="sticker_header">branches</h6>
        <div class="sticker_content">
          <div class="sticker_icon">
            <i class="fa-solid fa-code-branch"></i>
          </div>
          <div class="sticker_details">
            {{ $branchCount }} branches
          </div>
        </div>
      </div>
      <div class="col sticker">
        <h6 class="sticker_header">garages</h6>
        <div class="sticker_content">
          <div class="sticker_icon">
            <i class="fa-solid fa-warehouse"></i>
          </div>
          <div class="sticker_details">
            {{ $garageCount }} garages
          </div>
        </div>
      </div>
      <div class="col sticker">
        <h6 class="sticker_header">employees</h6>
        <div class="sticker_content">
          <div class="sticker_icon">
            <i class="fa-solid fa-people-group"></i>
          </div>
          <div class="sticker_details">
            {{ $secCount+$managerCount }} employee <br>
            {{ $secCount}} secretary <br> {{ $managerCount }} Garage manager
          </div>
        </div>
      </div>
      <div class="col sticker">
        <h6 class="sticker_header">pick up locations</h6>
        <div class="sticker_content">
          <div class="sticker_icon">
            <i class="fa-solid fa-warehouse"></i>
          </div>
          <div class="sticker_details">
            {{ $pulCount }} pick up location
          </div>
        </div>
      </div>
    </div>
    <div class="white-space"></div>
    <div class="mostRentedcars">
      <h3>Most rented cars</h3>
      <div class="cars row">
        @foreach ($mostRentedCars as $car)
        <div class="col car card">
          <p class="text-center mb-2"><strong>{{ $car->brand }} {{ $car->model }}</strong></p>
          <div class="img">
            <img src="{{ asset('images/vehicules/imagePaths/'.$car->imagePath) }}" id="car image" alt="">
          </div>
          <div class="content">
            <p> <strong>Rating : </strong> {{ $car->rating }}</p>
            <p> <strong>Bookings count : </strong>{{ $car->bookCount }}</p>
          </div>
        </div>
        @endforeach
      </div>
    </div>
    <div class="white-space"></div>
    <div class="reviews">
      <h3>Latest 5 reviews for my cars</h3>
      <div class="reveiws row">
        @foreach ($reviews as $booking)
        @if ($booking->state == "FINISHED")
        <div class="review card col-12 col-md-4">
          <div class="img">
            <img src="{{ asset('images/users/faceIdImages/'. $booking->faceIdPath) }}" id="user-icon"
              alt="user image is not available">
          </div>
          <div class="content">
            <p class="client-name">{{ $booking->firstName }} {{ $booking->lastName }}</p>
            <div class="comment">
              <p>{{ $booking->vehiculeComment }}.</p>
            </div>
            <div class="rating">
              <strong>Rating : </strong>
              @for($c=1;$c<=5;$c++) @if($booking->vehiculeRating >= $c)
                <i class="fa-solid fa-star" style="color:darkorange;font-size:0.8rem;"></i>
                @else
                <i class="fa-solid fa-star" style="font-size:0.8rem;"></i>
                @endif
                @endfor
                <span>{{$booking->vehiculeRating}}</span>
            </div>
            <div class="date">
              <strong>Booking date : </strong>
              <span>{{ $booking->commentDate }}</span>
            </div>
          </div>
        </div>
        @endif
        @endforeach
      </div>
    </div>
    <div class="white-space"></div>
  </div>
</div>

@elseif (!is_null($Request))
@if($Request->state =="ON GOING")
<div class="no-agency">
  <div class="container d-flex align-items-center justify-content-center">
    <div class="alert" role="alert" style="border:2px dashed rgb(130, 179, 139);background-color:rgb(130, 179, 139)">
      <p> Your request is being processed by our administrators. Please comeback later</p>
      <a href="{{ route('owner.logout') }}"
        onclick="event.preventDefault();document.getElementById('logout-form').submit();" class="btn btn-warning"
        style="float:right"> Logout</a>
      <form action="{{ route('owner.logout') }}" id="logout-form" method="post" style="display: none">@csrf</form>
    </div>
  </div>
</div>
@elseif($Request->state =="REFUSED")
<div class="no-agency">
  <div class="container d-flex align-items-center justify-content-center">
    <div class="alert" role="alert" style="border:2px dashed rgb(179, 133, 130);background-color:rgb(179, 148, 130)">
      <p> Your request was refused because of invalid or missing informations.</p>
      <a href="{{ route('owner.logout') }}"
        onclick="event.preventDefault();document.getElementById('logout-form').submit();" class="btn btn-warning"
        style="float:right"> Logout</a>
      <form action="{{ route('owner.logout') }}" id="logout-form" method="post" style="display: none">@csrf</form>
    </div>
  </div>
</div>
@endif

@else
<div class="no-agency">
  <div class="container">
    <div class="alert" role="alert">
      <p>
        It seem's that You don't have an agency yet!
        <br>
        Click the button below to add your agency now!
      </p>
      <br>
      <a class="custom-btn" href="{{ route('owner.createAgency') }}">
        Add agency Now!
      </a>
    </div>
  </div>
</div>
@endif

@endsection

@section('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
  var sites = {!! json_encode($branches, JSON_HEX_TAG) !!}

  const labels = [];
  sites.forEach((e)=>{
    labels.push(e.address);
  });
  const data = {
    labels: labels,
    datasets: [{
      // label: 'My First dataset',
      backgroundColor: [
      'rgb(255, 99, 132)',
      'rgb(54, 255, 60)'
    ],
    hoverOffset: 4,
      data: [],
    }]
  };
  sites.forEach((e)=>{
    data.datasets[0].data.push(e.Co);
  });

  const config = {
    type: 'doughnut',
    data: data,
    options: {

    }
  };
  const myChart = new Chart(
    document.getElementById('myChart'),
    config
  );
</script>
<script>
  var reservationsPerDay = {!! json_encode($resPerDay, JSON_HEX_TAG) !!}
  var dates = {!! json_encode($dates, JSON_HEX_TAG) !!}

  const labels1 = [];
 dates.forEach((e,i)=>{
  labels1[6-i]=e
 })

const data1 = {
  labels: labels1,
  datasets: [{
    label: 'Count of reservations per day for the past 7 days.',
    data: [],
    borderColor: 'rgb(255, 192, 192)',
    backgroundColor:'rgb(0, 0, 192)',

    tension: 0.3
  }]
};
reservationsPerDay.forEach((e,i,a)=>{
    data1.datasets[0].data.push(a[6-i][0].Co);
  });
const config1 = {
  type: 'line',
  data: data1,
};
const lineChart = new Chart(
    document.getElementById('lineChart'),
    config1
  );
</script>
<script>
  var mpb = {!! json_encode($moneyPerBranch, JSON_HEX_TAG) !!}

const labels2 = [];
mpb.forEach((e)=>{
  labels2.push(e.address);
});
const data2 = {
  labels: labels2,
  datasets: [{
    label: 'Money by branche',
    backgroundColor: [
    'rgb(255, 99, 132)',
    'rgb(54, 255, 60)',
  ],
  hoverOffset: 4,
    data: [],
  }]
};
mpb.forEach((e)=>{
  data2.datasets[0].data.push(e.Total);
});


const config2 = {
  type: 'doughnut',
  data: data2,
  options: {

  }
};
const myChart2 = new Chart(
  document.getElementById('mpb'),
  config2
);
</script>
<script>
  var pickUpLocationsCount = {!! json_encode($pickUpLocationsCount, JSON_HEX_TAG) !!}
  const labels3 = [];

  pickUpLocationsCount.forEach((e)=>{
    labels3.push(e.address_address)
  });
const data3 = {
  labels: labels3,
  datasets: [{
    label: 'Bookings per pick up location',
    data: [],
    backgroundColor: [
      'rgba(255, 99, 132, 0.2)',
      'rgba(255, 159, 64, 0.2)',
      'rgba(255, 205, 86, 0.2)',
      'rgba(75, 192, 192, 0.2)',
      'rgba(54, 162, 235, 0.2)',
      'rgba(153, 102, 255, 0.2)',
      'rgba(201, 203, 207, 0.2)'
    ],borderColor: [
      'rgb(255, 99, 132)',
      'rgb(255, 159, 64)',
      'rgb(255, 205, 86)',
      'rgb(75, 192, 192)',
      'rgb(54, 162, 235)',
      'rgb(153, 102, 255)',
      'rgb(201, 203, 207)'
    ],
    borderWidth: 1
  }]
};
pickUpLocationsCount.forEach((e)=>{
    data3.datasets[0].data.push(e.Co);
  });

const config3 = {
  type: 'bar',
  data: data3,
  options: {
    scales: {
      y: {
        beginAtZero: true
      }
    }
  },
};
const barChart = new Chart(
  document.getElementById('pickUpLocations'),
  config3
);
</script>
@endsection
