<div class="ui small modal" id="modal">
    <i class="close icon"></i>
    <div class="header">充值金额</div>
    <div class="content">
        @foreach($upgrade_types as $upgrade_type)
        {!! Form::open(['url' => '', 'class' => 'ui ajax form']) !!}
            <div class="ui inline fields">
                <div class="field">
                    {!! $upgrade_type->name !!}
                </div>
                <div class="field">
                    <input type="text" name="amount" value="{!! $upgrade_type->amount !!}" />
                </div>
                <div class="field">
                    <button>修改</button>
                </div>
            </div>
        {!! Form::close() !!}
        @endforeach
    </div>
    <div class="actions">
        <div class="ui black deny button">
            关闭
        </div>
    </div>
</div>