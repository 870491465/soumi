<div class="ui small modal" id="modal">
    <i class="close icon"></i>
    <div class="header">充值金额</div>
    <div class="content">
        @foreach($upgrade_types as $upgrade_type)
        {!! Form::open(['url' => '/admin/setting/depositamount/'.$upgrade_type->id, 'class' => 'ui ajax form',
         'name' =>'form'.$upgrade_type->id]) !!}
            <div class="ui inline fields">
                <div class="four wide field">
                    {!! $upgrade_type->name !!}
                </div>
                <div class="field">
                    <input type="number" name="amount{!! $upgrade_type->id !!}" value="{!! $upgrade_type->amount !!}" />
                </div>
                <div class="field">
                    <button class="ui button teal" type="submit">修改</button>
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