@extends('layouts.admin.admin_layout',['title'=>'Create Customer'])
@section('content')

    @push('styles')
        {{-- Custom Style --}}
        <script src="https://cdn.jsdelivr.net/timepicker.js/latest/timepicker.min.js"></script>
        <link href="https://cdn.jsdelivr.net/timepicker.js/latest/timepicker.min.css" rel="stylesheet"/>
    @endpush

    <!-- Content Header (Page header) -->
    <div class="content-header">
        <x-admin.title-and-breadcrumb title="Update Deals"
                                      breadcrumbs='{"Home":"admin.dashboard"}'/>
        <!-- /.content-header -->

        <x-admin.ui.card-form title="Update deal" form-route="deal-update" form-route-id="{{ $deal->id }}"
                              form-id="update_deal" enctype>
            <x-slot name="input">
                <div class="mb-3">

                </div>
                <x-admin.ui.input label="Title" type="text" name="title" id="title" add-class=""
                                  placeholder="Title" value="{{ $deal->title}}" required/>
                <x-admin.ui.input label="Description"
                                  type="text"
                                  name="description"
                                  id="description"
                                  add-class=""
                                  value="{{ $deal->description}}"
                                  required/>
                <x-admin.ui.input label="Category"
                                  type="text"
                                  name="category"
                                  id="category"
                                  add-class=""
                                  value="{{ $deal->category}}"
                                  required/>
        <img src="/deals/{{ $deal->id }}/{{ $deal->image_path }}" alt="" width="200" height="=200">

                <x-admin.ui.input label="Image"
                                  type="file"
                                  name="fileName"
                                  id="fileName"
                                  add-class=""
                                  value="{{ $deal->image_path}}"
                                  />
                <x-admin.ui.input label="Price"
                                  type="number"
                                  name="price"
                                  id="price"
                                  add-class=""
                                  value="{{ $deal->price}}"
                                  required/>
                
                <!--<x-admin.ui.select label="Is repeat"-->
                <!--                   name="is_repeat"-->
                <!--                   id="is_repeat"-->
                <!--                   required-->
                <!--                   value="{{ $deal->is_repeat}}"-->
                <!--                   :options="['1'=>'Yes','0'=>'No']"-->
                <!--                  required/>-->
                <!--<x-admin.ui.select label="When to repeat"-->
                <!--                  type="text"-->
                <!--                  name="when_to_repeat"-->
                <!--                  id="when_to_repeat"-->
                <!--                  value="{{ $deal->when_repeat}}"-->
                <!--                  :options="['1'=>'Yes','0'=>'No']"-->
                <!--                  required/>-->
                <!--<x-admin.ui.input label="Repeat weeks"-->
                <!--                    placeholder="Comma separated Ex. 1,2,3..."-->
                <!--                  type="text"-->
                <!--                  name="repeat_weeks"-->
                <!--                  id="repeat_weeks"-->
                <!--                  add-class=""-->
                <!--                  value="{{ $deal->repeat_weeks}}"-->
                <!--                  required/>-->
                <!--<x-admin.ui.select label="Status"-->
                <!--                   name="status"-->
                <!--                   id="status"-->
                <!--                   required-->
                <!--                   value="{{ $deal->status}}"-->
                <!--                   :options="['1'=>'Enable','0'=>'Disable']"-->
                <!--                  required/>-->
                
                <div><h4>If you want to change the dates or repeating options for this deal, please do so through the Hops app, thank you for understanding</h4></div>
                
            </x-slot>
            <x-slot name="button">
                <x-admin.ui.button type="submit" btn-name="Submit" name="customer_submit" id="customer_submit"/>
            </x-slot>
        </x-admin.ui.card-form>
        

@endsection

