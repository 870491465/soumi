<div class="ui small modal" id="modal">
    <i class="close icon"></i>
    <div class="header">短信内容</div>
    <div class="content">
        {!! Form::open(['url' => '/admin/setting/smscontent', 'class' => 'ui form ajax form-horizontal', 'method' => 'post']) !!}
        <div class="field">
            <label>发送内容</label>
            <textarea name="smscontent">{!! $sms_content->content !!}</textarea>
        </div>

        <div class="field add-col-width">
            <button class="ui teal button" type="submit">
                编辑
            </button>
        </div>
        {!! Form::close() !!}
    </div>
    <script>
        $('.ui.radio').checkbox();
    </script>
</div>
