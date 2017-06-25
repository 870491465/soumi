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
                用户,{!! $name !!}. 您好，由于您的代理,{!! $upgrade_name !!}.升级为运营商.您目前的代理级别达不到返权益的要求，
                请您在一天内尽快升级。一面影响您的收益.
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
