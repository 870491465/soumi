<div class="ui small modal" id="mobile">
    <i class="close icon"></i>
    <div class="header">修改手机号</div>
    <div class="content">
        {!! Form::open(['url' => '/account/setting/password', 'method' => 'post', 'class' => 'ui ajax form', 'id' => 'form1']) !!}
        <div class="field">
            <label>手机号:</label>
            <div class="ui disabled input">
                <input type="text" name="mobile" value="{!! $account->user->mobile !!}">
            </div><button class="ui teal button">发送验证码</button>
        </div>
        <div class="field">
            <label>验证码:</label>
            <input type="text" name="code" >
        </div>
        <div class="新手机号:"></div>

        <div class="field">
            <input type="submit" class="ui teal button" value="修改">
        </div>
        {!! Form::close() !!}
    </div>
    <div class="actions">
        <div class="ui black deny button">
            关闭
        </div>
    </div>
</div>