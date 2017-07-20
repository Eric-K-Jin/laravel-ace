<title>{{ config('app.name', '礼德财富存管系统') }}</title>

<div class="page-header">
    <h1>
        权限列表
        @if($cid>0)
            <span style="font-size: 14px;" id="cid" attr="{{$cid}}" class="text-info">  >> {{$data->label}}</span>
        @endif

    </h1>
</div>

<div class="row">
    <div class="col-xs-12">

        <div class="table-responsive" style="float: right;padding-right: 50px;margin-top:10px;">
            <div class="col-md-6">
                @if($cid>0)
                    <a data-url="permission/index" href="#admin/permission/index"
                       class="btn btn-warning btn-md animation-shake"><i class="fa fa-mail-reply-all"></i> 返回顶级菜单
                    </a>
                @endif
            </div>
            <div class="col-md-6 text-right">
                @if(checkPermission('admin.permission.create'))
                    <a data-url="permission/create/{{$cid}}" href="#/admin/permission/create/{{$cid}}" class="btn btn-success btn-md">
                        <i class="fa fa-plus-circle"></i> 添加权限
                    </a>
                @endif
            </div>
        </div>

        <div>
            <table id="permission-list" class="table table-striped table-bordered table-hover">
                <thead>
                <tr>
                    <th>权限规则</th>
                    <th class="hidden-480">权限名称</th>
                    <th class="hidden-480">权限描述</th>
                    <th>创建日期</th>
                    <th>修改日期</th>
                    <th>操作</th>
                </tr>
                </thead>
            </table>
        </div>
    </div>
</div>
<!-- PAGE CONTENT ENDS -->
</div><!-- /.col -->
</div><!-- /.row -->

<!-- page specific plugin scripts -->
<script src="{{ asset('assets/js/jquery.dataTables.min.js') }}"></script>
<script src="{{ asset('assets/js/jquery.dataTables.bootstrap.js') }}"></script>
<script type="text/javascript">

    jQuery(function ($) {
        var columns = [
            {"data": "name"},
            {"data": "label"},
            {"data": "description"},
            {"data": "created_at"},
            {"data": "updated_at"},
            {"data": "operate"}
        ];
        var cid = $('#cid').attr('attr');
        dashboard.showDataTable('permission-list', "{{ url('admin/permission/list') }}/"+cid, columns);

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

        $("#permission-list").on('click', '.delete', function () {
            if (confirm('确定删除吗?此操作不可撤销')) {
                var id = $(this).attr('rel');
                dashboard.ajaxDelete("{{ url('admin/permission/destroy') }}/" + id, 'permission-list', '删除成功', {"_token": "{{ csrf_token() }}"});
            }
        });

    });

</script>