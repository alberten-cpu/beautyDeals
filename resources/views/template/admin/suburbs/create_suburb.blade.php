
@extends('layouts.admin.admin_layout',['title'=>'Create Venue'])
@section('content')

    @push('styles')
        {{-- Custom Style --}}
        <script src="https://cdn.jsdelivr.net/timepicker.js/latest/timepicker.min.js"></script>
        <link href="https://cdn.jsdelivr.net/timepicker.js/latest/timepicker.min.css" rel="stylesheet"/>
    @endpush

    <!-- Content Header (Page header) -->
    <div class="content-header">
        <x-admin.title-and-breadcrumb title="Create Venue"
                                      breadcrumbs='{"Home":"dashboard","Suburb":"suburbs.index","Create Suburb":""}'/>
        <!-- /.content-header -->

        <x-admin.ui.card-form title="Suburb Details" form-route="suburbs.store" form-id="create_suburb" enctype>
            <x-slot name="input">
                <div class="mb-3">
                    <x-admin.ui.bootstrap-switch name="status" id="status" label="Status" onText="Active"
                                                 offText="Inactive" value="1"/>
                </div>
                <x-admin.ui.input label="Suburb name" type="text" name="suburb" id="name" add-class=""
                                  placeholder="" required/>
                <x-admin.ui.input label="Latitude"
                                  type="text"
                                  name="latitude"
                                  id="latitude"
                                  add-class=""
                                  required/>
                <x-admin.ui.input label="Longitude"
                                  type="text"
                                  name="longitude"
                                  id="longitude"
                                  add-class=""
                                  required/>
            </x-slot>
            <x-slot name="button">
                <x-admin.ui.button type="submit" btn-name="Submit" name="customer_submit" id="customer_submit"/>
            </x-slot>
        </x-admin.ui.card-form>
        <div class="form-group fieldGroupCopy" style="display: none;">
            <div class="input-group">
                <div class="row">
                    <x-admin.ui.select label="Day"
                                       name="day[]"
                                       id="day"
                                       :options="App\Models\Venues::$days" />
                    <x-admin.ui.input label="Opening Time"
                                      type="time"
                                      name="otime[]"
                                      id="otime"
                                      add-class=""/>
                    <x-admin.ui.input label="Closing Time"
                                      type="time"
                                      name="ctime[]"
                                      id="ctime"
                                      add-class=""/>
                            <div class="mt-4 pt-2">
								<a href="javascript:void(0)" class="btn btn-danger remove" style="min-width: 50px; float: right;">
                                    <span class="glyphicon glyphicon glyphicon-plus" aria-hidden="true"></span> remove</a>
							</div>


                </div>
            </div>
        </div>
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
