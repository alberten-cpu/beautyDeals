@pushonce('scripts')
    <style>
        .modal-body img {
            display: block;
            max-width: 100%;
        }
    </style>
@endpushonce
@push('styles')
    <style>
        .modal-body .{{ $getName() }}_preview {
            overflow: hidden;
            width: 150px;
            height: 150px;
            border: 1px solid red;
        }
    </style>
@endpush
<x-bootstrap-ui-components::ui.preview-image :name="$getName()" :value="$value"
                                             :button-name="$attributes->get('button-name')"
                                             :button-name-on-change="$attributes->get('button-name-on-change')"
                                             :preview-theme="$attributes->get('preview-theme')"
                                             :default-image="$attributes->get('default-image')"
                                             :required="$attributes->get('required')"
                                             :error="$attributes->get('error') ?? $error"
                                             :form-id="$attributes->get('form-id')" 
                                             :class="$class"/>
<x-bootstrap-ui-components::ui.modal-popup :name="$getName().'_modal'" modal-title="Crop the image"
                                           modal-footer-action-button="Crop"
                                           modal-footer-action-button-class="{{ $getName() }}_crop">
    <div class="modal-body">
        <div class="img-container">
            <div class="row">
                <div class="col-md-8">
                    <img src="" id="{{ $getName() }}_crop_preview" class="img-fluid img-thumbnail"/>
                </div>
                <div class="col-md-4 m-auto mt-2 mt-md-auto">
                    <div class="{{ $getName() }}_preview"></div>
                </div>
            </div>
        </div>
    </div>
</x-bootstrap-ui-components::ui.modal-popup>
@if(config('buicomponents.cropper')['enable'])
    @pushonce('styles')
        @forelse(config('buicomponents.cropper')['css'] as $css)
            <link rel="stylesheet" href="{{ $css }}" crossorigin="anonymous">
        @empty
        @endforelse
    @endpushonce
    @pushonce('scripts')
        @forelse(config('buicomponents.cropper')['js'] as $js)
            <script src="{{ $js }}" type="text/javascript"></script>
        @empty
        @endforelse
    @endpushonce
@endif
@push('scripts')
    <script>

        $(document).ready(function () {

            let $modal = $('#{{ $getName() }}_modal');

            let image = document.getElementById('{{ $getName() }}_crop_preview');

            let cropper;

            $('body').on('change', '#{{ $getName() }}_file_input', function (event) {
                let files = event.target.files;

                let done = function (url) {
                    image.src = url;
                    $modal.modal('show');
                    $('#{{ $getName() }}_file_input').val('');
                };

                if (files && files.length > 0) {
                    let reader = new FileReader();
                    reader.onload = function (event) {
                        done(reader.result);
                    };
                    reader.readAsDataURL(files[0]);
                }
            });

            $modal.on('shown.bs.modal', function () {
                cropper = new Cropper(image, {
                    aspectRatio: {{ $attributes->get('aspect-ratio') ?? 2 }},
                    viewMode: {{ $attributes->get('view-mode') ?? 2 }},
                    preview: '.{{ $getName() }}_preview',
                    responsive: {{ $attributes->get('responsive') ?? true }},
                    {{$attributes->get('options')}}
                });
            }).on('hidden.bs.modal', function () {
                cropper.destroy();
                cropper = null;
            });

            $('.{{ $getName() }}_crop').click(function () {
                let canvas = cropper.getCroppedCanvas({
                    minWidth: {{ $attributes->get('min-width') ?? 256 }},
                    minHeight: {{ $attributes->get('min-height') ?? 256 }},
                    maxWidth: {{ $attributes->get('max-width') ?? 4096 }},
                    maxHeight: {{ $attributes->get('max-height') ?? 4096 }},
                    fillColor: '{{ $attributes->get('fill-color') ?? '#fff' }}',
                    imageSmoothingEnabled: true,
                    imageSmoothingQuality: 'high',
                });

                canvas.toBlob(function (blob) {
                    URL.createObjectURL(blob);
                    let reader = new FileReader();
                    reader.readAsDataURL(blob);
                    reader.onloadend = function () {
                        let base64data = reader.result;
                        $modal.modal('hide');
                        $('#{{ $getName() }}_out_put_preview').attr('src', base64data);
                        $('#{{ $getName() }}_out_put_preview').attr('srcset', base64data);
                        $('#{{ $getName() }}').val(base64data).change();
                        $('#{{ $getName() }}_file_input').val('');
                    };
                });

            });

        });
    </script>
@endpush
