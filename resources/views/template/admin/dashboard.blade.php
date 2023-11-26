@extends('layouts.admin.admin_layout',['title'=>'Dashboard'])
@section('content')

    @push('styles')
        {{-- Custom Style --}}
    @endpush

    <!-- Content Header (Page header) -->
    <div class="content-header">
        <x-admin.title-and-breadcrumb title="Dashboard" breadcrumbs='{"Dashboard":"admin.dashboard"}'/>
        <!-- /.content-header -->

        <!-- Main content -->
        <section class="content">
            <div class="container-fluid">
                <div class="row">
                    @php $isAdmin = auth()->user()->isAdmin(); @endphp
                    @if($isAdmin)
                    <div class="col-lg-4 col-6">
                        <!-- small box -->
                        <div class="small-box bg-success">
                            <div class="inner">
                                <h3>{{ $activeVenuesCount }}</h3>

                                <p>Active Venues</p>
                            </div>
                            <div class="icon">
                                <i class="ion ion-location"></i>
                            </div>
                            <a href="{{ route('venues.index') }}" class="small-box-footer">More <i class="fas fa-arrow-circle-right"></i></a>
                        </div>
                    </div>
                    <div class="col-lg-4 col-6">
                        <!-- small box -->
                        <div class="small-box bg-danger">
                            <div class="inner">
                                <h3>{{ $inactiveVenuesCount }}</h3>

                                <p>Inactive Venues</p>
                            </div>
                            <div class="icon">
                                <i class="ion ion-locked"></i>
                            </div>
                            <a href="{{ route('venues.index') }}" class="small-box-footer">More <i class="fas fa-arrow-circle-right"></i></a>
                        </div>
                    </div>
                    @endif
                    <div class="@if($isAdmin) col-lg-4 @else col-lg-12 @endif col-6">
                        <!-- small box -->
                        <div class="small-box bg-info">
                            <div class="inner">
                                <h3>{{ $dealCount }}</h3>

                                <p>Deals</p>
                            </div>
                            <div class="icon">
                                <i class="ion ion-thumbsup"></i>
                            </div>
                            <a href="{{ route('deals.index') }}" class="small-box-footer">More <i class="fas fa-arrow-circle-right"></i></a>
                        </div>
                    </div>
                    <!-- ./col -->
                </div>
                <!-- /.row -->

            </div><!-- /.container-fluid -->
        </section>
        <!-- /.content -->
    @push('scripts')
        {{-- Custom JS --}}
    @endpush

@endsection
