@extends('portal-mail::layouts.app')

@section('title', 'Email Addresses')

@section('app-content')

    <p-page-content title="Available email addresses"
                    subtitle="Manage the email addresses that can be used for sending">

        <view-addresses :emails="{{$emails}}">

        </view-addresses>
    </p-page-content>

@endsection
