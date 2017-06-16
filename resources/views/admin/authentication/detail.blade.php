<div class="ui small modal">
    <i class="close icon"></i>
    <div class="header">商户详情</div>
    <div class="content">
        <form class="ui form ajax form-horizontal" action="/account/customer/edit/{!! $account->id !!}" method="post">
            <h4 class="ui horizontal divider header">
                <i class="user icon"></i>
                个人信息
            </h4>
            <div class="field">
                <div class="two fields">
                    <div class="field">
                        <label>姓名:</label>
                        <input type="text" name="person_name" value="{!! isset($account) ? $account->person_name : '' !!}" placeholder="姓名">
                    </div>
                    <div class="field">
                        <lable>手机号:</lable>
                        <input type="text" name="mobile" value="{!! isset($account) ? $account->mobile : '' !!}">
                    </div>

                </div>
            </div>
            <div class="filed">
                <div class="two fields">
                    <div class="field">
                        <lable class="">性别:</lable>
                        <input type="radio" name="person_sex" value="1"
                        @if(isset($account))
                            {!! $account->person_sex == 1 ? 'checked' : '' !!}
                                @endif
                        >男
                        <input type="radio" name="person_sex" value="0"
                        @if(isset($account))
                            {!! $account->person_sex == 0 ? 'checked' : '' !!}

                                @endif
                        >女
                    </div>
                    <div class="field">
                        <lable>身份证号:</lable>
                        <input type="text" name="identity_card" value="{!! isset($account) ? $account->identity_card : '' !!}" checked>
                    </div>
                </div>
            </div>
            <h4 class="ui horizontal divider header">
                <i class="university icon"></i>公司信息
            </h4>
            <div class="filed">
                <div class="two fields">
                    <div class="field">
                        <label>公司名称</label>
                        <input type="text" name="business_name" value="{!! isset($account) ? $account->business_name : '' !!}" placeholder="Last Name">
                    </div>
                    <div class="field">
                        <label>公司营业执照编号:</label>
                        <input type="text" name="license_no" value="{!! isset($account) ? $account->license_no : '' !!}">
                    </div>
                </div>
            </div>

            <input type="hidden" name="_token" value="{{ csrf_token() }}" />
            <input id="license_pic"  type="hidden" name="license_pic" value="{!! $account->license_pic !!}">
            <input id="identity_card_pic"  type="hidden" name="identity_card_pic" value="{!! $account->identity_card_pic !!}">
            <div class="field add-col-width">
                <button class="ui teal button
                @if($account->status == 1 || $account->status ==2)
                        disabled
                    @endif"
                >
                    @if($account->status == 0)
                        提交
                    @elseif($account->status == 1)
                        待审核
                    @elseif($account->status == 2)
                        通过
                    @elseif($account->status == 3)
                        未通过重新提交
                    @endif
                </button>
            </div>
        </form>
        <h4 class="ui horizontal divider header"><i class="tag icon"></i>附件</h4>
        <div class="filed">
            <div class="two fields">
                <div class="field">
                    <lable>身份证照片:</lable>
                    @if(isset($account))
                        <img class="ui small rounded image" src="{!! $account->identity_card_pic !!}" />
                    @endif
                </div>
                <div class="field">
                    <lable>营业执照照片:</lable>
                    @if(isset($account))
                        <img class="ui small rounded image" src="{!! $account->license_pic !!}" />
                    @endif
                </div>
            </div>
        </div>
    </div>
    <div class="actions">
        <div class="ui black deny button">
            关闭
        </div>
    </div>
</div>
