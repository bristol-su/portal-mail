@extends('portal-mail::layouts.app')

@section('title', 'Mail')

@section('app-content')

    <mail :enabled-addresses="{{\BristolSU\Mail\Models\EmailAddress::forUser(app(\BristolSU\Support\Authentication\Contracts\Authentication::class)->getUser())->get()}}">

    </mail>

@endsection
