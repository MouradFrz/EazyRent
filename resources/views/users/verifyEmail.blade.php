<p>THis is the go verify your email page</p>
@if (Session::get('message'))
    {{ Session::get('message') }}
@endif
<form action="{{ route('verification.send') }}" method="post"> @csrf
    <button type="submit" >Send a verification email</button>
</form>
