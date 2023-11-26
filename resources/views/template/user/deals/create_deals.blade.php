@extends('layouts.admin.admin_layout',['title'=>'Create Customer'])
@section('content')

    @push('styles')
        {{-- Custom Style --}}
        <script src="https://cdn.jsdelivr.net/timepicker.js/latest/timepicker.min.js"></script>
        <link href="https://cdn.jsdelivr.net/timepicker.js/latest/timepicker.min.css" rel="stylesheet"/>
    @endpush

    <!-- Content Header (Page header) -->
    <div class="content-header">
        <x-admin.title-and-breadcrumb title="Create Deals"
                                      breadcrumbs='{"Home":"admin.dashboard"}'/>
        <!-- /.content-header -->

        <x-admin.ui.card-form title="Deal Details" form-route="create-deal" form-id="create_deal" enctype>
            <x-slot name="input">
                <div class="mb-3">

                </div>
                <x-admin.ui.input label="Title" type="text" name="title" id="title" add-class=""
                                  placeholder="Title" required/>
                <x-admin.ui.input label="Description"
                                  type="text"
                                  name="description"
                                  id="description"
                                  add-class=""
                                  />
                <x-admin.ui.select label="Category"
                                  type="text"
                                  name="category"
                                  id="category"
                                  add-class=""
                                  :options="['food'=>'Food','drink'=>'Drink','event'=>'Event']"
                                  required/>
                <x-admin.ui.input label="Image"
                                  type="file"
                                  name="fileName"
                                  id="fileName"
                                  add-class=""
                                  />
                <x-admin.ui.input label="Price"
                                  type="number"
                                  name="price"
                                  id="price"
                                  add-class=""
                                  />
                                   <div><h4>You can edit and update your deals with more ease and flexibility from within the Hops app</h4></div>
            </x-slot>
           
            <x-slot name="button">
                <x-admin.ui.button type="submit" btn-name="Submit" name="customer_submit" id="customer_submit"/>
            </x-slot>
        </x-admin.ui.card-form>
    

@endsection
