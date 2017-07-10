<div class="ui small modal">
    <i class="close icon"></i>
    <div class="header">资金互转</div>
    <div class="content">
        <div class="ui form">
            <div class="field">
                <div class="three inline fields">
                    <div class="field">
                        <label>姓名:</label>
                        <input type="text" name="person_name" disabled value="{!! isset($account) ? $account->person_name : '' !!}" placeholder="姓名"  />
                    </div>
                    <div class="field">
                        <lable>公司名称:</lable>
                        <input type="text" name="mobile" value="{!! $account->business_name !!}" disabled />
                    </div>
                    <div class="field">
                        <lable>所属级别:</lable>
                        <input type="text" value="@if($account->user->role_id == 2)服务商 @elseif($account->user->role_id == 3)运营商 @elseif($account->user->role_id == 4)分公司 @endif" />
                    </div>
                </div>
            </div>
        </div>
        @if(isset($balance))
            <div class="ui top attached tabular menu">
                <div class="item">账户余额:{!! $balance->amount !!}</div>
            </div>
            </div>
        @endif
        {!! Form::open(['url' =>route('postCustomerHedge', ['id' => $account->id]), 'class' => 'ui form ajax']) !!}
        <div class="field">
            <div class="two fields">
                <div class="field">
                    <label>转账金额</label>
                    <input type="number" name="amount" placeholder="请输入转账金额"/>
                </div>
                <div class="field">
                    <label>对方账户</label>
                    <select class="ui fluid search  dropdown" name="collection_account">
                        <option value="">请选对方账户</option>
                        @foreach($accounts as $account2)
                            <option value="{!! $account2->id !!}">{!! $account2->person_name !!}[{!! $account2->mobile !!}]</option>
                        @endforeach
                    </select>
                </div>
            </div>
        </div>
        <div class="field add-col-width">
            <button class="ui teal button" type="submit">
                转账
            </button>
        </div>
        <input type="hidden" name="before_agent" value="{!! isset($customer->primaryAccount) ? $customer->primaryAccount->id : '' !!}" />
        <input type="hidden" name="account_id" value="{!! $account->id !!}" />
        {!! Form::close() !!}
    </div>
</div>
<div class="actions">
    <div class="ui black deny button">
        关闭
    </div>
</div>
<script>
    $('.ui.dropdown')
            .dropdown()
    ;
</script>
</div>
