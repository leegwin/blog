<div class="side-menu">
    <nav class="navbar-default navbar-side" role="navigation">
        <div class="sidebar-collapse">
            <ul class="nav" id="main-menu">
                @include('common.menu-zone')
                @if($auth['sec']==1)
                    @include('common.menu-section')
                @endif

                @if($auth['top']==1)
                    @include('common.menu-topic')
                @endif

                @if($auth['rep']==1)
                    @include('common.menu-reply')
                @endif

                @if($auth['man']==1)
                    @include('common.menu-authority')
                @endif
            </ul>
        </div>
    </nav>
</div>
<!-- /. NAV SIDE  -->'?>
