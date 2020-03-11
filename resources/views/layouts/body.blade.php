<body class="sidebar-mini layout-fixed">
<div class="wrapper">
@include('layouts.header')

@include('layouts.left-sidebar')
<!-- @ include('layouts.right-sidebar') -->

<!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Main content -->
        <section class="content">
            <div class="container-fluid">
                @yield('page-content')
            </div><!-- /.container-fluid -->
        </section>
        <!-- /.content -->
    </div>
    <!-- /.content-wrapper -->
@include('layouts.footer')
</div>

</body>

