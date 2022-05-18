@extends('layouts.workerLayout')
@section('content')
    <div>
        <div class="container">
            @if (Session::get('message'))
            <div class="alert alert-success w-100 " role="alert">
                {{ Session::get('message') }}
            </div>
            @endif
            <h2 class="my-2">Complaint details</h2>
            <hr>
            <form action="{{ route('owner.answerReclamation', $reclamation->id ) }}" method="post">
                @csrf
                <p class="tag">Full Name:</p>
                <p class="value">{{ $sender->firstName }} {{ $sender->lastName }}</p>
                <p class="tag">Complaint type:</p>
                <p class="value">{{ $reclamation->problemType }}</p>
                <p class="tag">Date and time:</p>
                <p class="value">{{ $reclamation->created_at }}</p>
                <p class="tag">Message:</p>
                <p class="value">{{ $reclamation->message }}</p>
                <p class="title">Send an answer to this client:</p>
                <p class="tag">Your message:</p>
                @if(is_null($reclamation->response))
                <textarea name="response" id="" ></textarea>
                <button type="submit" class="btn btn-success mt-3">Send</button>
                @else
                <textarea name="response" id="" disabled>{{ $reclamation->response }}</textarea>
                <button disabled class="btn btn-warning mt-3">Already sent</button>
                @endif

            </form>
        </div>
    </div>
@endsection
<link rel="stylesheet" href="{{ asset('css/admin/index.css') }}">
<link rel="stylesheet" href="{{ asset('css/bootstrap.css') }}">
@section('headTags')
    
@endsection