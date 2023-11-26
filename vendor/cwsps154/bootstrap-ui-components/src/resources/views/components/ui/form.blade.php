<form method="{{ strtoupper($method) }}" {{ $attributes }}>
    @if (strtoupper($method) != 'GET')
        @csrf
        @if($update)
            @method('PATCH')
        @endif
        @if($delete)
            @method('DELETE')
        @endif
    @endif
    {{ $slot }}
</form>
