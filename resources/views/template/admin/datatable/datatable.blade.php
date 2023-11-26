@extends('layouts.admin.admin_layout',['title' => $title ?? null])
@section('content')
    @if (isset($tabs))
    <ul class="nav nav-pills nav-justified my-3 px-1">
        @forelse($tabs as $tab)
        @can('have-access', $tab['permission'])
        <li class="nav-item mb-1">
            <a class="nav-link @if(isset($tab['active']) && $tab['active']) active @endif" @if(isset($tab['active']) && $tab['active']) aria-current="page" @endif href="{{ $tab['url'] }}">{{ __($tab['name']) }}</a>
        </li>
        @endcan
        @empty
        @endforelse
    </ul>
    @endif
    <div class="{{ $class ?? 'col-lg-12' }} grid-margin stretch-card">
        <div class="card">
            <div class="card-body">
                @if($title)
                    <h4 class="card-title">{{ __($title) }}</h4>
                @endif
                {{ $dataTable->table(['class'=>'table .table-bordered']) }}
            </div>
        </div>
    </div>
@endsection
@php $options = $dataTable->getOptions(); @endphp
@if(isset($options['delete']) && $options['delete'])
    <x-buicomponents::ui.modal-popup name="delete-popup" :modal-title="__('Delete')"
                                     modal-form-id="delete-modal-form" modal-footer-action-button-class="delete"
                                     :modal-footer-close-button="__('Close')"
                                     :modal-footer-action-button="__('Delete')">
        <x-buicomponents::ui.form method="POST" id="delete-modal-form" delete>
            <p>{{ __('Are you sure ?') }}</p>
        </x-buicomponents::ui.form>
        <x-slot name="modal_scripts">
            <script type="text/javascript">
                $('body').on('click', '.delete-button', function (e) {
                    e.preventDefault();
                    let action = $(this).data('action');
                    $('#delete-modal-form').attr('action', action);
                })
            </script>
        </x-slot>
    </x-buicomponents::ui.modal-popup>
    @if(session()->has('delete_confirm'))
        <x-buicomponents::ui.modal-popup name="delete-confirm-popup"
                                         :modal-title="__(session()->get('delete_confirm_message'))"
                                         modal-form-id="delete-confirm-modal-form"
                                         modal-footer-action-button-class="delete-confirm-button"
                                         :modal-footer-close-button="__('Close')"
                                         :modal-footer-action-button="__('Continue')">
            <x-buicomponents::ui.form :action="session()->get('delete_confirm_url')" method="POST"
                                      id="delete-confirm-modal-form" delete>
                <p>{{ __('Are you sure ?') }}</p>
                <x-buicomponents::ui.input type="hidden" name="id" :value="session()->get('delete_confirm_id')"/>
            </x-buicomponents::ui.form>
            <x-slot name="modal_scripts">
                <script type="text/javascript">
                    $(document).ready(function () {
                        $('#delete-confirm-popup').modal('show');
                    });
                </script>
            </x-slot>
        </x-buicomponents::ui.modal-popup>
    @endif
@endif
@push('styles')
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.4/css/dataTables.bootstrap5.min.css">
    @if($settings['data-table-plugins']->value ?? $settings['data-table-plugins']->default ?? config("datatables.enable-plugins") ?? true)
        @if(isset($options['buttons']))
            <link rel="stylesheet" href="https://cdn.datatables.net/buttons/2.3.6/css/buttons.bootstrap5.min.css">
        @endif
        @if(isset($options['autoFill']) && !empty($options['autoFill']))
            <link rel="stylesheet" href="https://cdn.datatables.net/autofill/2.5.3/css/autoFill.bootstrap5.min.css">
        @endif
        @if(isset($options['colReorder']) && !empty($options['colReorder']))
            <link rel="stylesheet" href="https://cdn.datatables.net/colreorder/1.6.2/css/colReorder.bootstrap5.min.css">
        @endif
        @if(isset($options['fixedHeader']) && !empty($options['fixedHeader']))
            <link rel="stylesheet"
                  href="https://cdn.datatables.net/fixedheader/3.3.2/css/fixedHeader.dataTables.min.css">
        @endif
        @if(isset($options['responsive']) && !empty($options['responsive']))
            <link rel="stylesheet" href="https://cdn.datatables.net/responsive/2.4.1/css/responsive.dataTables.min.css">
        @endif
        @if(isset($options['rowGroup']) && !empty($options['rowGroup']))
            <link rel="stylesheet" href="https://cdn.datatables.net/rowgroup/1.3.1/css/rowGroup.dataTables.min.css">
        @endif
        @if(isset($options['rowReorder']) && !empty($options['rowReorder']))
            <link rel="stylesheet" href="https://cdn.datatables.net/rowreorder/1.3.3/css/rowReorder.dataTables.min.css">
        @endif
        @if(isset($options['scroller']) && !empty($options['scroller']))
            <link rel="stylesheet" href="https://cdn.datatables.net/scroller/2.1.1/css/scroller.dataTables.min.css">
        @endif
        @if(isset($options['searchPanes']) && !empty($options['searchPanes']))
            <link rel="stylesheet"
                  href="https://cdn.datatables.net/searchbuilder/1.4.2/css/searchBuilder.dataTables.min.css">
            <link rel="stylesheet"
                  href="https://cdn.datatables.net/searchpanes/2.1.2/css/searchPanes.dataTables.min.css">
        @endif
        @if(isset($options['select']) && !empty($options['select']))
            <link rel="stylesheet" href="https://cdn.datatables.net/select/1.6.2/css/select.dataTables.min.css">
        @endif
        @if(isset($options['stateSave']) && !empty($options['stateSave']))
            <link rel="stylesheet"
                  href="https://cdn.datatables.net/staterestore/1.2.2/css/stateRestore.dataTables.min.css">
        @endif
    @endif
@endpush
@push('scripts')
    <script src="https://cdn.datatables.net/1.13.4/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.4/js/dataTables.bootstrap5.min.js"></script>
    @if($settings['data-table-plugins']->value ?? $settings['data-table-plugins']->default ?? config("datatables.enable-plugins") ?? true)
        @if(isset($options['buttons']) && !empty($options['buttons']))
            <script src="https://cdn.datatables.net/buttons/2.3.6/js/dataTables.buttons.min.js"></script>
            <script src="https://cdn.datatables.net/buttons/2.3.6/js/buttons.bootstrap5.min.js"></script>
            <script src="https://cdn.datatables.net/buttons/2.3.6/js/buttons.html5.min.js"></script>
            @if(array_column($options['buttons'],'extend'))
                @php $button = array_flip(array_column($options['buttons'],'extend')); @endphp
                @if(array_key_exists('print',$button))
                    <script src="https://cdn.datatables.net/buttons/2.3.6/js/buttons.print.min.js"></script>
                @endif
                @if(array_key_exists('colvis',$button))
                    <script src="https://cdn.datatables.net/buttons/2.3.6/js/buttons.colVis.min.js"></script>
                @endif
            @endif
        @endif
        @if(isset($options['autoFill']) && !empty($options['autoFill']))
            <script src="https://cdn.datatables.net/autofill/2.5.3/js/dataTables.autoFill.min.js"></script>
            <script src="https://cdn.datatables.net/autofill/2.5.3/js/autoFill.bootstrap5.min.js"></script>
        @endif
        @if(isset($options['colReorder']) && !empty($options['colReorder']))
            <script src="https://cdn.datatables.net/colreorder/1.6.2/js/dataTables.colReorder.min.js"></script>
        @endif
        @if(isset($options['fixedHeader']) && !empty($options['fixedHeader']))
            <script src="https://cdn.datatables.net/fixedheader/3.3.2/js/dataTables.fixedHeader.min.js"></script>
        @endif
        @if(isset($options['responsive']) && !empty($options['responsive']))
            <script src="https://cdn.datatables.net/responsive/2.4.1/js/dataTables.responsive.min.js"></script>
        @endif
        @if(isset($options['rowGroup']) && !empty($options['rowGroup']))
            <script src="https://cdn.datatables.net/rowgroup/1.3.1/js/dataTables.rowGroup.min.js"></script>
        @endif
        @if(isset($options['rowReorder']) && !empty($options['rowReorder']))
            <script src="https://cdn.datatables.net/rowreorder/1.3.3/js/dataTables.rowReorder.min.js"></script>
        @endif
        @if(isset($options['scroller']) && !empty($options['scroller']))
            <script src="https://cdn.datatables.net/scroller/2.1.1/js/dataTables.scroller.min.js"></script>
        @endif
        @if(isset($options['searchPanes']) && !empty($options['searchPanes']))
            <script src="https://cdn.datatables.net/searchbuilder/1.4.2/js/dataTables.searchBuilder.min.js"></script>
            <script src="https://cdn.datatables.net/searchpanes/2.1.2/js/dataTables.searchPanes.min.js"></script>
        @endif
        @if(isset($options['select']) && !empty($options['select']))
            <script src="https://cdn.datatables.net/select/1.6.2/js/dataTables.select.min.js"></script>
        @endif
        @if(isset($options['stateSave']) && !empty($options['stateSave']))
            <script src="https://cdn.datatables.net/staterestore/1.2.2/js/dataTables.stateRestore.min.js"></script>
        @endif
    @endif
    {{ $dataTable->scripts(attributes: ['type' => 'module']) }}
    <script type="text/javascript">
        $(document).ajaxError(function(event, jqxhr, settings, exception) {

            if (exception == 'Unauthorized') {

                // Prompt user if they'd like to be redirected to the login page
                bootbox.confirm("Your session has expired. Would you like to be redirected to the login page?", function(result) {
                    if (result) {
                        window.location = '/login';
                    }
                });

            }
        });
        $.fn.dataTable.ext.errMode = 'none';
    </script>
@endpush
