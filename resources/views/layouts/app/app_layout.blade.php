<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<x-admin.head :title="$title">
    @stack('styles')
</x-admin.head>
<body class="new-theme">
@yield('content')
<x-admin.foot>
    @stack('scripts')
</x-admin.foot>
</body>
</html>
