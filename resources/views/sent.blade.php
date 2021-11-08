@extends('portal-mail::layouts.app')

@section('title', 'Sent Emails')

@section('app-content')

    <p-page-content title="Sent Emails"
                    subtitle="View sent emails">

        @dd($emails->toArray())
    </p-page-content>

@endsection
