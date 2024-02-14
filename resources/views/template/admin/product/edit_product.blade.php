@php use App\Models\Venues; @endphp
@extends('layouts.admin.admin_layout',['title'=>'Edit Deal'])
@section('content')

    @push('styles')
        {{-- Custom Style --}}
        <script src="https://cdn.jsdelivr.net/timepicker.js/latest/timepicker.min.js"></script>
        <link href="https://cdn.jsdelivr.net/timepicker.js/latest/timepicker.min.css" rel="stylesheet"/>
    @endpush

    <!-- Content Header (Page header) -->
    <div class="content-header">
        <x-admin.title-and-breadcrumb title="Edit Product"
                                      breadcrumbs='{"Home":"dashboard","Products":"product.index","Edit Product":""}'/>
        <!-- /.content-header -->

        <x-admin.ui.card-form title="Product Details" form-route="product.update" form-id="edit_product" enctype form-route-id="{{ $product->id }}">
            <x-slot name="input">
                <div class="mb-3">
                    <x-admin.ui.bootstrap-switch name="status" id="status" label="Status" onText="Active"
                                                 offText="Inactive" :value="$product->status"/>
                </div>
                @if(auth()->user()->isAdmin() || auth()->user()->isAdminUser())
                <x-admin.ui.select label="Select Venue"
                                   type="text"
                                   name="venue"
                                   id="venue"
                                   add-class="venue"
                                   :options="\App\Models\Venues::venueAsArray()"
                                   required :value="$product->venueId"/>
                @else
                    <input type="hidden" name="venue" id="venue"
                           value="{{Venues::geVenueByUserId(auth()->id())->venueId}}">
                @endif
                <x-admin.ui.input label="Title" type="text" name="title" id="name" add-class=""
                                  placeholder="" required :value="$product->title"/>

                <x-admin.ui.textarea label="Description"
                                     name="description"
                                     id="description"
                                     add-class=""
                                     maxlength="50"
                                     required :value="$product->description"/>

                <x-admin.ui.input label="Price"
                                  type="number"
                                  name="price"
                                  id="price"
                                  step="0.01"
                                  add-class=""
                                  required :value="$product->price"/>
                <div class="product">
                    <x-admin.ui.input label="Start Date"
                                      type="date"
                                      name="startDate"
                                      id="date"
                                      add-class=""
                                      :value="$product->startDate->format('Y-m-d')"
                                      />

                    <x-admin.ui.input label="End Date"
                                      type="date"
                                      name="endDate"
                                      id="endDate"
                                      add-class=""
                                      :value="$product->endDate->format('Y-m-d')"
                                      />
                </div>

                <div>
                    @foreach($product->productImages as $productImages)
                        <img src="{{ asset('Products/'.$product->id.'/'.$productImages?->imagePath) }}" alt="" style="width:150px">
                    @endforeach
                </div>
                <x-admin.ui.input label="Product Images"
                                  type="file"
                                  name="image[]"
                                  id="image"
                                  add-class=""
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
