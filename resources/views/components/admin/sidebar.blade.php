<!-- Main Sidebar Container -->
<aside class="main-sidebar sidebar-primary elevation-4">
    <x-admin.logo/>

    <!-- Sidebar -->
    <div class="sidebar">
        <x-admin.user-panel/>
        {{--        <x-admin.search-form/>--}}
        <!-- Sidebar Menu -->
        <nav class="mt-2">
            <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
                <!-- Add icons to the links using the .nav-icon class
                     with font-awesome or any other icon font library -->
                {{--Admin Menus--}}
                <x-admin.ui.menu name="Dashboard" route="dashboard" icon="fas fa-home" target="0"
                                 new="0" count="0"/>
                @if(auth()->user()->isAdmin())
                <x-admin.ui.menu name="Venues" route="venues.index" icon="fas fa-location-arrow" target="0"
                                     new="0" count="0"/>
                    <x-admin.ui.menu name="Suburbs" route="suburbs.index" icon="fa fa-map-marker" target="0"
                                     new="0" count="0"/>
                    <x-admin.ui.dropdown-menu name="Deals" icon="fas fa-handshake"
                                                                  menus='[{"label":"Deals","route":"deals.index",
                                                                  "target":"0","new":"0","count":"0"},
                                                                  {"label":"Deal Category","route":"categories.index",
                                                                  "target":"0","new":"0","count":"0"},
                                                                  {"label":"Deal SubCategory","route":"sub_categories.index",
                                                                  "target":"0","new":"0","count":"0"}]'/>
                    <x-admin.ui.menu name="Products" route="product.index" icon="fas fa-handshake" target="0"
                                                                  new="0" count="0"/>
                @elseif(auth()->user()->isUser())
                    <x-admin.ui.menu name="Deals" route="deals.index" icon="fas fa-handshake" target="0"
                                     new="0" count="0"/>
                    <x-admin.ui.menu name="Products" route="product.index" icon="fas fa-handshake" target="0"
                                     new="0" count="0"/>
                @endif
            </ul>
        </nav>
        <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
</aside>
