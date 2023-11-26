<a href="{{ isset($route) ? route($route,$route_id)  : '#' }}"
   class="{{ $class ?? null}}" {{ $attributes ?? null}}>{{ __($name) }}</a>
