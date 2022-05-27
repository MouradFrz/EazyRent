
@extends('layouts.workerLayout')
 @section('content')
@if (count($hasGarage)==0)
    You dont have a garage yet. contact your boss and ask him to link you with a garage.
@else
    Stats
@endif



 

 @endsection