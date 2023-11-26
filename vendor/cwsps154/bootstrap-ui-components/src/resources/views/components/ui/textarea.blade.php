@php
    $inputClasses = [$class];

    if($errors->has($getName()) && ($error && config('buicomponents.error'))) {
        $inputClasses[] = 'is-invalid';
    } elseif (!empty(old($getName())) && ($error && config('buicomponents.error'))) {
        $inputClasses[] = 'is-valid';
    }

    $inputClass = implode(' ', $inputClasses);
@endphp
@if($btForm)
    <div class="{{ $btFormClass }}">@endif
        @if($label)
            <label for="{{ $id }}" class="{{ $labelClass }}">
                {{ $slot }}
                @if($attributes->has('required'))
                    <span class="{{ $requiredClass }}">*</span>
                @endif
            </label>
        @endif

        {{ $textarea_before ?? null }}

        <textarea class="{{ $inputClass }}" id="{{ $id }}" name="{{ $name }}"
                  placeholder="{{ $placeholder }}" {{ $attributes }} {{ $isHelp() }}>{{ old($getName(),$value) }}</textarea>

        {{ $textarea_after ?? null }}
                  
        @if($help)
            <small id="{{ $getName() }}Help" class="{{ $helpClass }}">{{ $help }}</small>
        @endif
        @if($errors->has($getName()) && ($error && config('buicomponents.error')))
            @error($getName())
            <span class="{{ $errorClass ?? config('buicomponents.error-class') }}" role="alert">
                <strong>{{ __($message) }}</strong>
            </span>
            @enderror
        @endif
        @if($btForm)</div>
@endif
@push('scripts')
    {{ $before_scripts ?? null }}
@endpush
@if(config('buicomponents.tinymce.enable'))
    @pushonce('styles')
        @forelse(config('buicomponents.tinymce')['css'] as $css)
            <link rel="stylesheet" href="{{ $css }}" crossorigin="anonymous">
        @empty
        @endforelse
    @endpushonce
    @pushonce('scripts')
        @forelse(config('buicomponents.tinymce')['js'] as $js)
            <script src="{{ $js }}" type="text/javascript"></script>
        @empty
        @endforelse
    @endpushonce
@pushonce('scripts')
    <script>
        {{ $before_tiny_scripts ?? null }}
        tinymce.init({
            selector: 'textarea[data-provide="tinymce"]',
            plugins: '{{ $getPlugins }}',
            toolbar: '{{ $getToolbar }}',
            {{ config('buicomponents.tinymce.other-options').$attributes->get('other-options') }}
        });
        {{ $afte_tiny_scripts ?? null }}
    </script>
@endpushonce
@endif
@if(config('buicomponents.ckeditor.enable'))
    @pushonce('styles')
        @forelse(config('buicomponents.ckeditor')['css'] as $css)
            <link rel="stylesheet" href="{{ $css }}" crossorigin="anonymous">
        @empty
        @endforelse
    @endpushonce
    @pushonce('scripts')
        @forelse(config('buicomponents.ckeditor')['js'] as $js)
            <script src="{{ $js }}" type="text/javascript"></script>
        @empty
        @endforelse
    @endpushonce
    @pushonce('scripts')
        <script>
            {{ $before_ceditor_scripts ?? null }}
            ClassicEditor
                .create( document.querySelector( 'textarea[data-provide="ckeditor"]' ) )
                .catch( error => {
                    console.error( error );
                });
            {{ $after_ceditor_scripts ?? null }}
        </script>
    @endpushonce
@endif
@if(config('buicomponents.summernote.enable'))
    @pushonce('styles')
        @forelse(config('buicomponents.summernote')['css'] as $css)
            <link rel="stylesheet" href="{{ $css }}" crossorigin="anonymous">
        @empty
        @endforelse
    @endpushonce
    @pushonce('scripts')
        @forelse(config('buicomponents.summernote')['js'] as $js)
            <script src="{{ $js }}" type="text/javascript"></script>
        @empty
        @endforelse
    @endpushonce
    @pushonce('scripts')
        <script>
            $(document).ready(function() {
            {{ $before_summernote_scripts ?? null }}
                $('textarea[data-provide="summernote"]').summernote({
                    placeholder: '{{ $placeholder }}',
                    {!! config('buicomponents.summernote.other-options').$attributes->get('other-options') !!}
                });
            {{ $after_summernote_scripts ?? null }}
            });
        </script>
    @endpushonce
@endif
@push('scripts')
    {{ $scripts ?? null }}
@endpush
