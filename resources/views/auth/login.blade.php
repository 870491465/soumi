<!DOCTYPE html>
<html>
<head lang="en">
    <meta charset="UTF-8">
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <title></title>
    <link href="/css/components/semantic.min.css" rel="stylesheet">
    <script src="/js/components/jquery.min.js"></script>
    <script src="/js/components/jquery.form.js"></script>
    <script src="/js/components/semantic.min.js"></script>
    <script src="/js/components/index.js"></script>
    <style type="text/css">
        body {
            background-color: #DADADA;
        }
        body > .grid {
            height: 100%;
        }
        .image {
            margin-top: -100px;
        }
        .column {
            max-width: 450px;
        }
    </style>
</head>

<body>
<div class="ui middle aligned center aligned grid">
    <div class="column">
        <h2 class="ui teal image header">
            <div class="content">
                用户登录
            </div>
        </h2>
        <form class="ui large ajax form" action="{!! route('postLogin') !!}" method="post">
            {!! csrf_field() !!}
            <div class="ui stacked segment">
                <div class="field">
                    <div class="ui left icon input">
                        <i class="user icon"></i>
                        <input type="text" name="mobile" placeholder="手机号">
                    </div>
                </div>
                <div class="field">
                    <div class="ui left icon input">
                        <i class="lock icon"></i>
                        <input type="password" name="password" maxlength="15" placeholder="密码">
                    </div>
                </div>
                <button class="ui fluid large teal button submit" type="submit">登录</button>

            </div>

            <div class="ui error message"></div>
            <input type="hidden" name="_token" value="{{ csrf_token() }}" />
        </form>

        <div class="ui message">
            没有账号? <a href="#">返回注册</a>
        </div>
    </div>
</div>
</body>