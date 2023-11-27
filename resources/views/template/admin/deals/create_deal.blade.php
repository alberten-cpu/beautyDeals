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
        <x-admin.title-and-breadcrumb title="Create Deal"
                                      breadcrumbs='{"Home":"dashboard","Deals":"deals.index","Create Deal":""}'/>
        <!-- /.content-header -->

        <x-admin.ui.card-form title="Deal Details" form-route="deals.store" form-id="create_deal" enctype>
            <x-slot name="input">
                <div class="mb-3">
                    <x-admin.ui.bootstrap-switch name="status" id="status" label="Status" onText="Active"
                                                 offText="Inactive" value="1"/>
                    <x-admin.ui.bootstrap-switch name="isExclusive" id="isExclusive" label="isExclusive" onText="Yes"
                                                 offText="No" required/>
                </div>
                @if(auth()->user()->isAdmin())
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

                <x-admin.ui.select label="Select Category"
                                   type="text"
                                   name="category"
                                   id="category"
                                   add-class="category"
                                   :options="\App\Models\DealCategory::categoryAsArray()"
                                   required/>

                <x-admin.ui.select label="Select SubCategory"
                                   type="text"
                                   name="sub_category"
                                   id="sub_category"
                                   add-class="sub_category"
                                   options="deals.show"
                                   routeId=""
                                   required/>

                <x-admin.ui.input label="Price"
                                  type="number"
                                  name="price"
                                  id="price"
                                  add-class=""
                                  required/>

                <x-admin.ui.select label="Repeat"
                                   name="is_repeat"
                                   id="is_repeat"
                                   add-class="is_repeat"
                                   :options="['1'=>'Weekly','2'=>'Monthly','3'=>'Never']"
                                   required/>
                <div class="no-never d-none">
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
                <div class="monthly d-none">
                    <x-admin.ui.select label="Week"
                                       name="week[]"
                                       id="week"
                                       add-class="week"
                                       :default="false"
                                       :value="1"
                                       :options="['1'=>'Week 1','2'=>'Week 2','3'=>'Week 3','4'=>'Week 4']"
                                       multiple
                    />
                </div>
                <div class="form-group fieldGroup d-none">
                    <div class="input-group">
                        <div class="d-flex">
                            <div class="never d-none">
                                <x-admin.ui.input label="Date"
                                                  type="date"
                                                  name="date"
                                                  id="date"
                                                  add-class=""
                                />
                            </div>
                            <div class="no-never">
                                <x-admin.ui.select label="Day"
                                                   name="day[]"
                                                   id="day"
                                                   :options="App\Models\Venues::$days"/>
                            </div>
                            <x-admin.ui.input label="Opening Time"
                                              type="time"
                                              name="otime[]"
                                              id="otime"
                                              add-class=""
                                              required
                                              value="{{ old('otime', '10:00') }}"/>
                            <x-admin.ui.input label="Closing Time"
                                              type="time"
                                              name="ctime[]"
                                              id="ctime"
                                              add-class=""
                                              required
                                              value="{{ old('ctime', '20:00') }}"/>

                        </div>
                        <div class="mt-4 pt-2 no-never">
                            <a href="javascript:void(0)" class="btn btn-success addMore"
                               style="min-width: 50px; float: right;">
                                <span class="glyphicon glyphicon glyphicon-plus" aria-hidden="true"></span> Add</a>
                        </div>
                    </div>
                </div>
                <x-admin.ui.input label="Deal Images"
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
        <div class="form-group fieldGroupCopy" style="display: none;">
            <div class="input-group">
                <div class="row">
                    <x-admin.ui.select label="Day"
                                       name="day[]"
                                       id="day"
                                       :options="App\Models\Venues::$days"/>
                    <x-admin.ui.input label="Opening Time"
                                      type="time"
                                      name="otime[]"
                                      id="otime"
                                      add-class=""
                                      value="{{ old('otime', '10:00') }}"/>
                    <x-admin.ui.input label="Closing Time"
                                      type="time"
                                      name="ctime[]"
                                      id="ctime"
                                      add-class=""
                                      value="{{ old('otime', '20:00') }}"/>
                    <div class="mt-4 pt-2">
                        <a href="javascript:void(0)" class="btn btn-danger remove"
                           style="min-width: 50px; float: right;">
                            <span class="glyphicon glyphicon glyphicon-plus" aria-hidden="true"></span> remove</a>
                    </div>


                </div>
            </div>
        </div>
        <!-- /.content -->
        @push('scripts')
            {{-- Custom JS --}}
            <script>
                $(document).ready(function () {
                    //group add limit
                    var maxGroup = 10;
                    //add more fields group
                    $(".addMore").click(function () {
                        if ($('body').find('.fieldGroup').length < maxGroup) {
                            var fieldHTML = '<div class="form-group fieldGroup">' + $(".fieldGroupCopy").html() + '</div>';
                            $('body').find('.fieldGroup:last').after(fieldHTML);
                        } else {
                            alert('Maximum ' + maxGroup + ' groups are allowed.');
                        }
                    });
                });

                // Remove button functionality
                $(document).on('click', '.remove', function () {
                    $(this).closest('.fieldGroup').remove();
                });

                $('#is_repeat').change(function () {
                    changeIsRepeat(this);
                });

                $(document).ready(function () {
                    changeIsRepeat('#is_repeat');
                })

                function changeIsRepeat($this) {
                    if ($($this).val() == 1) {
                        $('.no-never').removeClass('d-none');
                        $('.fieldGroup').removeClass('d-none');
                        $('.never').addClass('d-none');
                        $('.monthly').addClass('d-none');
                    } else if ($($this).val() == 2) {
                        $('.monthly').removeClass('d-none');
                        $('.no-never').removeClass('d-none');
                        $('.fieldGroup').removeClass('d-none');
                        $('.never').addClass('d-none');
                    } else if ($($this).val() == 3) {
                        $('.fieldGroup').addClass('d-none');
                        $('.fieldGroup').first().removeClass('d-none');
                        $('.monthly').addClass('d-none');
                        $('.never').removeClass('d-none');
                        $('.no-never').addClass('d-none');
                    } else {
                        $('.never').addClass('d-none');
                        $('.monthly').addClass('d-none');
                        $('.fieldGroup').addClass('d-none');
                    }
                }

                $('#category').change(function () {
                    $('#sub_category').val('');
                    $('#sub_category').attr('data-id', $(this).val());
                    let url = '{{ Helper::getRoute('deals.show',''),  }}/' + $(this).val()
                    $('#sub_category').select2({
                        ajax: {
                            url: url,
                            type: "get",
                            dataType: 'json',
                            delay: 250,
                            data: function (params) {
                                return {
                                    search: params.term
                                };
                            },
                            processResults: function (response) {
                                return {
                                    results: response
                                };
                            },
                            cache: true
                        }

                    });
                });
            </script>

    @endpush

@endsection
