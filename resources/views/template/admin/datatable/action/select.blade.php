<div class="btn-group">
    <x-buicomponents::ui.button name="save" type="button" class="btn btn-primary dropdown-toggle py-2"
                                data-bs-toggle="dropdown">
        {{__("Select")}}
    </x-buicomponents::ui.button>
    <div class="dropdown-menu">
        @php $id = $query->getKeyName();@endphp
        @forelse($buttons as $name => $button)
            @include('template.admin.datatable.action.button',
                    [
                        'query'=>$query,
                        'name'=>$name,
                        'class'=>$button['class'] ?? null,
                        'route'=>$button['route'] ?? null,
                        'route_id'=>$button['route_id'] ?? $query->$id,
                        'permission'=>$button['permission'] ?? null,
                        'attributes' => $button['attributes'] ?? null
                    ])
        @empty
        @endforelse
    </div>
</div>
