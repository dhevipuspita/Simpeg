@extends('layouts.app')

@section('title', 'Dashboard')

@section('content')
    @if (Auth::user()->roleId == 4)
        @include('components.userDashboard')
    @endif

    @if (Auth::user()->roleId == 1)
        @include('components.adminDashboard')
    @endif
@endsection
