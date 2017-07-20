/**
 * Created by jinruijie on 2017/3/16.
 */
var dashboard = function() {

    var ajaxForm = function(id, form, url) {
        var isAjax= false, redirect = arguments[3] || "", message = arguments[4] || "保存成功", options = arguments[5] || {};
        $("#"+id).click(function() {
            if (isAjax) {
                return;
            }

            isAjax = true;

            var data = {};
            var t = $("#" + form).serializeArray();

            $.each (t, function() {
                if (this.name.indexOf("[]") > 0) {
                    return;
                }
                data[this.name] = this.value;
            });

            data['_token'] = $("input[name=_token]").val();

            if(options.length) {
                $.merge(data, options);
            }

            $.post(url, data, function(result) {
                if (result.code == 0) {
                    dashboard.layerMsg(message, 'success');
                    if (redirect != "") {
                        window.location.href = redirect;
                    }
                } else {
                    dashboard.layerMsg(result.message, 'error');
                }
                isAjax = false;
            }, 'json');
        });
    };

    var ajaxDelete = function(url, tableId, message) {
        var data = arguments[3] || {};
        $.post(url, data, function(result) {
            if (result.code == 0) {
                layerMsg(message, 'success');
                $("#"+tableId).DataTable().ajax.reload(null, false);
            } else {
                layerMsg(result.message, 'error');
            }
        }, 'json');
    };

    var logout = function() {
        $('#logout').click(function() {
            $.post("/admin/logout", {"_token": $(this).attr('rel')}, function(data) {
                if (data.code == 0) {
                    window.location.href = "/admin/login";
                } else {
                    alert('登出失败');
                }
            }, 'json');
        });
    };

    //Load content via ajax
    var loadAjax = function() {
        if('enable_ajax_content' in ace) {
            var options = {
                content_url: function(url) {
                    return url;
                },
                default_url: 'admin/index'//default url
            };
            ace.enable_ajax_content($, options)
        }
    };

    var layerMsg = function (content, type) {
        var callback = arguments[2] || function () {},
            index = layer.msg(content, {offset: 't', time: 2000, area: ['100%'], shadeClose: true}, callback()),
            styleObj = {};

        switch (type) {
            case 'error':
                styleObj = {background: '#f2dede', border: '#ebccd1', color: '#a94442'};
                break;
            case 'warn':
                styleObj = {background: '#fcf8e3', border: '#faebcc', color: '#8a6d3b'};
                break;
            case 'success' :
                styleObj = {background: '#dff0d8', border: '#d6e9c6', color: '#3c763d'};
                break;
            default:
                styleObj = {background: '#d9edf7', border: '#d9edf7', color: '#d9edf7'};
                break;
        }

        layer.style(index, styleObj);
    };

    /**
     * show dataTable类型的表格
     * @param tableId  表格id
     * @param url  回调的url
     * @param columns  显示的字段名称,格式[{"data": "id"}, {"data": "name"}, .....]
     */
    var showDataTable = function(tableId, url, columns) {
        var options = arguments[3] || [], keyword = arguments[4] || "", content = arguments[5] || "",  //额外参数
            obj = {
                pagingType: "full_numbers",
                serverSide: true,
                searching: false,
                renderer: "bootstrap",
                language: {
                    "sProcessing": "处理中...",
                    "sLengthMenu": "每页 _MENU_ 项",
                    "sZeroRecords": "没有匹配结果",
                    "sInfo": "当前显示第 _START_ 至 _END_ 项，共 _TOTAL_ 项。",
                    "sInfoEmpty": "当前显示第 0 至 0 项，共 0 项",
                    "sInfoFiltered": "(由 _MAX_ 项结果过滤)",
                    "sInfoPostFix": "",
                    "sSearch": "搜索:",
                    "sUrl": "",
                    "sEmptyTable": "暂无数据",
                    "sLoadingRecords": "载入中...",
                    "sInfoThousands": ",",
                    "oPaginate": {
                        "sFirst": "首页",
                        "sPrevious": "上页",
                        "sNext": "下页",
                        "sLast": "末页",
                        "sJump": "跳转"
                    },
                    "oAria": {
                        "sSortAscending": ": 以升序排列此列",
                        "sSortDescending": ": 以降序排列此列"
                    }
                },  //提示信息
                ajax: function(data, callback, settings) {
                    var param = {
                        limit: data.length, //页面显示记录条数
                        start: data.start, //在页面显示每页显示多少项的时候
                        keyword: keyword,
                        content: content
                    };
                    var page = (data.start / data.length);
                    if (isNaN(page)) {
                        page = 0;
                    }
                    param.page = page + 1; //当前页码
                    $.ajax({
                        url: url,
                        data: param,
                        dataType: "json",
                        success: function(data) {
                            setTimeout(function() {
                                var result = {};
                                result.draw = data.draw;
                                result.recordsTotal = data.total;
                                result.recordsFiltered = data.total;
                                result.data = data.data;
                                callback(result);
                            }, 200)
                        }
                    });
                },
                columns: columns
            };

        $.each (options, function(key, val) {
           obj[key] = val;
        });

        $('#' + tableId).dataTable(obj).api();
    };

    var dateRangePicker = function(selector) {
        $(selector).daterangepicker({
            'applyClass': 'btn-sm btn-success',
            'cancelClass': 'btn-sm btn-default',
            locale: {
                applyLabel: '确认',
                cancelLabel: '取消',
                fromLabel: '起始时间',
                toLabel: '结束时间',
                customRangeLabel: '自定义',
                firstDay: 1
            }
        }).prev().on(ace.click_event, function() {
            $(this).next().focus();
        });
    };

    var datePicker = function(selector) {
        $(selector).datepicker({
            autoclose: true,
            todayHighlight: true
        });
    };

    return {
        init: function() {
            loadAjax();
            logout();
        },

        ajaxForm: ajaxForm,
        ajaxDelete: ajaxDelete,
        layerMsg: layerMsg,
        showDataTable: showDataTable,
        dateRangePicker: dateRangePicker,
        datePicker: datePicker
    };
}();