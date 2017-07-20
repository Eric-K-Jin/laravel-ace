<!DOCTYPE html>
<html lang="en">
<head>
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1"/>
    <meta charset="utf-8"/>
    <title>欢迎 - {{ config('app.name', 'Laravel-ace Admin') }}</title>

    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0"/>

    <!-- bootstrap & fontawesome -->
    <link rel="stylesheet" href="{{ URL::asset('assets/css/bootstrap.min.css') }}"/>
    <link rel="stylesheet" href="{{ URL::asset('assets/css/font-awesome.min.css') }}"/>

    <!-- text fonts -->
    <link rel="stylesheet" href="{{ URL::asset('assets/css/ace-fonts.css') }}"/>

    <!-- ace styles -->
    <link rel="stylesheet" href="{{ URL::asset('assets/css/ace.min.css') }}" id="main-ace-style"/>

    <!--[if lte IE 9]>
    <link rel="stylesheet" href="{{ URL::asset('assets/css/ace-part2.min.css') }}"/>
    <![endif]-->
    <link rel="stylesheet" href="{{ URL::asset('assets/css/ace-skins.min.css') }}"/>
    <link rel="stylesheet" href="{{ URL::asset('assets/css/ace-rtl.min.css') }}"/>

    <!--[if lte IE 9]>
    <link rel="stylesheet" href="{{ URL::asset('assets/css/ace-ie.min.css') }}"/>
    <![endif]-->

    <!-- select2 -->
    <link href="{{ asset('assets/css/chosen.css') }}" rel="stylesheet"/>

    <!-- layer -->
    <link href="{{ asset('assets/layer/skin/default/layer.css') }}"/>
</head>

<body class="no-skin">
<!-- #section:basics/navbar.layout -->

@include('admin.dashboard.header')

<!-- /section:basics/navbar.layout -->
<div class="main-container" id="main-container">


    <!-- #section:basics/sidebar -->
    @include('admin.dashboard.slider')

    <div class="main-content">
        <!-- #section:basics/content.breadcrumbs -->
        <div class="breadcrumbs" id="breadcrumbs">

            <ul class="breadcrumb">
                <li>
                    <i class="ace-icon fa fa-home home-icon"></i>
                    {{--<a href="#">Home</a>--}}
                </li>
            </ul><!-- /.breadcrumb -->

            <!-- #section:basics/content.searchbox -->
            <div class="nav-search" id="nav-search">

            </div><!-- /.nav-search -->

            <!-- /section:basics/content.searchbox -->
        </div>

        <!-- /section:basics/content.breadcrumbs -->
        <div class="page-content">
            <!-- /section:settings.box -->
            <div class="page-content-area">
                <!-- ajax content goes here -->
            </div><!-- /.page-content-area -->
        </div><!-- /.page-content -->
    </div><!-- /.main-content -->

    @include('admin.dashboard.footer')

</div><!-- /.main-container -->


<!-- 引入遮罩层 -->
@include('admin.dashboard.script')
@include('admin.dashboard.updatePassword')
</body>
</html>