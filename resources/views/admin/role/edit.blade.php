<!-- 新增产品内容 -->
<div class="row">
    <div class="col-sm-12">
        <div class="tabbable">
            <form class="form-horizontal" id="role-update-form" role="form"
                  method="POST">
                {{ csrf_field() }}
                <input type="hidden" name="id" value="{{ $id }}">
                <div class="widget-box">
                    <div class="widget-header">
                        <h4 class="widget-title">修改用户组</h4>
                        <div class="widget-toolbar">
                            <a href="javascript:void(0)" class="button button-primary button-rounded button-small"
                               id="role-update">修改</a>
                        </div>
                    </div>
                    <div class="widget-body">
                        <div class="widget-main">
                            @include('admin.role._form')
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
<!-- end 新增产品内容 -->
<script>
    {{--jQuery(function () {--}}
        {{--dashboard.ajaxForm("role-update", "role-update-form", "{{ url('admin/role/update') }}", "{{ url('#admin/role/index') }}", '修改成功');--}}
    {{--})--}}

    jQuery(function () {
        var isAjax = false, checked = [];

        $("#role-update").click(function() {
            if (isAjax) {
                return;
            }

            isAjax = true;

            var data = {};
            var t = $("#role-update-form").serializeArray();

            $.each (t, function() {
                if (this.name.indexOf("[]") > 0) {
                    return;
                }
                data[this.name] = this.value;
            });

            data['_token'] = $("input[name=_token]").val();

            $('input[type=checkbox]:checked').each(function() {
                checked.push($(this).val());
            });

            data['permissions'] = checked;

            $.post("{{ url('admin/role/update') }}", data, function(result) {
                if (result.code == 0) {
                    dashboard.layerMsg('修改成功', 'success');
//                    window.location.href = '#admin/role/index';
                } else {
                    dashboard.layerMsg(result.message, 'error');
                }
                isAjax = false;
            }, 'json');
        });
    })
</script>