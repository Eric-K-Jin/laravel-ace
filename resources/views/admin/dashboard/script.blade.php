<!-- basic scripts -->
<!--[if !IE]> -->
<script type="text/javascript">
    window.jQuery || document.write("<script src='{{ URL::asset('assets/js/jquery.min.js') }}'>" + "<" + "/script>");
</script>
<!-- <![endif]-->

<!--[if IE]>
<script type="text/javascript">
    window.jQuery || document.write("<script src='{{ URL::asset('assets/js/jquery1x.min.js') }}'>" + "<" + "/script>");
</script>
<![endif]-->
<script type="text/javascript">
    if ('ontouchstart' in document.documentElement) document.write("<script src='{{ URL::asset('assets/js/jquery.mobile.custom.min.js') }}'>" + "<" + "/script>");
</script>

<script src="{{ URL::asset('assets/js/bootstrap.min.js') }}"></script>

<!-- ace scripts -->
<script src="{{ asset('/js/admin/ace.min.js') }}"></script>
<script src="{{ URL::asset('assets/js/ace-elements.min.js') }}"></script>

<!-- layer -->
<script src="{{ asset('assets/layer/layer.js') }}"></script>
<script src="{{ asset('/js/admin/dashboard.js') }}"></script>
<!-- ace settings handler -->
<script src="{{ URL::asset('assets/js/ace-extra.min.js') }}"></script>

<!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->
<!--[if lte IE 8]>
<script src="{{ URL::asset('assets/js/html5shiv.js') }}"></script>
<script src="{{ URL::asset('assets/js/respond.min.js') }}"></script>
<![endif]-->

<script type="text/javascript">
    jQuery(function ($) {
        try {
            ace.settings.check('navbar', 'fixed');
            ace.settings.check('main-container', 'fixed');
            ace.settings.check('breadcrumbs', 'fixed');
        } catch (e) {
        }
        dashboard.init();
    });
</script>