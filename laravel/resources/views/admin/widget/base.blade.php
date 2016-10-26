<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>find - 后台管理系统</title>
    <meta name="renderer" content="webkit">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <base href="{{ url('/') }}">
    <link type="text/css" rel="stylesheet" href="assets/css/bootstrap.min.css">
    <link type="text/css" rel="stylesheet" href="assets/css/materialadmin1.min.css">
    <link type="text/css" rel="stylesheet" href="assets/css/font-awesome.min.css">
    <link type="text/css" rel="stylesheet" href="assets/css/material-design-iconic-font.min.css">
    @yield('style_link')
    <link type="text/css" rel="stylesheet" href="assets/css/admin.min.css">
    @yield('style')
        <!--[if lt IE 9]>
    <script type="text/javascript" src="/assets/js/html5shiv.min.js"></script>
    <script type="text/javascript" src="/assets/js/respond.min.js"></script>
    <![endif]-->
</head>
<body class="menubar-hoverable header-fixed menubar-pin">
@yield('body')
<script src="assets/js/ganguo-admin.min.js"></script>
<script src="assets/js/layer.js"></script>
<script src="assets/js/admin.js"></script>
@yield('script_link')
@yield('script')
@if ($errors->count() > 0)
    <script type="text/javascript">
        $.each({!! json_encode($errors->all()) !!}, function(k,v){
            layer.msg(v, {
                icon: 2
            });
        });
    </script>
@endif
@if (old('success_msg'))
    <script type="text/javascript">
        layer.msg('{{ old('success_msg') }}', {
            icon: 1
        });
    </script>
@endif
</body>
</html>
