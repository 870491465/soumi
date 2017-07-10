<div class="ui large modal">
    <i class="close icon"></i>
    <div class="header">权益设置</div>
    <div class="content">
        {!! Form::open(array('url' => '/admin/bonussetting', 'class' =>'ui form ajax')) !!}
            <div class="fields">
                <div class="field">
                    <div class="ui labeled input">
                        <label class="ui label">名称</label>
                        <input type="text" name="name" />
                    </div>
                </div>
            </div>
            <div class="fields">
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
                <div class="field bottom_role hide">
                    <select class="ui dropdown" name="bottom_role">
                        <option value="">请选择代理级别</option>
                        @foreach($roles as $role)
                            <option value="{!! $role->id !!}"
                            >{!! $role->display_name !!}</option>
                        @endforeach
                    </select>
                </div>
            </div>
            <div class="fields">
                <div class="field">
                    <select class="ui dropdown" id="level" onchange="levelOnchange(this)" name="level">
                        @foreach($levels as $level)
                            <option value="{!! $level->level !!}"

                            >{!! $level->name !!}</option>
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
            </div>
            <div class="field">
                <button class="ui mini teal button" type="submit">新增</button>
            </div>
        </form>
    </div>
    <div class="actions">
        <div class="ui black deny button">
            关闭
        </div>
    </div>
    <script>
        function levelOnchange(obj)
        {
            var index = obj.selectedIndex;
            var value = obj.options[index].value;
            if(value == 3) {

            }
        }
    </script>
</div>
