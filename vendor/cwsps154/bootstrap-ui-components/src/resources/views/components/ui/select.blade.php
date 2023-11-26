@if(config('buicomponents.select2.enable'))
    @pushonce('styles')
        <!-- Select2 -->
        @forelse(config('buicomponents.select2.css') as $css)
            <link rel="stylesheet" href="{{ $css }}" crossorigin="anonymous">
        @empty
        @endforelse
        @if(config('buicomponents.select2.custom-css'))
        <style>
            .select2-selection__rendered {
                line-height: 31px !important;
            }

            .select2-container .select2-selection--single {
                height: 38px !important;
            }

            .select2-selection__arrow {
                height: 38px !important;
            }

            .select2-container {
                width: 100% !important;
                line-height: 1.5 !important;
            }

            .select2-container--default .select2-selection--multiple,
            .select2-container--default .select2-selection--single {
                border: 1px solid #ced4da !important;
            }

            .select2-selection.select2-border {
                border: 0px solid !important;
            }

            .select2-container.is-valid {
                border: 1px solid #198754 !important;
                border-radius: 0.375rem;
                padding-right: calc(1.5em + 0.75rem);
                background-image: url({{ asset('/vendor/bootstrap-ui-components/valid-icon.svg') }});
                background-repeat: no-repeat;
                background-position: right calc(0.9rem + 0.1875rem) center;
                background-size: calc(1rem + 0.375rem) calc(0.75em + 0.375rem);
            }

            .select2-container.is-invalid {
                border: 1px solid #dc3545 !important;
                border-radius: 0.375rem;
                padding-right: calc(1.5em + 0.75rem);
                background-image: url({{ asset('/vendor/bootstrap-ui-components/invalid-icon.svg') }});
                background-repeat: repeat-x;
                background-position: right calc(2em + 0.1900rem) center;
                background-size: calc(0.75em + 102.375rem) calc(0.75em + 0.375rem);
            }
        </style>
        @endif
    @endpushonce
@endif
@if($btForm)
    <div class="{{ $btFormClass }}">@endif
        @if($label)
            <label class="{{ $labelClass }}" for="{{ $id }}">
                {{ $slot }}
                @if($attributes->has('required'))
                    <span class="{{ $requiredClass }}">*</span>
                @endif
            </label>
        @endif
        @if($attributes->has('multiple'))
            <div class="{{ $attributes->get('select2Class') ?? 'select2-purple' }}">
                @endif

                {{ $select_before ?? null }}

                <select class="{{ $class }}"
                        name="{{$name}}"
                        id="{{$id}}" {{ $attributes->except('options') }}
                    {{ $isHelp() }}>
                    @if($placeholder)
                        @if(!$attributes->has('multiple'))
                            <option value="" selected disabled>{{ $placeholder }}</option>
                        @endif
                    @endif
                    @if($getOption() && is_array($getOption()))
                        @forelse($getOption as $optionValue => $option)
                            <option
                                @if($attributes->has('multiple'))
                                    @selected(in_array($optionValue,explode(',',old($getName(),$value))))
                                @else
                                    @selected(old($getName(),$value)==$optionValue)
                                @endif
                                value="{{$optionValue}}">{{__($option)}}</option>
                        @empty
                        @endforelse
                    @endif
                </select>

                {{ $select_after ?? null }}

                @if(config('buicomponents.error') && $error)
                    @error($getName())
                    <span class="{{ $errorClass ?? config('buicomponents.error-class') }}" role="alert">
                        <strong>{{ __($message) }}</strong>
                    </span>
                    @enderror
                @endif
                @if($attributes->has('multiple'))
            </div>
        @endif
        @if($help)
            <small id="{{ $getName() }}Help" class="{{ $helpClass }}">{{ $help }}</small>
        @endif
        @if($btForm)</div>
@endif

@if(config('buicomponents.select2.enable'))
    @push('scripts')
        @once
            <!-- Select2 -->
            @forelse(config('buicomponents.select2.js') as $js)
                <script src="{{ $js }}" type="text/javascript"></script>
            @empty
            @endforelse
        @endonce
        <script>
            $(function () {
                //Initialize Select2 Elements
                @if(!is_array($getOption()))
                $('#{{ $id }}').select2({
                    @if($placeholder)
                    placeholder: '{{ $placeholder }}',
                    @endif
                    triggerChange: true,
                    ajax: {
                        url: "{{ $getOption() }}",
                        type: "get",
                        dataType: 'json',
                        delay: 250,
                        data: function (params) {
                            return {
                                search: params.term // search term
                            };
                        },
                        processResults: function (response) {
                            return {
                                results: response
                            };
                        },
                        cache: true
                    },
                    allowClear: true,
                    formatSelection: function (data) {
                        return data.text;
                    }
                });
                @if(old($getName(),$value))
                // Set default value using ajax
                let id = {!! $getValue(old($getName(),$value)) !!};
                if (id) {
                    $.ajax("{{ $getOption() }}", {
                        data: {
                            id: id
                        },
                        dataType: "json"
                    }).done(function (data) {
                        let options = [];
                        for (let i = 0; i < data.length; i++) {
                            options.push(new Option(data[i].text, data[i].id, true, true));
                        }
                        $('#{{$id}}').append(options).trigger('change');
                        $('#{{$id}}').val(id).trigger('change');
                    });
                }
                @endif
                @else
                @if($class)
                $('#{{$id}}').select2({
                    @if($placeholder)
                    placeholder: '{{ $placeholder }}',
                    @endif
                });
                @endif
                @endif
                @if(config('buicomponents.error') && $error)
                @error($getName())
                $('#{{$id}}').next('span.select2-container').addClass('is-invalid');
                $('#{{$id}}').next('span.select2-container').find('.selection').find('.select2-selection').addClass('select2-border');
                @elseif(old($getName(),$value))
                $('#{{$id}}').next('span.select2-container').addClass('is-valid');
                $('#{{$id}}').next('span.select2-container').find('.selection').find('.select2-selection').addClass('select2-border');
                @enderror
                @endif
            });
        </script>
    @endpush
@endif
