@pushonce('styles')
    <style>
        .cropped-image-preview .overlay {
            position: absolute;
            bottom: 10px;
            left: 0;
            right: 0;
            background-color: rgba(255, 255, 255, 0.5);
            overflow: hidden;
            height: 0;
            transition: .5s ease;
            width: 100%;
        }

        .cropped-image-preview .image_area {
            background-size: contain;
            background-position: center;
            position: relative;
            overflow: hidden;
            padding: 0.25rem;
            background-color: #fff;
            border: 1px solid #dee2e6;
            border-radius: 0.375rem;
            height: auto;
            max-width: 500px;
        }

        .cropped-image-preview .justify-content-center img, .cropped-image-preview .cropped-image-preview-action {
            height: auto;
            max-width: 500px;
            margin: auto;
        }

        .cropped-image-preview .image_area:hover .overlay {
            height: 50%;
            cursor: pointer;
        }

        .cropped-image-preview .text {
            color: #333;
            font-size: 20px;
            position: absolute;
            top: 50%;
            left: 50%;
            -webkit-transform: translate(-50%, -50%);
            -ms-transform: translate(-50%, -50%);
            transform: translate(-50%, -50%);
        }

        .cropped-image-preview.error img, .cropped-image-preview.error .image_area {
            border: 1px solid red;
        }
    </style>
@endpushonce
@if(($attributes->get('preview-theme') ? $attributes->get('preview-theme')==='bootstrap' : config('buicomponents.cropper')['theme']=='bootstrap') && config('buicomponents.cropper')['enable'])
    <div class="cropped-image-preview {{ $name }}_validation">
        <div class="mb-4 d-flex justify-content-center">
            <img src="{{ old($name,$value) ?? $attributes->get('default-image') ?? config('buicomponents.cropper.default_image') }}"
                 alt="{{ $name }}" class="{{ $class }}" id="{{ $name }}_out_put_preview"/>
        </div>
        <div class="d-flex justify-content-center cropped-image-preview-action">
            <div class="btn btn-primary w-100">
                <x-buicomponents::ui.file name="{{ $name }}_file_input" id="{{ $name }}_file_input" class="d-none"
                                          :btForm="false" labelClass="mb-0" accept="image/png, image/gif, image/jpeg">
                    {{$attributes->get('button-name') ?? __('Browse Image')}}
                </x-buicomponents::ui.file>
            </div>
        </div>
        <div class="text-center">
            <x-buicomponents::ui.input name="{{ $name }}" :value="$value" :btForm="false"
                                       :label="false" class="d-none"
                                       :error="$attributes->get('error') ?? $error"/>
        </div>
    </div>
@elseif(($attributes->get('preview-theme') ? $attributes->get('preview-theme')==='overlay' : config('buicomponents.cropper')['theme']=='overlay') && config('buicomponents.cropper')['enable'])
    <div class="row cropped-image-preview {{ $name }}_validation">
        <div class="image_area m-auto">
            <label for="{{ $name }}_file_input">
                <img
                    src="{{ old($name,$value) ?? $attributes->get('default-image') ?? config('buicomponents.cropper.default_image') }}"
                    alt="{{ $name }}" class="{{ $class }}" id="{{ $name }}_out_put_preview">
                <x-buicomponents::ui.file name="{{ $name }}_file_input" id="{{ $name }}_file_input"
                                          class="d-none" :btForm="false" labelClass="mb-0"
                                          accept="image/png, image/gif, image/jpeg"></x-buicomponents::ui.file>
                <div class="text-center">
                    <x-buicomponents::ui.input name="{{ $name }}" :value="$value" :btForm="false"
                                               :label="false" class="d-none"
                                               :error="$attributes->get('error') ?? $error"/>
                </div>
                <div class="overlay">
                    <div class="text text-center">{{$attributes->get('button-name') ?? __('Browse Image')}}</div>
                </div>
            </label>
        </div>
    </div>
@endif
@if($errors->has($name) && ($error && config('buicomponents.error')))
    @push('scripts')
        <script>
            $('.{{ $name }}_validation').addClass('error');
            $('.{{ $name }}_validation .btn').removeClass('btn-primary');
            $('.{{ $name }}_validation .btn').addClass('btn-danger');
        </script>
    @endpush
@endif
@if($attributes->get('form-id'))
    @push('scripts')
        <script>
            $(document).ready(function () {
                $('#{{ $attributes->get('form-id') }}').submit(function (e) {
                    let value = $('#{{ $name }}').val();
                    if(!value)
                    {
                        let required = '{{ $attributes->get('required') }}';
                        if (required) {
                            e.preventDefault();
                            $('.{{ $name }}_validation').addClass('error');
                            $('.{{ $name }}_validation .cropped-image-preview-action .btn').removeClass('btn-primary');
                            $('.{{ $name }}_validation .cropped-image-preview-action .btn').addClass('btn-danger');
                        }
                    }else{
                        $('.{{ $name }}_validation').removeClass('error');
                        $('.{{ $name }}_validation .cropped-image-preview-action .btn').addClass('btn-primary');
                        $('.{{ $name }}_validation .cropped-image-preview-action .btn').removeClass('btn-danger');
                    }
                })
            });
        </script>
    @endpush
@endif
@push('scripts')
    <script>
        $(document).ready(function ()
        {
            $('#{{ $name }}_file_input').on('change',function (){
                @if(($attributes->get('preview-theme') ? $attributes->get('preview-theme')==='bootstrap' : config('buicomponents.cropper')['theme']=='bootstrap') && config('buicomponents.cropper')['enable'])
                  $('.{{ $name }}_validation').find('label').text('{{ $attributes->get('button-name-on-change') ?? 'Change Image' }}');
                @endif
                @if(($attributes->get('preview-theme') ? $attributes->get('preview-theme')==='overlay' : config('buicomponents.cropper')['theme']=='overlay') && config('buicomponents.cropper')['enable'])
                $('.{{ $name }}_validation').find('.overlay div').text('{{$attributes->get('button-name-on-change') ?? 'Change Image'}}');
                @endif
            });
        });
    </script>
@endpush
