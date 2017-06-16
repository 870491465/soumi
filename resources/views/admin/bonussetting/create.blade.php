<div class="ui large modal">
    <i class="close icon"></i>
    <div class="header">权益设置</div>
    <div class="content">
        {!! Form::open(array('url' => '/admin/bonus', 'class' =>'ui form ajax')) !!}
            <div class="inline fields">
                <div class="three wide field">
                    <div class="ui labeled input">
                        <label class="ui label">名称</label>
                        <input type="text" name="name" />
                    </div>
                </div>
                <div class="field">
                    <select class="ui dropdown" name="primary_role">
                        @foreach($roles as $role)
                            <option value="{!! $role->id !!}"
                            >{!! $role->display_name !!}</option>
                        @endforeach
                    </select>
                </div>
                <div class="field">
                    <select class="ui dropdown" name="agent_role">
                        @foreach($roles as $role)
                            <option value="{!! $role->id !!}"
                            >{!! $role->display_name !!}</option>
                        @endforeach
                    </select>
                </div>
                <div class="field">
                    <select class="ui dropdown" name="level">
                        @foreach($levels as $level)
                            <option value="{!! $level->level !!}"

                            >{!! $level->name !!}</option>
                        @endforeach
                    </select>
                </div>
                <div class="field">
                    <select class="ui dropdown" name="deposit_type_id">
                        @foreach($deposit_types as $type)
                            <option value="{!! $type->id !!}"
                            >{!! $type->name !!}</option>
                        @endforeach
                    </select>
                </div>
                <div class="field">
                    <div class="ui radio checkbox">
                        <label>比率</label>
                        <input type="radio" name="is_rate" tabindex="0"
                        >
                    </div>
                </div>
                <div class="two wide field">
                    <div class="ui right labeled input">
                        <input type="number" name="rate" /><label class="ui label">%</label>
                    </div>
                </div>
                <div class="field">
                    <div class="ui radio checkbox">
                        <label>固定</label>
                        <input type="radio" name="is_fixed" tabindex="0"
                        >
                    </div>
                </div>
                <div class="two wide field">
                    <div class="ui right labeled input">
                        <input type="number"  name="fixed"/>
                        <label class="ui label">￥</label>
                    </div>
                </div>
                <div class="field">
                    <button class="ui mini teal button" type="submit">新增</button>
                </div>
            </div>
        </form>
    </div>
    <div class="actions">
        <div class="ui black deny button">
            关闭
        </div>
    </div>
</div>
