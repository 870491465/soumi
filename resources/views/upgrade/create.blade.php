
<div class="ui small modal">
    <i class="close icon"></i>
    <div class="header">升级服务通道</div>
    <div class="content">
        {!! Form::open(['url' => '/account/upgrade', 'method' => 'post', 'class' => 'ui ajax form', 'id' => 'form1']) !!}
        <div class="field">
                    <label>升级类型:</label>
                    <select class="ui fluid dropdown" name="grade_type">
                        @foreach($upgrade_types as $grade_type)
                            <option value="{!! $grade_type->id !!}">{!! $grade_type->name !!}</option>
                        @endforeach
                    </select>
        </div>
        <div class="field">
            <button type="submit" class="ui teal button">提交申请</button>
        </div>
        {!! Form::close() !!}
    </div>
    <div class="actions">
        <div class="ui black deny button">
            关闭
        </div>
    </div>
</div>