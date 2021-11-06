@extends('bristolsu::base')

@section('content')
    <div id="portal-mail-root">
        @yield('app-content')
    </div>
@endsection

@push('scripts')
    <script src="{{ asset('modules/portal-mail/js/app.js') }}"></script>
@endpush
