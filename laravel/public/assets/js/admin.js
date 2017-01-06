"use strict";
$(function () {
   $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
    $(document).ajaxError(function (event, jqXHR, settings, thrownError) {
        if (jqXHR.responseJSON.message) {
            layer.msg(jqXHR.responseJSON.message);
            return;
        }
        switch (jqXHR.status) {
            case 403:
                layer.msg('未授权该操作！');
                break;
            case 404:
                layer.msg('链接错误！');
                break;
            case 500:
                layer.msg('服务器错误！');
                break;
        }
    });
    Helper.init();
});
var Helper = {
    init: function () {

    },
    ajax: function () {
        var ret = [];
        $.each(["post", "put", "delete"], function (i, method) {
            ret[method] = function (url, data, callback, type) {
                // Shift arguments if data argument was omitted
                if (jQuery.isFunction(data)) {
                    type = type || callback;
                    callback = data;
                    data = undefined;
                }
                // The url can be an options object (which then must have .url)
                return jQuery.ajax(jQuery.extend({
                    url: url,
                    type: method,
                    dataType: type,
                    data: data,
                    async: true,
                    success: callback
                }, jQuery.isPlainObject(url) && url));
            };
        });
        return ret;
    },
    __qiniu_data: null,
    getQiniuData: function () {

        var defer = $.Deferred();
        if (this.__qiniu_data) {
            defer.resolve(this.__qiniu_data);
        } else {
            var o = this;
            $.getJSON($('base').attr('href') + '/admin/helper/qiniu-token')
                .done(function (response) {
                    o.__qiniu_data = response.data;
                    defer.resolve(o.__qiniu_data);
                });
        }
        return defer;
    },
    plupload: function (callback) {
        $.when(this.getQiniuData()).done(function (qiniu) {
            $.fn.plupload = function (options) {
                var settings = {
                    runtimes: 'html5,html4',
                    url: 'http://up.qiniu.com/',
                    file_data_name: 'file',
                    multi_selection: false, //是否多选
                    multipart_params: {
                        token: qiniu.token
                    },
                    unique_names: true,
                    filters: {
                        max_file_size: '10mb',
                        mime_types: [
                            {title: "Image files", extensions: "jpeg,jpg,gif,png"}
                        ]
                    },
                    resize: {
                        width: 1000,
                        crop: false,
                        quality: 75,
                        preserve_headers: false
                    }
                };
                $.extend(settings, options);
                var uploaders = new plupload.Uploader(settings);

                this.each(function (k, v) {
                    if($(this).next('.moxie-shim').length == 1){
                        return false;
                    }
                    var resize = uploaders.getOption('resize');
                    if (!this.id) {
                        $(this).attr('id', 'plupload-' + new Date().getTime())
                    }
                    if($(this).data('w')){
                        resize.width = $(this).data('w');
                        uploaders.setOption('resize', resize);
                    }
                    if($(this).data('crop') == true){
                        resize.crop = true;
                        uploaders.setOption('resize', resize);
                    }
                    if($(this).data('h')){
                        resize.height = $(this).data('h');
                        uploaders.setOption('resize', resize);
                    }
                    uploaders.setOption('browse_button', this.id);
                    uploaders.init();
                    uploaders.refresh();
                });

                //上传成功事件
                if (settings.success) {
                    uploaders.bind('FileUploaded', function (uploader, file, result) {
                        var r = result.response;
                        var args = [r, uploader, file, result];
                        try {
                            var data = $.parseJSON(r);
                            if (data != null) {
                                data.url = qiniu.domain + data.key;
                                args[0] = data;
                            }
                        }
                        catch (e) {
                        }
                        settings.success.apply(uploader, args);
                    });
                }

                if (settings.error) {
                    uploaders.bind('Error', function (uploader, error) {
                        settings.error(error.message);
                    });
                } else {
                    uploaders.bind('Error', function (uploader, error) {
                        console.log("上传失败,错误消息：" + error.message);
                    });
                }

                //添加文件后
                uploaders.bind('FilesAdded', function (uploader, files) {
                    uploader.start();
                    if (settings.startUpload) {
                        var args = [uploader, files];
                        settings.startUpload.apply(uploader, args);
                    }
                });

                //当队列中的某一个文件正要开始上传前触发
                uploaders.bind('BeforeUpload', function (uploader, file) {
                    //修改当前上传的文件名
                    var multipart_params = uploader.getOption('multipart_params');
                    multipart_params.key = file.target_name;
                    uploader.setOption('multipart_params', multipart_params);
                });

                return uploaders;
            };
            if(callback){
                callback();
            }
        });
    },
};

