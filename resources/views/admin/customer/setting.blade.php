<div class="ui small modal">
    <i class="close icon"></i>
    <div class="header">商户信息</div>
        <div class="content">
            <div class="ui form form-horizontal">
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
                            <label>公司名称</label>
                            <input type="text" name="business_name" value="{!! isset($account) ? $account->business_name : '' !!}" placeholder="Last Name">
                        </div>
                        <div class="field">
                            <label>公司营业执照编号:</label>
                            <input type="text" name="license_no" value="{!! isset($account) ? $account->license_no : '' !!}">
                        </div>
                    </div>
                </div>
                <h4 class="ui horizontal divider header">
                    <i class="university icon"></i>公司信息
                </h4>
                <div class="field">
                    <div class="two fields">
                        <div class="field">
                            <div class="ui mini buttons">
                                {!! Form::open(array('url' => route('postAuthentication', ['id' => $account->id, 'status' =>3]),
                                'class' => 'ui form ajax', 'id' => 'form'. $account->id)) !!}
                                <button class="ui mini button " type="submit">关闭</button>
                                {!! Form::close() !!}
                                <div class="or"></div>
                                {!! Form::open(array('url' => route('postAuthentication', ['id' => $account->id, 'status' =>2]),
                                'class' => 'ui form ajax', 'id' => 'form'. $account->id)) !!}
                                <button class="ui mini positive button" type="submit">开通</button>
                                {!! Form::close() !!}
                            </div>
                        </div>
                    </div>
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
