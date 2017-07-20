<title>{{ config('app.name', '礼德财富存管系统') }}</title>

<div class="page-header">
    <h1>
        管理员列表
    </h1>
</div><!-- /.page-header -->
<div class="row">
    <div class="col-xs-12">

        <div class="table-responsive" style="float: right;padding-right: 50px;margin-top:10px;">
            <div class="col-md-6">
            </div>
            <div class="col-md-6 text-right">
                @if(checkPermission('admin.user.create'))
                    <a data-url="admin/manager/create" href="#/admin/manager/create" class="btn btn-success btn-md">
                        <i class="fa fa-plus-circle"></i> 添加用户
                    </a>
                @endif
            </div>
        </div>

        <!-- <div class="dataTables_borderWrap"> -->
        <div>
            <table id="manager-list" class="table table-striped table-bordered table-hover">
                <thead>
                <tr>
                    <th data-sortable="false" class="hidden-sm"></th>
                    <th class="hidden-sm">管理员名称</th>
                    <th class="hidden-sm">管理员姓名</th>
                    <th class="hidden-sm">管理员状态</th>
                    <th class="hidden-md">创建日期</th>
                    <th class="hidden-md">修改日期</th>
                    <th data-sortable="false">操作</th>
                </tr>
                </thead>
            </table>
        </div>
    </div>
</div>
<!-- PAGE CONTENT ENDS -->
</div><!-- /.col -->
</div><!-- /.row -->

<script src="{{ asset('assets/js/jquery.dataTables.min.js') }}"></script>
<script src="{{ asset('assets/js/jquery.dataTables.bootstrap.js') }}"></script>
<script type="text/javascript">

    jQuery(function ($) {
        var columns = [
            {"data": "id"},
            {"data": "username"},
            {"data": "realname"},
            {"data": "status"},
            {"data": "created_at"},
            {"data": "updated_at"},
            {"data": "operate"}
        ];

        dashboard.showDataTable('manager-list', "{{ url('admin/manager/list') }}", columns);

        $('[data-rel="tooltip"]').tooltip({placement: tooltip_placement});
        function tooltip_placement(context, source) {
            var $source = $(source);
            var $parent = $source.closest('table');
            var off1 = $parent.offset();
            var w1 = $parent.width();

            var off2 = $source.offset();
            //var w2 = $source.width();

            if (parseInt(off2.left) < parseInt(off1.left) + parseInt(w1 / 2)) return 'right';
            return 'left';
        }

        $("#manager-list").on('click', '.delete', function () {
            if (confirm('确定删除吗?此操作不可撤销')) {
                var id = $(this).attr('rel');
                dashboard.ajaxDelete("{{ url('admin/manager/destroy') }}/" + id, 'manager-list', '删除成功', {"_token": "{{ csrf_token() }}"});
            }
        });
    });
</script>