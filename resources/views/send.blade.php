@extends('portal-mail::layouts.app')

@section('title', 'Send')

@section('app-content')

    <p-page-content title="Send an Email"
                    subtitle="Send an email directly from the portal">

        <send-email :from="{{$from}}">

        </send-email>
    </p-page-content>

@endsection
