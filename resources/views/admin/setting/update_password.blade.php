<div class="ui small modal" id="modal">
    <i class="close icon"></i>
    <div class="header">修改密码</div>
    <div class="content">
        {!! Form::open(['url' => '/admin/setting/password', 'method' => 'post', 'class' => 'ui ajax form', 'id' => 'form1']) !!}
        <div class="field">
            <label>原始密码:</label>
            <div class="ui left icon input">
                <i class="lock icon"></i>
                <input type="password" name="oldpassword">
            </div>

        </div>
        <div class="field">
            <label>新密码：</label>
            <div class="ui left icon input">
                <i class="lock icon"></i>
                <input type="password" name="newpassword">
            </div>
        </div>
        <div class="field">
            <label>确认新密码:</label>
            <div class="ui left icon input">
                <i class="lock icon"></i>
                <input type="password" name="newpassword_confirmation">
            </div>
        </div>
        <div class="field">
            <button type="submit" class="ui teal button">修改</button>
        </div>
        {!! Form::close() !!}
    </div>
    <div class="actions">
        <div class="ui black deny button">
            关闭
        </div>
    </div>
</div>