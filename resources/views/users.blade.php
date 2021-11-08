@extends('portal-mail::layouts.app')

@section('title', 'Users')

@section('app-content')

    <p-page-content title="Control email access"
                    subtitle="Manage who has access to which emails">

        <view-users :users="{{$users}}" :available-emails="{{\BristolSU\Mail\Models\EmailAddress::all()}}">

        </view-users>
    </p-page-content>

@endsection
