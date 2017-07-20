<div class="row">
    <div class="col-sm-12">
        <div class="tabbable">
            <form class="form-horizontal" id="manager-update-form" role="form" action="{{url('admin/manager/update') }}"
                  method="POST">
                {{ csrf_field() }}
                <input type="hidden" name="id" value="{{ $id }}">
                <div class="widget-box">
                    <div class="widget-header">
                        <h4 class="widget-title">修改管理员</h4>
                        <div class="widget-toolbar">
                            <a href="javascript:void(0)" class="button button-primary button-rounded button-small"
                               id="manager-update">修改</a>
                        </div>
                    </div>
                    <div class="widget-body">
                        <div class="widget-main">
                            @include('admin.manager._form')
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
<script>

    jQuery(function () {
        var isAjax = false, checked = [];

        $("#manager-update").click(function() {
            if (isAjax) {
                return;
            }

            isAjax = true;

            var data = {};
            var t = $("#manager-update-form").serializeArray();

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

            data['roles'] = checked;

            $.post("{{ url('admin/manager/update') }}", data, function(result) {
                if (result.code == 0) {
                    dashboard.layerMsg('修改成功', 'success');
                } else {
                    dashboard.layerMsg(result.message, 'error');
                }
                isAjax = false;
            }, 'json');
        });
    })
</script>