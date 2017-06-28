<div class="ui small modal">
    <i class="close icon"></i>
    <div class="header">新增商户</div>
    <div class="content">
        {!! Form::open(['url' => '/admin/account', 'method' => 'post', 'class' => 'ui ajax form', 'id' => 'form1']) !!}
        <div class="field">
            <div class="two fields">
                <div class="field">
                    <label>姓名:</label>
                    <div class="ui left icon input">
                        <i class="user icon"></i>
                        <input type="text" name="person_name" placeholder="姓名">
                    </div>

                </div>
                <div class="field">
                    <lable>手机号:</lable>
                    <div class="ui left icon input">
                        <i class="mobile icon"></i>
                        <input type="text" name="mobile" placeholder="手机号">
                    </div>

                </div>
            </div>
        </div>
        <div class="filed">
            <div class="two fields">
                <div class="field">
                    <lable>性别:</lable>
                    <div class="inline fields">
                        <div class="field">
                            <div class="ui radio checkbox">
                                <input type="radio" name="person_sex" value="1" checked><label>男</label>
                            </div>
                        </div>
                        <div class="field">
                            <div class="ui radio checkbox">
                                <input type="radio" name="person_sex" value="0"><label>女</label>
                            </div>
                        </div>
                    </div>

                </div>
                <div class="field">
                    <lable>身份证号:</lable>
                    <div class="ui left icon input">
                        <i class="protect icon"></i>
                        <input type="text" name="identity_card" value="" placeholder="身份证号码">
                    </div>
                </div>
            </div>
            <div class="field">
                <button class="ui submit green button" type="submit">新增</button>
            </div>
        </div>
        <input type="hidden" name="_token" value="{{ csrf_token() }}" />
        </form>
    </div>
    <div class="actions">
        <div class="ui black deny button">
            关闭
        </div>
    </div>
</div>
