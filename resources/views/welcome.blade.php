@extends('layouts.welcome')

@section('content')
<div class="content">
    <div class="title m-b-md">
        TuVoz
    </div>

    <div class="links">
        <a href="{{ route('web.login') }}">Login</a>     
        <a href="https://gitlab.com/frankjosue.vigilvega/voicerecord">GitHub</a>
    </div>
    
</div>
@endsection