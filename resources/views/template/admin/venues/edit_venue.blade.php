
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

        <x-admin.ui.card-form title="Vendor Details" form-route="venues.update" form-id="edit_customer" enctype form-route-id="{{ $venue->venueId }}">
            <x-slot name="input">
                <div class="mb-3">
                    <x-admin.ui.bootstrap-switch name="status" id="status" label="Status" onText="Active"
                                                 offText="Inactive" :value="$venue->venueStatus"/>
                    <x-admin.ui.bootstrap-switch name="isMember" id="isMember" label="Member" onText="Yes"
                                                 offText="No" :value="$venue->user->isMember"/>
                </div>
                <x-admin.ui.input label="Vendor name" type="text" name="name" id="name" add-class=""
                                  placeholder="" required :value="$venue->venueName"/>
                <x-admin.ui.input label="Vendor email"
                                  type="email"
                                  name="email"
                                  id="email"
                                  add-class=""
                                  :value="$venue->user->email"
                                  required/>
                <x-admin.ui.select label="Type of venue"
                                   type="text"
                                   name="category"
                                   id="category"
                                   add-class="category"
                                   :value="$venue->venueType"
                                   :options="['Beauty Parlour'=>'Beauty Parlour','Spa'=>'Spa','Saloon'=>'Saloon']"
                                   required/>
                <x-admin.ui.textarea label="Vendor bio / blurb"
                                     type="text"
                                     name="description"
                                     id="description"
                                     add-class=""
                                     maxlength="50"
                                     :value="$venue->venueDescription"
                                     required/>
                <x-admin.ui.input label="Website"
                                  type="text"
                                  name="website"
                                  id="website"
                                  add-class=""
                                  :value="$venue->venueWebsite"
                />
                <x-admin.ui.input label="Phone number"
                                  type="number"
                                  name="phone_number"
                                  id="phone_number"
                                  add-class=""
                                  required
                                  :value="$venue->user->PhoneNumber"
                />
                <x-admin.ui.textarea label="Address"
                                     type="text"
                                     name="address"
                                     id="address"
                                     add-class=""
                                     required
                                     :value="$venue->venueAddress"
                />
                @if(isset($venue->images[1]) && $venue->images[1]->imageType == 'banner')
                    <img src="{{ asset('Users/'.$venue->user->userId.'/'.$venue->images[1]?->imagePath) }}" alt="" style="width:150px">
                @endif
                <x-admin.ui.input label="Vendor Banner Image"
                                  type="file"
                                  name="fileName"
                                  id="fileName"
                                  add-class=""
                                  accept="image/png, image/gif, image/jpeg"
                />
                @if(isset($venue->images[0]) && $venue->images[0]->imageType == 'logo')
                <img src="{{ asset('Users/'.$venue->user->userId.'/'.$venue->images[0]?->imagePath) }}" alt="" style="width:150px">
                @endif
                <x-admin.ui.input label="Vendor Logo Image"
                                  type="file"
                                  name="logoName"
                                  id="logoName"
                                  accept="image/png, image/gif, image/jpeg"
                                  add-class=""/>
                @foreach(array_slice($venue->images->toArray(),2) as $image)
                    @if(isset($image['imageType']) && $image['imageType'] == 'menuImage')
                        <img src="{{ asset('Users/'.$venue->user->userId.'/menuImage/'.$image['imagePath']) }}" alt="" style="width:150px">
                    @endif
                @endforeach
                <x-admin.ui.input label="Menu Images"
                                  type="file"
                                  name="menuImage[]"
                                  id="menuImage"
                                  add-class=""
                                  multiple="true"
                                  accept="image/png, image/gif, image/jpeg"
                                  />
                <x-admin.ui.select label="Suburb"
                                  name="suburb"
                                  id="suburb"
                                  required
                                  :options="\App\Models\Suburb::suburbAsArray()"
                                  :value="$venue->suburb->id"
                                  />
                <x-admin.ui.input label="Place Name"
                                  type="text"
                                  name="placename"
                                  id="placename"
                                  add-class=""
                                  required
                                  :value="$venue->placeName"
                                  />
                <x-admin.ui.input label="Latitude"
                                  type="text"
                                  name="latitude"
                                  id="latitude"
                                  add-class=""
                                  required
                                  :value="$venue->latitude"
                                  />
                <x-admin.ui.input label="Longitude"
                                  type="text"
                                  name="longitude"
                                  id="longitude"
                                  add-class=""
                                  required
                                  :value="$venue->longitude"
                                  />
                @foreach($venue->timing as $timing)
                    <div class="form-group fieldGroup">
                        <div class="input-group">
                            <div class="d-flex">
                                <x-admin.ui.select label="Day"
                                                   name="day[]"
                                                   id="day"
                                                   required
                                                   :value="$timing->day"
                                                   :options="App\Models\Venues::$days" />
                                <x-admin.ui.input label="Opening Time"
                                                  type="time"
                                                  name="otime[]"
                                                  id="otime"
                                                  add-class=""
                                                  :value="$timing->openTime"
                                                  required/>
                                <x-admin.ui.input label="Closing Time"
                                                  type="time"
                                                  name="ctime[]"
                                                  id="ctime"
                                                  add-class=""
                                                  :value="$timing->closeTime"
                                                  required/>

                            </div>
                            {{-- <div class="mt-4 pt-2">
                                <a href="javascript:void(0)" class="btn btn-danger remove" style="min-width: 50px; float: right;">
                                    <span class="glyphicon glyphicon glyphicon-plus" aria-hidden="true"></span> remove</a>
                            </div> --}}
                            <div class="mt-4 pt-2">
                                <a href="javascript:void(0)" class="btn btn-success addMore" style="min-width: 50px; float: right;">
                                    <span class="glyphicon glyphicon glyphicon-plus" aria-hidden="true"></span> Add</a>
                            </div>
                        </div>
                    </div>
                @endforeach

{{--                <x-admin.ui.input label="Password"--}}
{{--                                  type="password"--}}
{{--                                  name="password"--}}
{{--                                  id="password"--}}
{{--                                  add-class=""--}}
{{--                                  required/>--}}
{{--                <x-admin.ui.input label="Confirm Password"--}}
{{--                                  type="password"--}}
{{--                                  name="password_confirmation"--}}
{{--                                  id="password_confirmation"--}}
{{--                                  add-class=""--}}
{{--                                  required/>--}}
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
                    <div class="mt-4 pt-2">
                        <a href="javascript:void(0)" class="btn btn-success addMore" style="min-width: 50px; float: right;">
                            <span class="glyphicon glyphicon glyphicon-plus" aria-hidden="true"></span> Add</a>
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
