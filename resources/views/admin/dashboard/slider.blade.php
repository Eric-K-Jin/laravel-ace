<div id="sidebar" class="sidebar                  responsive">
    <script type="text/javascript">
        try {
            ace.settings.check('sidebar', 'fixed')
        } catch (e) {
        }
    </script>

    <div class="sidebar-shortcuts" id="sidebar-shortcuts">
        <div class="sidebar-shortcuts-large" id="sidebar-shortcuts-large">
            <button class="btn btn-success">
                <i class="ace-icon fa fa-signal"></i>
            </button>

            <button class="btn btn-info">
                <i class="ace-icon fa fa-pencil"></i>
            </button>

            <!-- #section:basics/sidebar.layout.shortcuts -->
            <button class="btn btn-warning">
                <i class="ace-icon fa fa-users"></i>
            </button>

            <button class="btn btn-danger">
                <i class="ace-icon fa fa-cogs"></i>
            </button>

            <!-- /section:basics/sidebar.layout.shortcuts -->
        </div>

        <div class="sidebar-shortcuts-mini" id="sidebar-shortcuts-mini">
            <span class="btn btn-success"></span>

            <span class="btn btn-info"></span>

            <span class="btn btn-warning"></span>

            <span class="btn btn-danger"></span>
        </div>
    </div><!-- /.sidebar-shortcuts -->

    <ul class="nav nav-list">
        @foreach ($menus as $row)
            <li class="">
                @if (!isset($row->permissions))
                    <a data-url="{{ $row->description }}" href="#{{ $row->description }}">
                        <i class="menu-icon {{ $row->icon }}"></i>
                        <span class="menu-text"> {{ $row->label }} </span>
                    </a>
                @else
                    <a href="#" class="dropdown-toggle">
                        <i class="menu-icon {{ $row->icon }}"></i>
                        <span class="menu-text"> {{ $row->label }} </span>

                        <b class="arrow fa fa-angle-down"></b>
                    </a>
                @endif

                <b class="arrow"></b>
                @if (isset($row->permissions))
                    <ul class="submenu">
                        @foreach ($row->permissions as $r)
                            <li class="">
                                <a data-url="{{ $r->description }}" href="#{{ $r->description }}">
                                    <i class="menu-icon fa fa-caret-right"></i>
                                    {{ $r->label }}
                                </a>

                                <b class="arrow"></b>
                            </li>
                        @endforeach
                    </ul>
                @endif
            </li>
        @endforeach
    </ul>

    <!-- #section:basics/sidebar.layout.minimize -->
    <div class="sidebar-toggle sidebar-collapse" id="sidebar-collapse">
        <i class="ace-icon fa fa-angle-double-left" data-icon1="ace-icon fa fa-angle-double-left"
           data-icon2="ace-icon fa fa-angle-double-right"></i>
    </div>

    <!-- /section:basics/sidebar.layout.minimize -->
    <script type="text/javascript">
        try {
            ace.settings.check('sidebar', 'collapsed')
        } catch (e) {
        }
    </script>
</div>