@extends('layouts.argonLayout')

@section('content')
    <dashboard-component :dashboard_data='{!! json_encode($dashboard_data??'') !!}'>
    </dashboard-component>    
@endsection