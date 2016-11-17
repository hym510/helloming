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
        autosize($('textarea'));
        this.initFun.confirmOperation();
        this.initFun.summernote();
        this.initFun.checkboxSelect();
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
    initFun: {
        checkboxSelect:function(){
            $('.checkbox-select-all').click(function(){
                $('.checkbox-select-item').prop('checked', $(this).is(':checked'))
            });
        },
        setLeftSidebarActiveItem: function () {
            var sidebarItem = $('#main-menu li[class!="gui-folder"]');
            if (!window.sessionStorage) {
                return false;
            }
            if (sidebarItem.length == 0) {
                sessionStorage.sidebarItem = 0;
                return false;
            }
            sidebarItem.each(function (k, v) {
                $(this).click(function (e) {
                    sessionStorage.sidebarItem = k;
                });
            });
            var cur;
            if (sessionStorage.sidebarItem != undefined) {
                cur = sidebarItem.eq(sessionStorage.sidebarItem);
            } else {
                cur = sidebarItem.eq(1);
            }
            cur.find('a').addClass('active');
        },
        setDefaultsValue: function () {
            Array.prototype.S = String.fromCharCode(2);
            Array.prototype.in_array = function (e) {
                var r = new RegExp(this.S + e + this.S);
                return (r.test(this.S + this.join(this.S) + this.S));
            };

            $('select').each(function () {
                var value = $(this).data('val');
                if (value) {
                    $(this).val(value)
                }
            });
            $('[data-radio]').each(function () {
                $(this).find('input[value="'+$(this).data('radio')+'"]').prop('checked', true);
            });
            $('[data-checkbox]').each(function () {
                var container = $(this);
                var separator = '|';
                if (container.data('separator')) {
                    separator = container.data('separator');
                }
                var values = container.data('checkbox');
                values = String(values).split(separator);

                $(this).find('input[type="checkbox"]').each(function () {
                    if (values.in_array($(this).val())) {
                        $(this).prop('checked', true);
                    }
                });
            });
            $('label').click(function(e){
                if ($(this).find('input[type="radio"],input[type="checkbox"]').attr('readonly') !== undefined) {
                    e.preventDefault();
                }
            });
            //number 支持 maxlength
            $('input[type="number"][maxlength]').keydown(function(e){
                var val = $(this).val();
                var maxlength = $(this).attr('maxlength');
                if(val.length == maxlength && (e.keyCode >= 48 && e.keyCode <= 57)){
                    return false;
                }
            });
        },
        confirmOperation: function () {
            //确认操作
            $('[data-method]').click(function () {
                var $this = $(this);
                var request_data = {};
                if ($this.data('form')) {
                    var d = $this.data('form').split(",");
                    for (var i = 0; i < d.length; i++) {
                        d[i] = d[i].split(":");
                        if (d[i].length != 2) {
                            continue;
                        }
                        request_data[d[i][0]] = d[i][1];
                    }
                }
                var msg = '确认操作?';
                if ($this.data('msg')) {
                    msg = $this.data('msg');
                }
                layer.msg(msg, {
                    time: 0, //不自动关闭
                    btn: ['确认', '取消'], //按钮
                    yes: function (index) {
                        layer.close(index);
                        var ajax = Helper.ajax();
                        var ajax_succeed;
                        switch ($this.data('method')) {
                            case 'del':
                                ajax_succeed = ajax.delete($this.data('url'), request_data);
                                break;
                            case 'put':
                                ajax_succeed = ajax.put($this.data('url'), request_data);
                                break;
                            case 'post':
                                ajax_succeed = ajax.post($this.data('url'), request_data);
                                break;
                        }
                        if (ajax_succeed) {
                            ajax_succeed.done(function (data) {
                                if (data.next_url) {
                                    window.location.href = data.next_url;
                                } else {
                                    location.reload();
                                }
                            });
                        }
                    }
                });
            });
        },
        summernote: function () {
            if (!$.isFunction($.fn.summernote)) {
                return;
            }
            var $ummernote = $('.summernote');
            var sendFile = function sendFile(file) {
                var filename = false;
                try {
                    filename = file['name'];
                } catch (e) {
                    return false;
                }
                //以上防止在图片在编辑器内拖拽引发第二次上传导致的提示错误
                var ext = filename.substr(filename.lastIndexOf(".")).toLowerCase();
                var timestamp = new Date().getTime();
                var name = timestamp + ext;
                //name是文件名，自己随意定义
                $.when(Helper.getQiniuData()).done(function (qiniu) {
                    var data = new FormData();
                    data.append("file", file);
                    data.append("key", name);
                    data.append("token", qiniu.token);
                    $.ajax({
                        data: data,
                        type: "POST",
                        url: "http://upload.qiniu.com",
                        cache: false,
                        contentType: false,
                        processData: false,
                        success: function (data) {
                            $ummernote.summernote('insertImage', qiniu.domain + data['key'], data['key']);
                        }
                    });
                });
            };
            $ummernote.summernote({
                lang: 'zh-CN',
                height: 'auto',
                minHeight: 300,
                toolbar: [
                    ['style', ['style']],
                    ['font', ['bold', 'underline', 'clear']],
                    ['fontname', ['fontname']],
                    ['color', ['color']],
                    ['para', ['ul', 'ol', 'paragraph']],
                    ['table', ['table']],
                    ['insert', ['link', 'picture']],
                    ['view', ['fullscreen', 'codeview', 'help']]
                ],
                callbacks: {
                    onImageUpload: function (files) {
                        for (var i = 0; i < files.length; i++) {
                            sendFile(files[i]);
                        }
                    }
                }
            });
        }
    },
    mapAmap:function(selector){
        selector.address = $(selector.address);
        selector.longitude = $(selector.longitude);
        selector.latitude = $(selector.latitude);
        if (selector.search_keyword == undefined) {
            selector.search_keyword = '';
        }
        $('body').append(' <div id="dialog-amap" style="position: relative;display: none;"> <div id="container" style="height: 100%"></div> <div class="amap-search col-sm-3" style="position: absolute;right: 0;top: 20%;background: #fff;padding: 10px;"> <div class="input-group"> <input type="text" class="form-control" placeholder="关键字搜索地址" id="search"> <span class="input-group-btn"> <button class="btn btn-default" type="button" disabled>保存地址</button> </span> </div> <div class="text-default-light"></div> </div> </div>');
        $.getScript('http://webapi.amap.com/maps?v=1.3&key=916bd3ad2686c9f8d94409a6aa3ae407&plugin=', function () {

            var dialog = $('#dialog-amap');
            dialog.css('height', $(window).height() - 35);

            var lnglatXY;
            var address;

            var map = new AMap.Map("container", {
                resizeEnable: true,
                zoom: 11
            });
            var geocoder;
            map.plugin(["AMap.Geocoder"], function () { //加载地理编码
                geocoder = new AMap.Geocoder({
                    radius: 1000,
                    extensions: "all"
                });
            });
            map.plugin(['AMap.Autocomplete'], function () { //加载输入提示，根据输入关键字提示匹配信息
                var auto_complete = new AMap.Autocomplete({
                    input: 'search'
                });
                AMap.event.addListener(auto_complete, "select", function (e) { //注册监听，当选中某条记录时会触发
                    if (e.poi && e.poi.location) {
                        map.setZoom(15);
                        map.setCenter(e.poi.location);
                        setMarker(e.poi.location);
                    }
                });

            });
            map.plugin(["AMap.ToolBar"], function () {
                map.addControl(new AMap.ToolBar());
            });
            map.on('click', function (e) {
                if (dialog.find('#search').val() == '') {
                    return false;
                }
                setMarker(e.lnglat);
            });

            var marker = false;
            var setMarker = function (location) {
                lnglatXY = location;
                if (marker) {
                    marker.setPosition(location);
                } else {
                    marker = new AMap.Marker({
                        position: location,
                        draggable: true,
                        cursor: 'move',
                        raiseOnDrag: true
                    });
                    marker.setMap(map);
                }
                if (dialog.find('button').attr('disabled')) {
                    dialog.find('button').removeAttr('disabled');
                }
                AMap.event.addListener(marker, 'dragend', function (e) {
                    lnglatXY = e.lnglat;
                    displayAddress(lnglatXY);
                });
                displayAddress(location);
            };

            var displayAddress = function (lnglatXY) {
                geocoder.getAddress(lnglatXY, function (status, result) {
                    if (status === 'complete' && result.info === 'OK') {
                        address = result.regeocode.formattedAddress;
                        dialog.find('.text-default-light').html(
                            '坐标:' + lnglatXY.getLng() + ' , ' + lnglatXY.getLat() + '<br/>'
                            + '地址:' + address + '<br/>'
                            + '确认无误请点击保存地址'
                        );
                    }
                });
            };

            dialog.find('button').click(function (e) {
                selector.address.val(address);
                selector.longitude.val(lnglatXY.getLng());
                selector.latitude.val(lnglatXY.getLat());
                layer.closeAll();
            });

            selector.address.click(function () {
                var index = layer.open({
                    type: 1,
                    title: '选择地址',
                    content: dialog,
                    maxmin: false,
                    zIndex:11,
                    success: function (layero, index) {
                        dialog.find('input').val(selector.search_keyword);
                    }
                });
                layer.full(index);
            });
        });
    }
};
Helper.initFun.setLeftSidebarActiveItem();
Helper.initFun.setDefaultsValue();
