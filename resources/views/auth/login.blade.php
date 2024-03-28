@extends('layouts.argonLayout')

@section('content')
    <login-component csrf_token="{{ @csrf_token() }}"></login-component>
@endsection
