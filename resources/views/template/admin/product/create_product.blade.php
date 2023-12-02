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

                <x-admin.ui.input label="Price"
                                  type="number"
                                  name="price"
                                  id="price"
                                  add-class=""
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
