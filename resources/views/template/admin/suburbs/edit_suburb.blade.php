
@extends('layouts.admin.admin_layout',['title'=>'Edit Venue'])
@section('content')

    @push('styles')
        {{-- Custom Style --}}
        <script src="https://cdn.jsdelivr.net/timepicker.js/latest/timepicker.min.js"></script>
        <link href="https://cdn.jsdelivr.net/timepicker.js/latest/timepicker.min.css" rel="stylesheet"/>
    @endpush

    <!-- Content Header (Page header) -->
    <div class="content-header">
        <x-admin.title-and-breadcrumb title="Edit Venue"
                                      breadcrumbs='{"Home":"dashboard","Venues":"venues.index","Edit Venue":""}'/>
        <!-- /.content-header -->

        <x-admin.ui.card-form title="Vendor Details" form-route="suburbs.update" form-id="edit_customer" enctype form-route-id="{{ $suburb->id }}">
            <x-slot name="input">
                <div class="mb-3">
                    <x-admin.ui.bootstrap-switch name="status" id="status" label="Status" onText="Active"
                                                 offText="Inactive" :value="$suburb->status"/>
                </div>
                <x-admin.ui.input label="Suburb" type="text" name="suburb" id="suburb" add-class=""
                                  placeholder="" required :value="$suburb->suburb"/>
                <x-admin.ui.input label="Latitude"
                                  type="text"
                                  name="latitude"
                                  id="latitude"
                                  add-class=""
                                  :value="$suburb->latitude"
                                  required/>
                <x-admin.ui.input label="Longitude"
                                  type="text"
                                  name="longitude"
                                  id="longitude"
                                  add-class=""
                                  :value="$suburb->latitude"
                                  required/>
            </x-slot>
            <x-slot name="button">
                <x-admin.ui.button type="submit" btn-name="Submit" name="customer_submit" id="customer_submit"/>
            </x-slot>
        </x-admin.ui.card-form>

        <!-- /.content -->
        @push('scripts')
            {{-- Custom JS --}}
            <script>
                $(document).ready(function(){
                    //group add limit
                    var maxGroup = 10;
                    //add more fields group
                    $(".addMore").click(function(){
                        if($('body').find('.fieldGroup').length < maxGroup){
                            var fieldHTML = '<div class="form-group fieldGroup">'+$(".fieldGroupCopy").html()+'</div>';
                            $('body').find('.fieldGroup:last').after(fieldHTML);
                        }else{
                            alert('Maximum '+maxGroup+' groups are allowed.');
                        }
                    });
                });

                // Remove button functionality
                $(document).on('click', '.remove', function(){
                    $(this).closest('.fieldGroup').remove();
                });

            </script>

    @endpush

@endsection
