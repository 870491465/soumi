<div class="ui small modal" id="code_modal">
    <div class="content">
        {!! Form::open(['url' => '/validator/'.$mobile, 'method' => 'post', 'class' => 'ui ajax form', 'id' => 'form1']) !!}
        <div class=" six wide field">
            <label>请输入手机收到的验证码</label>
            <div class="ui action left icon input">
                <i class="mail icon"></i>
                <input type="text" value="" name="code">
                <button class="ui green button">登录</button>
            </div>
        </div>
        {!! Form::close() !!}

    </div>

    <div class="actions">
        <div class="ui black deny button">
            关闭
        </div>
    </div>
</div>