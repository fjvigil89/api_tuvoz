@extends('layouts.welcome')

@section('content')
    <div class="content">
        <div class="links">
            <a target="_blank" href="{{ url('/api/doc') }}">Docs</a>
            <a href="https://gitlab.com/frankjosue.vigilvega/voicerecord">GitHub</a>
        </div>

        <div class="title m-b-md">
            {{ 'API TuVoz' }}
        </div>



        <div class="links">
            @if ($users)
                <div right>
                    <p> Bienvenido a la plataforma <b>{{ $users->name }}</b>, ahora puedes acceder a nuestros servicios
                        desde la aplicación movil </p>

                </div>
            @endif
        </div>
    </div>
@endsection
