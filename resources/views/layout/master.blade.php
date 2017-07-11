<!DOCTYPE html>
<html>
<head lang="en">
    <meta charset="UTF-8">
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <meta name="screen-orientation" content="portrait"><!-- uc强制竖屏 -->
    <meta name="x5-orientation" content="portrait"><!-- QQ强制竖屏 -->
    <title></title>
    <script src="/js/components/jquery.min.js"></script>

    <link href="/css/components/semantic.min.css" rel="stylesheet">
    <script src="/js/components/semantic.min.js"></script>
    <link href="/js/wangeditor/css/wangEditor.min.css" rel="stylesheet">
    <script src="/js/components/jquery.form.js"></script>
    <script src="/js/components/index.js"></script>
    <link href="/css/index.css" rel="stylesheet">
    <style>
        body {
            background: #F4F4F4;
            border: 0 none;
            color: #5B6770;
            font-family: "Microsoft YaHei",微软雅黑,"MicrosoftJhengHei",华文细黑,STHeiti,MingLiu ;
            font-size: 12px;
            line-height: 1.5;
            margin: 0;
            overflow-y: scroll;
            padding: 0;
            position: relative;
            vertical-align: baseline;
        }
        .width-960{
            max-width: 960px;
        }
        .head-description {
            background: #fff;
            background: linear-gradient(to bottom,#fff 0,#f9f9f9 100%);
            border-top-left-radius: 0px;
            border-top-right-radius: 0px;
            border: 1px solid #cfd4db;
            padding: 20px;
            position: relative;
            z-index: 1;

        }
        .new-product-container {
            background: #fff;
            border: 1px solid #cfd4db;
            border-top: none;
            padding: 10px 40px 0;
            position: relative;
        }
        .body{
            min-height: 100%;
        }
        .body-content {
            padding: 0;
        }
        #container {
            position: relative;
            min-height: 100%;
        }
        .user-area-wrap {
            margin: 0 auto;
            padding: 0px 0 30px;
        }
        .user-area-wrap .ui.grid .column.left-navigation {
            width: 15%;
            min-height:700px;
        }
        .user-area-wrap .ui.grid .column {
            padding-top: 0;
        }
        .user-area-wrap .ui.grid .column.main-content {
            width: 100%;
            padding-left: 0;
            padding-top: 20px;
        }

        .user-area-wrap .ui.grid .column {
            padding-top: 0;
        }
        .ui.grid .column.left-navigation .menu .item>.menu>.item {
            border-left: 3px solid transparent;
        }
        .ui.grid .column.left-navigation .menu .item>.menu>.item.active {
            background: none!important;
            font-weight: 500;
            border-color: #00C444;
        }
        .ui.vertical.menu .item:not(.dropdown)>.menu>.item {
            background: 0;
            padding: .7rem 1.5rem;
            font-size: .875rem;
        }
        a {
            color: #000000;
        }
        .thumb-wrap{
            overflow: hidden;
        }
        .thumb-wrap img{
            margin-top: 10px;
        }
        .pic-upload{
            width: 100%;
            height: 34px;
            margin-bottom: 10px;
        }
        #thumb-show{
            max-width: 100%;
            max-height: 300px;
        }
        .upload-mask{
            position: fixed;
            top:0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0,0,0,.4);
            z-index: 1000;
        }
        .upload-file .close{
            cursor: pointer;
            font-size: 14px;
        }

        .upload-file{
            position: absolute;
            top: 50%;
            left: 50%;
            margin-top: -105px;
            margin-left: -150px;
            max-width: 300px;
            z-index: 1001;
            display: none;
        }

        .upload-mask{
            display: none;
        }

        .ui.grid>.column:not(.row), .ui.grid>.row>.column {
            padding-left:0px;
        }

        .ui.menu {
            border-top:0px;
            border-radius: 0px;
        }
        .ui.menu.fluid, .ui.vertical.menu.fluid {
            min-height:100%;
        }

        .ui.inverted.menu .item, .ui.inverted.menu .item>a:not(.ui) {
            color:#fff;
        }
        .ui.grid>.column:not(.row), .ui.grid>.row>.column {
            padding-right: 0rem;
        }
    </style>
</head>
<body class="pushable">
@section('left-sidebar')

@show
<div class="pusher">

    <div class="top">
        @section('top')
        @show
    </div>
    <div class="body">
        <div class="body-content">
            <div class="user-area-wrap">
                <div class="ui stackable grid">
                    <div class="column main-content">
                        @section('main-content')

                        @show
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="bottom">
@section('bottom-sidebar')

@show
</div>
@section('modal')
@show
<script>
    $(document).ready(function(){
        $('.checkbox').checkbox()
    });
    function orient() {
        //alert('gete');
        if (window.orientation == 0 || window.orientation == 180) {
            $("body").attr("class", "portrait");
            orientation = 'portrait';
            return false;
        }
        else if (window.orientation == 90 || window.orientation == -90) {
            $("body").attr("class", "landscape");
            orientation = 'landscape';
            return false;
        }
    }

    $(function(){
        orient();
    });

    $(window).bind('orientationchange', function(e){
        orient();
    });
</script>
<script src="/js/components/index.js"></script>
@section('script')

@show
</body>
</html>