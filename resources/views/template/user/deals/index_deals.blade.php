@extends('layouts.admin.admin_layout',['title'=>'Deals Listing'])
@section('content')

    @push('styles')
        {{-- Custom Style --}}
    @endpush
    <x-admin.ui.datatable :data-table="$dataTable" title="Deals Listing">
        <x-slot name="breadcrumb">
            <x-admin.title-and-breadcrumb title="Deals"
                                          breadcrumbs='{"Home":"admin.dashboard","Deals":""}'/>
        </x-slot>
    </x-admin.ui.datatable>
    @push('scripts')
        {{--Custom JS--}}
    @endpush
    `
@endsection
