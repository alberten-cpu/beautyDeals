@prepend('scripts')
    <!-- Modal -->
    <div class="modal fade" id="{{ $name }}" tabindex="-1" aria-labelledby="{{ $name }}Label" aria-hidden="true"data-bs-backdrop="static" data-bs-keyboard="false">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    @if($attributes->has('modal-title'))
                        <h5 class="modal-title" id="{{ $name }}Label">{{ $attributes->get('modal-title') }}</h5>
                    @endif
                    <x-buicomponents::ui.button class="btn-close" data-bs-dismiss="modal" aria-label="Close"/>
                </div>
                <div class="modal-body">
                    {{ $slot }}
                </div>
                @if($attributes->get('modal-footer') ?? true)
                    <div class="modal-footer">
                        @if($attributes->get('modal-footer-close-button') ?? true)
                            <x-buicomponents::ui.button
                                class="{{ $attributes->get('modal-footer-close-button-class') .' btn btn-secondary' }}"
                                data-bs-dismiss="modal">{{ $attributes->get('modal-footer-close-button') ?? __('Close') }}</x-buicomponents::ui.button>
                        @endif
                        @if($attributes->get('modal-footer-action-button') ?? true)
                            <x-buicomponents::ui.button
                                class="{{ $attributes->get('modal-footer-action-button-class').' btn btn-primary' }}">{{ $attributes->get('modal-footer-action-button') ?? __('Submit') }}</x-buicomponents::ui.button>
                        @endif
                    </div>
                @endif
            </div>
        </div>
    </div>
@endprepend

@if($attributes->has('modal-form-id') && $attributes->has('modal-footer-action-button-class'))
    @push('scripts')
        <script type="text/javascript">
            $('.{{ $attributes->get('modal-footer-action-button-class') }}').click(function () {
                $('#{{ $attributes->get('modal-form-id') }}').submit();
            });
        </script>
    @endpush
@endif

@push('scripts')
    {{ $modal_scripts ?? null }}
@endpush
