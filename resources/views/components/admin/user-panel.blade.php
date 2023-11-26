@php use App\Models\Role;use App\Models\Venues; @endphp
    <!-- Sidebar user panel (optional) -->
<div class="user-panel mt-3 pb-3 mb-3 d-flex">
    <div class="image">
        @if(auth()->user()->isUser())
            @php $venue = Venues::geVenueByUserId(auth()->id()); @endphp
            @if(isset($venue->images[0]) && $venue->images[0]->imageType == 'logo')
                <img src="{{ asset('Users/'.$venue->user->userId.'/'.$venue->images[0]?->imagePath) }}" class="img-circle elevation-2" alt="User Image">
            @endif
        @else
            <img src="{{ asset('/admin/dist/img/user2-160x160.jpg') }}" class="img-circle elevation-2" alt="User Image">
        @endif
    </div>
    <div class="info">
        @if(auth()->user()->isUser())
            @php $venue = Venues::geVenueByUserId(auth()->id()); @endphp
            <a href="#" class="d-block">{{ $venue->venueName ?? '' }}</a>
        @else
            <a href="#" class="d-block">{{ auth()->user()->email ?? '' }}</a>
        @endif
    </div>
</div>
