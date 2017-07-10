<div class="ui small modal">
    <i class="close icon"></i>
    <div class="header">商户升降级</div>
    <div class="content">
        {!! Form::open(['url' => route('postCustomerUpgrade', ['account_id' => $account->id]), 'class' => 'ui form form-horizontal ajax']) !!}
            <div class="field">
                <div class="three fields">
                    <div class="field">
                        <label>姓名:</label>
                        <input type="text" name="person_name" disabled value="{!! isset($account) ? $account->person_name : '' !!}" placeholder="姓名">
                    </div>
                    <div class="field">
                        <lable>目前级别:</lable>
                        <input type="text" name="mobile" value="@if($account->user->role_id == 2)服务商 @elseif($account->user->role_id == 3)运营商@elseif($account->user->role_id == 4)分公司@endif
                        " disabled>
                    </div>

                        <div class="field">
                            <label>账户余额</label>
                            @if(isset($balance))
                            <input type="text" value="￥{!! $balance->amount !!}">
                            @else
                                ￥0.00
                            @endif

                        </div>
                </div>
            </div>
            <div class="field">
                <div class="two inline fields">
                    <div class="field">
                        <label>代理类型:</label>
                        <select class="ui dropdown" id="afer_role" name="after_role">
                            <option value="1">免费用户</option>
                            <option value="2">服务商</option>
                            <option value="3">运营商</option>
                            <option value="4">分公司</option>
                        </select>
                    </div>
                    <div class="field">
                        <div class="ui checkbox">
                            <input type="checkbox" name="is_have_bonus"  tabindex="0" class="hidden">
                            <label>是否发生权益</label>
                        </div>
                    </div>
                </div>
            </div>
            <div class="field">
                <div class="two fields">
                    <div class="field">
                        <button class="ui teal button" type="submit">设置</button>
                    </div>
                </div>
            </div>
            <input type="hidden" name="before_role" value="{!! $account->user->role_id !!}" />
        {!! Form::close() !!}
    </div>
</div>
<div class="actions">
    <div class="ui black deny button">
        关闭
    </div>
</div>
<script>
    $('.ui.checkbox')
            .checkbox()
    ;
</script>
</div>
