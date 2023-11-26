@php
    $inputClasses = [$class];

    if($errors->has($getName()) && ($error && config('buicomponents.error'))) {
        $inputClasses[] = 'is-invalid';
    } elseif (!empty(old($mergedName())) && ($error && config('buicomponents.error'))) {
        $inputClasses[] = 'is-valid';
    }

    $inputClass = implode(' ', $inputClasses);
@endphp

@if($btForm)
    <div class="{{ $btFormClass }}">
        @endif

        {{ $input_before ?? null }}

        <input type="{{ $type }}" class="{{ $inputClass }}" id="{{ $id }}" name="{{ $name }}"
               {{ $isHelp() }} {{ $attributes->except('defaultValue') }} {{ $isChecked(old($mergedName(),$value)) }} value="{{ $attributes->get('defaultValue') }}">

        {{ $input_after ?? null }}

        @if($label)
            <label for="{{ $id }}" class="{{ $labelClass }}">
                {{ $slot }}
                @if($attributes->has('required'))
                    <span class="{{ $requiredClass }}">*</span>
                @endif
            </label>
        @endif

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

        @if($btForm)
    </div>
@endif
