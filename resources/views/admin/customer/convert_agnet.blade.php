<div class="ui small modal">
    <i class="close icon"></i>
    <div class="header">商户转代理</div>
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
        @if(isset($customer))
            <div class="ui top attached tabular menu">
                <div class="item">所属代理</div>
            </div>
            <div class="field">
                <div class="ui form">
                    <div class="two fields">
                        <div class="field">
                            <label>姓名:</label>
                            <input type="text" value="{!! $customer->primaryAccount->person_name !!}" />
                        </div>
                        <div class="field">
                            <label>代理级别:</label>
                            <input type="text" value="@if($customer->primaryAccount->user->role_id == 2)服务商 @elseif($customer->primaryAccount->user->role_id == 3)运营商 @elseif($customer->primaryAccount->user->role_id == 4)分公司 @endif"/>
                        </div>
                    </div>
                </div>
            </div>
        @endif
        <div class="ui top attached tabular menu">
            <div class="item">转代理</div>
        </div>
        {!! Form::open(['url' =>'/admin/customer/convert', 'class' => 'ui ajax from']) !!}
        <div class="field">
            <select class="ui fluid search  dropdown" name="primary_account">
                <option value="">请选择新代理</option>
                @foreach($accounts as $account2)
                    <option value="{!! $account2->id !!}">{!! $account2->person_name !!}[{!! $account2->business_name !!}]</option>
                @endforeach
            </select>
        </div>
        <div class="field add-col-width">
            <button class="ui teal button" type="submit">
                转代理
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
