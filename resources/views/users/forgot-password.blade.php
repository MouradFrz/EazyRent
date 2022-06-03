



@if (Session::get('status'))
{{ Session::get('status') }} 
<br>
@else
<form action="{{ route('password.request') }}" method="post">@csrf
    <input type="text" name="email">
    <button type="submit">submit</button>
@error('email')
    {{ $message }}
@enderror
    
</form>

@endif