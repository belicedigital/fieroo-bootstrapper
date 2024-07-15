@extends('layouts.email')
@section('content')
    Gentile {{ $data['name'] }},<br><br>
    Sei registrato con il ruolo di {{ $data['role'] }}.<br><br>
    Per effettuare il login andare sul link <a href="{{ env('ADMIN_URL') }}" target="_blank">{{ env('ADMIN_URL') }}</a> ed
    immettere le credenziali:<br>
    Username: {{ $data['email'] }}<br>
    Password: {{ $data['password'] }}<br><br>
    Ti ricordiamo di cambiare la password dopo aver effettuato il tuo primo accesso.<br><br>
    Grazie.
@endsection
