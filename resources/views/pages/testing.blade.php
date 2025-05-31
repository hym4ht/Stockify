@extends('layouts.dashboard')
@section('sidebar')
<x-sidebar-dashboard>
    <x-sidebar-menu-dashboard routeName="testing-meni" tittle="test1"/>
    <x-sidebar-menu-dropdown-dashboard routeName="testing-dropdown" tittle="test2.*">
        <x-sidebar-menu-dropdown-item-dashboard routeName="testing-item" tittle="test2.item1"/>
    </x-sidebar-menu-dropdown-dashboard>
</x-sidebar-dashboard>
@endsection
@section('navbar')
    <x-navbar-dashboard></x-navbar-dashboard>
@endsection

@section('content')
@endsection
