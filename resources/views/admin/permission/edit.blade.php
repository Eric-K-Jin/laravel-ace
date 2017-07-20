<!-- 新增产品内容 -->
<div class="row">
    <div class="col-sm-12">
        <div class="tabbable">
            <form class="form-horizontal" id="permission-update-form" role="form"
                  action="{{url('admin/permission/update') }}"
                  method="POST">
                {{ csrf_field() }}
                <input type="hidden" name="id" value="{{ $id }}">
                <div class="widget-box">
                    <div class="widget-header">
                        <h4 class="widget-title">修改权限</h4>
                        <div class="widget-toolbar">
                            <a href="javascript:void(0)" class="button button-primary button-rounded button-small"
                               id="permission-update">修改</a>
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
        dashboard.ajaxForm("permission-update", "permission-update-form", "{{ url('admin/permission/update') }}", "{{ url('#admin/permission/index') }}", '修改成功');
    })
</script>