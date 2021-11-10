@extends('portal-mail::layouts.app')

@section('title', 'Email Addresses')

@section('app-content')

    <settings :emails="{{$emails}}" :users="{{$users}}"></settings>

@endsection
