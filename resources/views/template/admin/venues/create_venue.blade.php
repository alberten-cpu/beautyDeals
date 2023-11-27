
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
                                      breadcrumbs='{"Home":"dashboard","Venues":"venues.index","Create Venue":""}'/>
        <!-- /.content-header -->

        <x-admin.ui.card-form title="Vendor Details" form-route="venues.store" form-id="create_customer" enctype>
            <x-slot name="input">
                <div class="mb-3">
                    <x-admin.ui.bootstrap-switch name="status" id="status" label="Status" onText="Active"
                                                 offText="Inactive" value="1"/>
                    <x-admin.ui.bootstrap-switch name="isMember" id="isMember" label="Member" onText="Yes"
                                                 offText="No"/>
                </div>
                <x-admin.ui.input label="Vendor name" type="text" name="name" id="name" add-class=""
                                  placeholder="" required/>
                <x-admin.ui.input label="Vendor email"
                                  type="email"
                                  name="email"
                                  id="email"
                                  add-class=""
                                  required/>

                <x-admin.ui.select label="Type of venue"
                                  type="text"
                                  name="category"
                                  id="category"
                                  add-class="category"
                                  :options="['Beauty Parlour'=>'Beauty Parlour','Spa'=>'Spa','Saloon'=>'Saloon']"
                                  required/>
                <x-admin.ui.textarea label="Vendor bio / blurb"
                                  type="text"
                                  name="description"
                                  id="description"
                                  add-class=""
                                  maxlength="50"
                                  required/>
                <x-admin.ui.input label="Website"
                                  type="text"
                                  name="website"
                                  id="website"
                                  add-class=""
                                  />
                <x-admin.ui.input label="Phone number"
                                  type="number"
                                  name="phone_number"
                                  id="phone_number"
                                  add-class=""
                                  required/>
                <x-admin.ui.textarea label="Address"
                                     type="text"
                                     name="address"
                                     id="address"
                                     add-class=""
                                     required/>
                <x-admin.ui.input label="Vendor Banner Image"
                                  type="file"
                                  name="fileName"
                                  id="fileName"
                                  add-class=""
                                  required
                                  accept="image/png, image/gif, image/jpeg"
                                  />
                <x-admin.ui.input label="Vendor Logo Image"
                                  type="file"
                                  name="logoName"
                                  id="logoName"
                                  add-class=""
                                  accept="image/png, image/gif, image/jpeg"
                                  required/>
                <x-admin.ui.input label="Menu Image"
                                  type="file"
                                  name="menuImage[]"
                                  id="menuImage"
                                  add-class=""
                                  :multiple="true"
                                  accept="image/png, image/gif, image/jpeg"
                                  required/>
                <x-admin.ui.select label="Suburb"
                                  name="suburb"
                                  id="suburb"
                                  required
                                  :options="\App\Models\Suburb::suburbAsArray()" />
                <x-admin.ui.input label="Place Name"
                                     type="text"
                                     name="placename"
                                     id="placename"
                                     add-class=""
                                     required/>
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

                <div class="form-group fieldGroup">
                    <div class="input-group">
                        <div class="d-flex">
                            <x-admin.ui.select label="Day"
                                               name="day[]"
                                               id="day"
                                               required
                                               :options="App\Models\Venues::$days" />
                            <x-admin.ui.input label="Opening Time"
                                              type="time"
                                              name="otime[]"
                                              id="otime"
                                              add-class=""
                                              required
                                              {{-- value="{{ old('otime', '09:30') }}" --}}
                                              />
                            <x-admin.ui.input label="Closing Time"
                                              type="time"
                                              name="ctime[]"
                                              id="ctime"
                                              add-class=""
                                              required
                                              {{-- value="{{ old('ctime', '17:30') }}" --}}
                                               />

                        </div>
                        <div class="mt-4 pt-2">
								<a href="javascript:void(0)" class="btn btn-success addMore" style="min-width: 50px; float: right;">
                                    <span class="glyphicon glyphicon glyphicon-plus" aria-hidden="true"></span> Add</a>
							</div>
                    </div>
                </div>
                <x-admin.ui.input label="Password"
                                  type="password"
                                  name="password"
                                  id="password"
                                  add-class=""
                                  required/>
                <x-admin.ui.input label="Confirm Password"
                                  type="password"
                                  name="password_confirmation"
                                  id="password_confirmation"
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
                                      add-class=""
                                      {{-- value="{{ old('otime', '09:30') }}" --}}
                                      />
                    <x-admin.ui.input label="Closing Time"
                                      type="time"
                                      name="ctime[]"
                                      id="ctime"
                                      add-class=""
                                      {{-- value="{{ old('ctime', '17:30') }}" --}}
                                      />
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
