<div class="layout-wrapper">

    @include('components.home.header')

    <div class="content-wrapper">

        @include('components.home.navbar')
        
        <div class="content-body">
            <!-- Content -->
            <div class="content">

                @yield('page')

                {{-- @include('components.home.footer') --}}

            </div>

        </div>

    </div>
    
</div>