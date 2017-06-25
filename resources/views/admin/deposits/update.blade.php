<div class="ui small modal">
    <i class="close icon"></i>
    <div class="header">充值审核</div>
    <div class="content">
        {!! Form::open(['url' => '/admin/deposit/'. $id, 'class' => 'ui form ajax form-horizontal', 'method' => 'post']) !!}
        <div class="field">
            <div class="inline fields">
                <label>审核状态</label>
                <div class="field">
                    <div class="ui radio checkbox">
                        <input type="radio" value="3" name="status" checked tabindex="0" class="hidden">
                        <label>通过</label>
                    </div>
                </div>
                <div class="field">
                    <div class="ui radio checkbox">
                        <input type="radio" value="5" name="status"  tabindex="0" class="hidden">
                        <label>不通过</label>
                    </div>
                </div>
            </div>
        </div>

        <div class="field add-col-width">
            <button class="ui teal button" type="submit">
                确定
            </button>
        </div>
        {!! Form::close() !!}
    </div>
    <script>
        $('.ui.radio').checkbox();
    </script>
</div>
