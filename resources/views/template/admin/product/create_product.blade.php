@php use App\Models\Venues; @endphp
@extends('layouts.admin.admin_layout',['title'=>'Create Deal'])
@section('content')

    @push('styles')
        {{-- Custom Style --}}
        <script src="https://cdn.jsdelivr.net/timepicker.js/latest/timepicker.min.js"></script>
        <link href="https://cdn.jsdelivr.net/timepicker.js/latest/timepicker.min.css" rel="stylesheet"/>
    @endpush

    <!-- Content Header (Page header) -->
    <div class="content-header">
        <x-admin.title-and-breadcrumb title="Create Product"
                                      breadcrumbs='{"Home":"dashboard","Product":"product.index","Create Product":""}'/>
        <!-- /.content-header -->

        <x-admin.ui.card-form title="Deal Details" form-route="product.store" form-id="create_product" enctype>
            <x-slot name="input">
                <div class="mb-3">
                    <x-admin.ui.bootstrap-switch name="status" id="status" label="Status" onText="Active"
                                                 offText="Inactive" value="1"/>
                </div>
                @if(auth()->user()->isAdmin() || auth()->user()->isAdminUser())
                    <x-admin.ui.select label="Select Venue"
                                       type="text"
                                       name="venue"
                                       id="venue"
                                       add-class="venue"
                                       :options="Venues::venueAsArray()"
                                       required/>
                @else
                    <input type="hidden" name="venue" id="venue"
                           value="{{Venues::geVenueByUserId(auth()->id())->venueId}}">
                @endif
                <x-admin.ui.input label="Title" type="text" name="title" id="name" add-class=""
                                  placeholder="" required/>

                <x-admin.ui.textarea label="Description"
                                     name="description"
                                     id="description"
                                     add-class=""
                                     maxlength="50"
                                     required/>

                <x-admin.ui.input label="Price"
                                  type="number"
                                  name="price"
                                  id="price"
                                  add-class=""
                                  step="0.01"
                                  required/>

                <div class="product">
                    <x-admin.ui.input label="Start Date"
                                      type="date"
                                      name="startDate"
                                      id="date"
                                      add-class=""
                    />
                    <x-admin.ui.input label="End Date"
                                      type="date"
                                      name="endDate"
                                      id="endDate"
                                      add-class=""
                    />
                </div>

                <x-admin.ui.input label="Product Image"
                                  type="file"
                                  name="image[]"
                                  id="image"
                                  add-class=""
                                  required
                                  multiple
                                  accept="image/png, image/gif, image/jpeg"
                />
            </x-slot>
            <x-slot name="button">
                <x-admin.ui.button type="submit" btn-name="Submit" name="customer_submit" id="customer_submit"/>
            </x-slot>
        </x-admin.ui.card-form>

        <!-- /.content -->
        @endsection
