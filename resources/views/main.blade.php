@extends('layouts.welcome')

@section('content')
<div class="content">
    <div class="links">
        <a target="_blank" href="{{ url('/api/doc') }}">Docs</a>        
        <a href="https://gitlab.com/frankjosue.vigilvega/voicerecord">GitHub</a>
    </div>

    <div class="title m-b-md">
        {{ "API TuVoz" }}
    </div>

    

    <div class="links">
    @if ($users)
    <ul right>
         <li><b>Nombre:</b>          {{$users->name }}</li>
         <li> <b> Email: </b>        {{$users->email}}</li>
         <li> <b> Role: </b>        {{$users->role}}</li>
         <li> <b> Identificador </b> {{ $users->identificador}}</li>
         <li> <b> Tokend </b>        {{ $users->remember_token}}</li>

    </ul>
    @endif
    </div>
</div>
@endsection