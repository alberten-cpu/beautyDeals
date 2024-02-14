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
        <x-admin.title-and-breadcrumb title="Edit Deal"
                                      breadcrumbs='{"Home":"dashboard","Deals":"deals.index","Edit Deal":""}'/>
        <!-- /.content-header -->

        <x-admin.ui.card-form title="Deal Details" form-route="deals.update" form-id="edit_deal" enctype form-route-id="{{ $deal->dealId }}">
            <x-slot name="input">
                <div class="mb-3">
                    <x-admin.ui.bootstrap-switch name="status" id="status" label="Status" onText="Active"
                                                 offText="Inactive" :value="$deal->status"/>
                    <x-admin.ui.bootstrap-switch name="isExclusive" id="isExclusive" label="isExclusive" onText="Yes"
                                                 offText="No" required :value="$deal->isExclusive"/>
                </div>
                @if(auth()->user()->isAdmin() || auth()->user()->isAdminUser())
                <x-admin.ui.select label="Select Venue"
                                   type="text"
                                   name="venue"
                                   id="venue"
                                   add-class="venue"
                                   :options="\App\Models\Venues::venueAsArray()"
                                   required :value="$deal->venueId"/>
                @else
                    <input type="hidden" name="venue" id="venue"
                           value="{{Venues::geVenueByUserId(auth()->id())->venueId}}">
                @endif
                <x-admin.ui.input label="Title" type="text" name="title" id="name" add-class=""
                                  placeholder="" required :value="$deal->title"/>

                <x-admin.ui.textarea label="Description"
                                     name="description"
                                     id="description"
                                     add-class=""
                                     maxlength="300"
                                     required :value="$deal->description"/>

                <x-admin.ui.select label="Select Category"
                                   type="text"
                                   name="category"
                                   id="category"
                                   add-class="category"
                                   :options="\App\Models\DealCategory::categoryAsArray()"
                                   required :value="$deal->category"/>

                <x-admin.ui.select label="Select SubCategory"
                                   type="text"
                                   name="sub_category"
                                   id="sub_category"
                                   add-class="sub_category"
                                   :options="[]"
                                   :routeId="$deal->category"
                                   required/>

                <x-admin.ui.input label="Price"
                                  type="number"
                                  name="price"
                                  id="price"
                                  step="0.01"
                                  add-class=""
                                  required :value="$deal->price"/>

                <x-admin.ui.select label="Repeat"
                                  name="is_repeat"
                                  id="is_repeat"
                                  add-class="is_repeat"
                                  :options="['1'=>'Weekly','2'=>'Monthly','3'=>'Never']"
                                  required :value="$deal->isRepeat"/>
                <div class="no-never d-none">
                    <x-admin.ui.input label="Start Date"
                                      type="date"
                                      name="startDate"
                                      id="date"
                                      add-class=""
                                      :value="$deal->startDate->format('Y-m-d')"
                                      />
                    <x-admin.ui.input label="End Date"
                                      type="date"
                                      name="endDate"
                                      id="endDate"
                                      add-class=""
                                      :value="$deal->repeatEndDate->format('Y-m-d')"
                                      />
                </div>
                <div class="monthly d-none">
                    <x-admin.ui.select label="Week"
                                       name="week[]"
                                       id="week"
                                       add-class="week"
                                       :default="false"
                                       :value="implode(',',explode('-',$deal->repeatWeeks))"
                                       :options="['1'=>'Week 1','2'=>'Week 2','3'=>'Week 3','4'=>'Week 4']"
                                       multiple
                    />
                </div>
                @if($deal->dealRepeat)
                    @foreach($deal->dealRepeat as $dealRepeat)
                        <div class="form-group fieldGroup old-value">
                            <div class="input-group">
                                <div class="d-flex">
                                        <div class="never">
                                            <x-admin.ui.input label="Date"
                                                              type="date"
                                                              name="date[]"
                                                              id="date"
                                                              :value="$dealRepeat->repeat"
                                                              add-class=""
                                            />
                                        </div>
                                        <div class="no-never">
                                            <x-admin.ui.select label="Day"
                                                               name="day[]"
                                                               id="day"
                                                               :options="App\Models\Venues::$days"
                                                               :value="$dealRepeat->repeat" />
                                        </div>
                                        <x-admin.ui.input label="Opening Time"
                                                          type="time"
                                                          name="otime[]"
                                                          id="otime"
                                                          add-class=""
                                                          :value="$dealRepeat->sTime->format('H:i:s')"/>
                                        <x-admin.ui.input label="Closing Time"
                                                          type="time"
                                                          name="ctime[]"
                                                          id="ctime"
                                                          add-class=""
                                                          :value="$dealRepeat->eTime->format('H:i:s')"
                                        />
                                    @if($deal->isRepeat != 3)
                                    <div class="mt-4 pt-2">
                                        <a href="javascript:void(0)" class="btn btn-danger remove" style="min-width: 50px; float: right;">
                                            <span class="glyphicon glyphicon glyphicon-plus" aria-hidden="true"></span> remove</a>
                                    </div>
                                    @endif
                                </div>
                            </div>
                        </div>
                    @endforeach
                @endif
                <div class="form-group fieldGroup fieldGroup2">
                    <div class="input-group">
                        <div class="d-flex">
                            <div class="never d-none">
                            <x-admin.ui.input label="Date"
                                              type="date"
                                              name="date[]"
                                              id="date"
                                              add-class=""
                                              />
                            </div>
                            <div class="no-never">
                            <x-admin.ui.select label="Day"
                                               name="day[]"
                                               id="day"
                                               :options="App\Models\Venues::$days" />
                            </div>
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

                        </div>
                        <div class="mt-4 pt-2 no-never">
								<a href="javascript:void(0)" class="btn btn-success addMore" style="min-width: 50px; float: right;">
                                    <span class="glyphicon glyphicon glyphicon-plus" aria-hidden="true"></span> Add</a>
							</div>
                    </div>
                </div>
                <div>
                    @foreach($deal->dealImages as $dealImage)
                        <img src="{{ asset('Deals/'.$deal->dealId.'/'.$dealImage?->imagePath) }}" alt="" style="width:150px">
                    @endforeach
                </div>
                <x-admin.ui.input label="Deal Images"
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

                $('#is_repeat').change(function() {
                    changeIsRepeat(this);
                    if($(this).val() != '{{ $deal->isRepeat }}')
                    {
                        $('.old-value').addClass('d-none');
                    } else {
                        $('.old-value').removeClass('d-none');
                    }
                });

                $(document).ready(function() {
                    changeIsRepeat('#is_repeat');
                })

                function changeIsRepeat($this)
                {
                    if($($this).val() == 1){
                        $('.no-never').removeClass('d-none');
                        $('.fieldGroup').removeClass('d-none');
                        $('.never').addClass('d-none');
                        $('.monthly').addClass('d-none');
                        if('{{ $deal->isRepeat }}' ==1 || '{{ $deal->isRepeat }}' ==2) {
                            $('.old-value').removeClass('d-none');
                        }
                    }
                    else if($($this).val() == 2)
                    {
                        $('.fieldGroup').removeClass('d-none');
                        $('.monthly').removeClass('d-none');
                        $('.no-never').removeClass('d-none');
                        $('.never').addClass('d-none');
                        if('{{ $deal->isRepeat }}' ==1 || '{{ $deal->isRepeat }}' ==2) {
                            $('.old-value').removeClass('d-none');
                        }
                    }
                    else if($($this).val() == 3)
                    {
                        $('.fieldGroup').addClass('d-none');
                        if('{{ $deal->isRepeat }}' ==3)
                        {
                            $('.fieldGroup2').addClass('d-none');
                            $('.old-value').removeClass('d-none');
                        }else {
                            $('.fieldGroup').first().next().removeClass('d-none');
                        }
                        $('.monthly').addClass('d-none');
                        $('.never').removeClass('d-none');
                        $('.no-never').addClass('d-none');
                    }
                    else {
                        $('.never').addClass('d-none');
                        $('.monthly').addClass('d-none');
                        $('.fieldGroup').addClass('d-none');
                    }
                }

                $('#category').change(function () {
                    $('#sub_category').val('');
                    setSubCategory(this);
                });
                $(document).ready(function (){
                    let id = '{{ $deal->subCategory }}';
                    setSubCategory('#category', id);
                });
                function setSubCategory($this, id)
                {
                    $('#sub_category').attr('data-id',$($this).val());
                    let url = '{{ Helper::getRoute('deals.show',''),  }}/'+$($this).val()
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
                    if(id) {
                        $.ajax(url, {
                            data: {
                                id: id
                            },
                            dataType: "json"
                        }).done(function (data) {
                            let options = [];
                            for (let i = 0; i < data.length; i++) {
                                options.push(new Option(data[i].text, data[i].id, true, true));
                            }
                            $('#sub_category').append(options).trigger('change');
                            $('#sub_category').val(id).trigger('change');
                        });
                    }
                }
            </script>

    @endpush

@endsection
