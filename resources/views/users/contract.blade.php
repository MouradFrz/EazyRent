<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
</head>

<body>
    <h1>EAZY RENT</h1>
    <h2>Rental Contract</h2>
    <br>
    
    <p> This Car Rental Agreement is made and entered into as of {{ now() }}, between
        {{ $userFirstName }} {{ $userLastName }} (Renter), and {{ $secFirstName }}
        {{ $secLastName }}
        working for {{ $agencyName }}
        (Owner). Owner and Renter may also be
        referred to as “Party” in the singular and “Parties” in the plural. This Agreement is subject to the following
        terms
        and
        conditions:
    </p>
    <b>Rental Vehicle</b> <br>
    <p>
        Owner hereby agrees to rent to Renter the following vehicle : <br>
        Make: <b>{{ $brand }}</b> <br> Model: <b>{{ $model }}</b> <br>
        Year: <b>{{ $year }}</b> <br> Color: <b>{{ $color }}</b><br>

        Plate number: <b>{{ $plateNb }}</b> <br> <br>
        <b>Rental Period</b> <br>
    <p>
        Owner agrees to rent Vehicle to Renter for the following period: <br>
        Start Date: <b>{{ $pickUpDate }}</b> <br> End Date: <b>{{ $dropOffDate }}</b> <br>
        The Parties agrees that this Agreement terminates upon the End Date specified above. Notwithstanding anything to
        the contrary in this Agreement or any Exhibits, either Party may terminate this Agreement prior to the End Date
        with
        at least one (1) day notice. If this Agreement is terminated prior to the End Date, the Parties will work
        together to
        determine whether a refund of Rental Fees is necessary.
    </p>
    </p> 
    <b>Rental fees</b> <br> 
    <p>
        The Renter hereby agrees to pay the Owner for use of the Vehicle as follows: <br>
    Price per day: {{ $pricePerDay }} DZD  <br>
    Price per hour: {{ $pricePerHour }} DZD <br>
    Fuel: Renter shall pay for the use of fuel. <br>
    Total price : {{ $bookingPrice }} DZD <br> 
        <br>
    <b>Insurance</b> <br> 
    <p>The Renter hereby warrants to Owner that Renter possess car insurance that covers personal injury to Renter or
        other persons as well as the Vehicle and the property of others. </p>


    </p>

    <div class="d-flex justify-content-between">
        
        <div class="d-flex flex-column align-items-center justify-content-center">
            <p> Secretary signature </p> 
            <p> <b> Signed By {{ $secFirstName }} {{ $secLastName }}</b>  </p>
          </div>
          <div class="d-flex flex-column align-items-center justify-content-center">
            <p> Renter signature </p> 
            @isset($signature)
                <b>Signed By {{ $userFirstName }} {{ $userLastName }} </b> 
            @endisset
          </div>
    </div>


</body>

</html>
