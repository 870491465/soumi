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
            max-width: 600px;
        }
    </style>
</head>

<body class="pushable">
<div class="pusher">
<div class="ui middle aligned center aligned grid">
    <div class="column" id="register_content">
        <h2 class="ui teal image header">
            <div class="content">
                用户注册
            </div>
        </h2>
        <form class="ui large ajax form" method="post">
            {!! csrf_field() !!}
            <div class="ui teal left aligned segment">
                <div class="ui required field aligned left">
                    <label>用户名:</label>
                    <div class="ui left icon input">
                        <i class="user icon"></i>
                        <input type="text" name="name" id="name" placeholder="英文或数字组合" />
                    </div>

                </div>
                <div class="required field">
                    <label>手机号:</label>
                    <div class="ui left icon input">
                        <i class="mobile icon"></i>
                        <input type="text" name="mobile" id="mobile" placeholder="手机号" />
                    </div>

                </div>
                <div class="required field">
                    <label>密码:</label>
                    <div class="ui left icon input">
                        <i class="expeditedssl icon"></i>
                        <input type="password" name="password" id="password" placeholder="密码最少6位">
                    </div>

                </div>
                <div class="field">
                    <label>确认密码:</label>
                    <input type="password" name="password_confirmation" id="confirm_password" placeholder="Password">
                </div>
                <button class="ui fluid large teal button submit" type="submit">注册</button>

                <div class="ui error message"></div>
            </div>
        </form>
        <div class="ui message">
            已有账户? <a href="#">登录</a>
        </div>
    </div>
</div>
</div>
<script>

</script>
</body>