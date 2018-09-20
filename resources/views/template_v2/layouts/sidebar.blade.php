<div class="scroll-sidebar">
    <!-- Sidebar navigation-->
    <nav class="sidebar-nav">
        <ul id="sidebarnav">
            <li class="nav-devider"></li>
            <li class="nav-label">Menu</li>

            {{-- Search New --}}
            @role(['tester', 'admin'])
            <li>
                <a class="has-arrow " href="#" aria-expanded="false">
                    <i class="fa fa-search text-danger"></i>
                    <span class="hide-menu">
                        Search v2
                        <span class="badge badge-danger">beta</span>
                    </span>
                </a>
                <ul aria-expanded="false" class="collapse">
                    <li>
                        <a href="{{ route('reports.index', 'audiobooks') }}">Audiobooks</a>
                    </li>
                    <li>
                        <a href="{{ route('reports.index', 'books') }}">Books</a>
                    </li>
                    <li>
                        <a href="{{ route('reports.index', 'movies') }}">Movies</a>
                    </li>
                    <li>
                        <a href="{{ route('reports.index', 'albums') }}">Albums</a>
                    </li>
                </ul>
            </li>
            @endrole


            {{-- Search --}}
            <li>
                <a class="has-arrow " href="#" aria-expanded="false">
                    <i class="fa fa-search"></i>
                    <span class="hide-menu">
                        Search
                    </span>
                </a>
                <ul aria-expanded="false" class="collapse">
                    <li>
                        <a href="{{ route('search', ['contentType' => 'movies']) }}">Movies</a>
                    </li>
                    <li>
                        <a href="{{ route('search', ['contentType' => 'audiobooks']) }}">Audiobooks</a>
                    </li>
                    <li>
                        <a href="{{ route('search', ['contentType' => 'books']) }}">Books</a>
                    </li>
                    <li>
                        <a href="{{ route('search', ['contentType' => 'albums']) }}">Albums</a>
                    </li>
                    <li>
                        <a href="{{ route('search', ['contentType' => 'games']) }}">Games</a>
                    </li>

                    <li class="nav-devider"></li>

                    <li>
                        <a href="{{ route('authors.index') }}">Authors</a>
                        <a href="{{ route('licensors.index') }}">Licensors</a>

                        {{--<ul aria-expanded="false" class="collapse">--}}
                            {{--<li>--}}
                                {{--<a href="author/books">Books</a>--}}
                            {{--</li>--}}
                        {{--</ul>--}}
                    </li>
                </ul>
            </li>

            {{-- Brightcove --}}
            <li>
                <a class="has-arrow " href="#" aria-expanded="false">
                    <i class="fa fa-video"></i>
                    <span class="hide-menu">
                        Brightcove
                        {{--<span class="label label-rouded label-primary pull-right">2</span>--}}
                    </span>
                </a>
                <ul aria-expanded="false" class="collapse">
                    <li><a href="{{ route('brightcove.folders') }}">Folders </a></li>
                    <li><a href="{{ route('brightcove.videos') }}">Videos </a></li>
                </ul>
            </li>

            {{-- Aws --}}
            <li>
                <a class="has-arrow " href="#" aria-expanded="false">
                    <i class="fab fa-aws"></i>
                    <span class="hide-menu">
                        Aws
                    </span>
                </a>
                <ul aria-expanded="false" class="collapse">
                    <li><a href="{{ route('aws.index') }}">Notifications</a></li>
                </ul>
            </li>

            {{--Tools --}}
            @permission('view-tools')
            <li>
                <a class="has-arrow " href="#" aria-expanded="false">
                    <i class="fa fas fa-wrench"></i>
                    <span class="hide-menu">
                        Tools
                    </span>
                </a>
                <ul aria-expanded="false" class="collapse">
                    <li><a href="#"></a>Coming soon</li>
                </ul>
            </li>
            @endpermission

            <li>
                <a class="has-arrow" href="#" aria-expanded="false">
                    <i class="fa fa-flag"></i>
                    <span class="hide-menu">
                        Content blacklist
                    </span>
                </a>

                <ul aria-expanded="false" class="collapse">
                    <li>
                        <a href="{{ route('blackList.index') }}">Search</a>
                    </li>
                    <li>
                        <a href="{{ route('blackList.manage') }}">Manage</a>
                    </li>
                </ul>
            </li>

            @role(['admin', 'ingester'])
            <li>
                <a class="has-arrow" href="#" aria-expanded="false">
                    <i class="fab fa-php"></i>
                    <span class="hide-menu">
                        Ingestion
                    </span>
                </a>

                <ul aria-expanded="false" class="collapse">
                    <li>
                        <a class="has-arrow" href="#">Rabbitmq</a>

                        <ul aria-expanded="false" class="collapse">
                            <li>
                                <a href="{{ route('indexation.index') }}">Indexation</a>
                            </li>
                        </ul>
                    </li>
                </ul>
            </li>
            @endrole

            <li>
                <a class="has-arrow" href="#" aria-expanded="false">
                    <i class="fas fa-star-half-alt"></i>
                    <span class="hide-menu">
                        Ratings
                    </span>
                </a>

                <ul aria-expanded="false" class="collapse">
                    <li>
                        <a href="{{ route('ratings.index', 'audiobooks') }}">Audiobooks</a>
                    </li>

                    <li>
                        <a href="{{ route('ratings.index', 'books') }}">Books</a>
                    </li>
                </ul>
            </li>

            {{--<li class="nav-label">Misc</li>--}}

            {{--<li>--}}

                {{--<a class="has-arrow" href="#" aria-expanded="false">--}}
                    {{--<i class="fas fa-tags"></i>--}}
                    {{--<span class="hide-menu">--}}
                        {{--Tags--}}
                    {{--</span>--}}
                {{--</a>--}}

                {{--<ul aria-expanded="false" class="collapse">--}}
                    {{--<li>--}}
                        {{--<a class="has-arrow" href="#">Library Thing</a>--}}

                        {{--<ul aria-expanded="false" class="collapse">--}}
                            {{--<li>--}}
                                {{--<a href="{{ route('librarything.index') }}">Xml feeds</a>--}}
                            {{--</li>--}}
                        {{--</ul>--}}
                    {{--</li>--}}
                {{--</ul>--}}
            {{--</li>--}}


            {{--<li class="nav-label">Apps</li>--}}
            {{--<li> <a class="has-arrow  " href="#" aria-expanded="false"><i class="fa fa-envelope"></i><span class="hide-menu">Email</span></a>--}}
                {{--<ul aria-expanded="false" class="collapse">--}}
                    {{--<li><a href="email-compose.html">Compose</a></li>--}}
                    {{--<li><a href="email-read.html">Read</a></li>--}}
                    {{--<li><a href="email-inbox.html">Inbox</a></li>--}}
                {{--</ul>--}}
            {{--</li>--}}
            {{--<li> <a class="has-arrow  " href="#" aria-expanded="false"><i class="fa fa-bar-chart"></i><span class="hide-menu">Charts</span></a>--}}
                {{--<ul aria-expanded="false" class="collapse">--}}
                    {{--<li><a href="chart-flot.html">Flot</a></li>--}}
                    {{--<li><a href="chart-morris.html">Morris</a></li>--}}
                    {{--<li><a href="chart-chartjs.html">ChartJs</a></li>--}}
                    {{--<li><a href="chart-chartist.html">Chartist </a></li>--}}
                    {{--<li><a href="chart-amchart.html">AmChart</a></li>--}}
                    {{--<li><a href="chart-echart.html">EChart</a></li>--}}
                    {{--<li><a href="chart-sparkline.html">Sparkline</a></li>--}}
                    {{--<li><a href="chart-peity.html">Peity</a></li>--}}
                {{--</ul>--}}
            {{--</li>--}}
            {{--<li class="nav-label">Features</li>--}}
            {{--<li> <a class="has-arrow  " href="#" aria-expanded="false"><i class="fa fa-suitcase"></i><span class="hide-menu">Bootstrap UI <span class="label label-rouded label-warning pull-right">6</span></span></a>--}}
                {{--<ul aria-expanded="false" class="collapse">--}}
                    {{--<li><a href="ui-alert.html">Alert</a></li>--}}
                    {{--<li><a href="ui-button.html">Button</a></li>--}}
                    {{--<li><a href="ui-dropdown.html">Dropdown</a></li>--}}
                    {{--<li><a href="ui-progressbar.html">Progressbar</a></li>--}}
                    {{--<li><a href="ui-tab.html">Tab</a></li>--}}
                    {{--<li><a href="ui-typography.html">Typography</a></li>--}}
                {{--</ul>--}}
            {{--</li>--}}
            {{--<li> <a class="has-arrow  " href="#" aria-expanded="false"><i class="fa fa-suitcase"></i><span class="hide-menu">Components <span class="label label-rouded label-danger pull-right">6</span></span></a>--}}
                {{--<ul aria-expanded="false" class="collapse">--}}
                    {{--<li><a href="uc-calender.html">Calender</a></li>--}}
                    {{--<li><a href="uc-datamap.html">Datamap</a></li>--}}
                    {{--<li><a href="uc-nestedable.html">Nestedable</a></li>--}}
                    {{--<li><a href="uc-sweetalert.html">Sweetalert</a></li>--}}
                    {{--<li><a href="uc-toastr.html">Toastr</a></li>--}}
                    {{--<li><a href="uc-weather.html">Weather</a></li>--}}
                {{--</ul>--}}
            {{--</li>--}}
            {{--<li> <a class="has-arrow  " href="#" aria-expanded="false"><i class="fa fa-wpforms"></i><span class="hide-menu">Forms</span></a>--}}
                {{--<ul aria-expanded="false" class="collapse">--}}
                    {{--<li><a href="form-basic.html">Basic Forms</a></li>--}}
                    {{--<li><a href="form-layout.html">Form Layout</a></li>--}}
                    {{--<li><a href="form-validation.html">Form Validation</a></li>--}}
                    {{--<li><a href="form-editor.html">Editor</a></li>--}}
                    {{--<li><a href="form-dropzone.html">Dropzone</a></li>--}}
                {{--</ul>--}}
            {{--</li>--}}
            {{--<li> <a class="has-arrow  " href="#" aria-expanded="false"><i class="fa fa-table"></i><span class="hide-menu">Tables</span></a>--}}
                {{--<ul aria-expanded="false" class="collapse">--}}
                    {{--<li><a href="table-bootstrap.html">Basic Tables</a></li>--}}
                    {{--<li><a href="table-datatable.html">Data Tables</a></li>--}}
                {{--</ul>--}}
            {{--</li>--}}
            {{--<li class="nav-label">Layout</li>--}}
            {{--<li> <a class="has-arrow  " href="#" aria-expanded="false"><i class="fa fa-columns"></i><span class="hide-menu">Layout</span></a>--}}
                {{--<ul aria-expanded="false" class="collapse">--}}
                    {{--<li><a href="layout-blank.html">Blank</a></li>--}}
                    {{--<li><a href="layout-boxed.html">Boxed</a></li>--}}
                    {{--<li><a href="layout-fix-header.html">Fix Header</a></li>--}}
                    {{--<li><a href="layout-fix-sidebar.html">Fix Sidebar</a></li>--}}
                {{--</ul>--}}
            {{--</li>--}}
            {{--<li class="nav-label">EXTRA</li>--}}
            {{--<li> <a class="has-arrow  " href="#" aria-expanded="false"><i class="fa fa-book"></i><span class="hide-menu">Pages <span class="label label-rouded label-success pull-right">8</span></span></a>--}}
                {{--<ul aria-expanded="false" class="collapse">--}}

                    {{--<li><a href="#" class="has-arrow">Authentication <span class="label label-rounded label-success">6</span></a>--}}
                        {{--<ul aria-expanded="false" class="collapse">--}}
                            {{--<li><a href="page-login.html">Login</a></li>--}}
                            {{--<li><a href="page-register.html">Register</a></li>--}}
                            {{--<li><a href="page-invoice.html">Invoice</a></li>--}}
                        {{--</ul>--}}
                    {{--</li>--}}
                    {{--<li><a href="#" class="has-arrow">Error Pages</a>--}}
                        {{--<ul aria-expanded="false" class="collapse">--}}
                            {{--<li><a href="page-error-400.html">400</a></li>--}}
                            {{--<li><a href="page-error-403.html">403</a></li>--}}
                            {{--<li><a href="page-error-404.html">404</a></li>--}}
                            {{--<li><a href="page-error-500.html">500</a></li>--}}
                            {{--<li><a href="page-error-503.html">503</a></li>--}}
                        {{--</ul>--}}
                    {{--</li>--}}
                {{--</ul>--}}
            {{--</li>--}}
            {{--<li> <a class="has-arrow  " href="#" aria-expanded="false"><i class="fa fa-map-marker"></i><span class="hide-menu">Maps</span></a>--}}
                {{--<ul aria-expanded="false" class="collapse">--}}
                    {{--<li><a href="map-google.html">Google</a></li>--}}
                    {{--<li><a href="map-vector.html">Vector</a></li>--}}
                {{--</ul>--}}
            {{--</li>--}}
            {{--<li> <a class="has-arrow  " href="#" aria-expanded="false"><i class="fa fa-level-down"></i><span class="hide-menu">Multi level dd</span></a>--}}
                {{--<ul aria-expanded="false" class="collapse">--}}
                    {{--<li><a href="#">item 1.1</a></li>--}}
                    {{--<li><a href="#">item 1.2</a></li>--}}
                    {{--<li> <a class="has-arrow" href="#" aria-expanded="false">Menu 1.3</a>--}}
                        {{--<ul aria-expanded="false" class="collapse">--}}
                            {{--<li><a href="#">item 1.3.1</a></li>--}}
                            {{--<li><a href="#">item 1.3.2</a></li>--}}
                            {{--<li><a href="#">item 1.3.3</a></li>--}}
                            {{--<li><a href="#">item 1.3.4</a></li>--}}
                        {{--</ul>--}}
                    {{--</li>--}}
                    {{--<li><a href="#">item 1.4</a></li>--}}
                {{--</ul>--}}
            {{--</li>--}}
        </ul>
    </nav>
    <!-- End Sidebar navigation -->
</div>