<!-- 新增产品内容 -->
<div class="row">
    <div class="col-sm-12">
        <div class="tabbable">
            <form class="form-horizontal" id="permission-create-form" role="form" action="{{url('admin/permission/store') }}" method="POST">
                {{ csrf_field() }}
                <div class="widget-box">
                    <div class="widget-header">
                        <h4 class="widget-title">新增权限</h4>
                        <div class="widget-toolbar">
                            <a href="javascript:void(0)" class="button button-primary button-rounded button-small"
                               id="permission-create">保存</a>
                        </div>
                    </div>
                    <div class="widget-body">
                        <div class="widget-main">
                            @include('admin.permission._form')
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
<!-- end 新增产品内容 -->
<script>
    jQuery(function () {
        dashboard.ajaxForm("permission-create", "permission-create-form", "{{ url('admin/permission/store') }}", "{{ url('#admin/permission/index') }}", '新增成功');
    })
</script>