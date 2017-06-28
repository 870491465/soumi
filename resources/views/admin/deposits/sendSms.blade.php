<div class="ui small modal">
    <i class="close icon"></i>
    <div class="header">发送短信</div>
    <div class="content">
        {!! Form::open(['url' => '/admin/upgrade/sms', 'class' => 'ui form ajax form-horizontal', 'method' => 'post']) !!}
        <div class="two fields">
            <div class="field">
                <label>接收人</label>
                <input type="text" name="name" value="{!! $name !!}">
            </div>
            <div class="field">
                <label>接收手机号</label>
                <input type="text" name="mobile" value="{!! $mobile !!}">
            </div>
        </div>
        <div class="field">
            <label>发送内容</label>
            <textarea name="smscontent">
                {!! $content !!}
            </textarea>
        </div>

        <div class="field add-col-width">
            <button class="ui teal button" type="submit">
                发送
            </button>
        </div>
        {!! Form::close() !!}
    </div>
    <script>
        $('.ui.radio').checkbox();
    </script>
</div>
