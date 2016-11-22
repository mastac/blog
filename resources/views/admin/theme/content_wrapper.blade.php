<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            {{ !empty($page_title) ? $page_title : "" }}
            {!! !empty($page_subtitle) ? '<small>' . $page_subtitle . '</small>' : "" !!}
        </h1>
    </section>

    <!-- Main content -->
    <section class="content">
    @yield('content')
    </section>
    <!-- /.content -->
</div>
<!-- /.content-wrapper -->
