@extends('layouts.argonLayout')

@section('content')
    <dashboard-component :dashboard_data='{!! json_encode($dashboard_data??'') !!}'>
        <crud-component :input_fields='{!! json_encode($inputFields??'') !!}'></crud-component>
    </dashboard-component>
@endsection