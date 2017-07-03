@extends('partials.master')

@section('content')

    <div class="head-description">
        <div class="ui horizontal list">
            <div class="item">
                <div class="content">
                    <h3>商户列表</h3>
                </div>
            </div>
            <div class="item">
                <div class="content">
                    <button class="ui button openModal">
                        <i class="add user icon"></i>
                        新增商户
                    </button>
                </div>
            </div>
        </div>
    </div>
    <div class="new-product-container">
        {!! Form::open(['url' => '/admin/customer/search', 'class'=> 'ui mini form']) !!}
        <div class=" inline fields">
            <div class="field">
                <label>姓名：</label>
                <input type="text" name="name" />
            </div>
            <div class="field">
                <label>手机号:</label>
                <input type="text" name="mobile"/>
            </div>
            <div class="field">
                <label>公司名称:</label>
                <input type="text" name="business_name" />
            </div>
            <div class="field">
                <button class="ui icon teal button">
                    <i class="search icon"></i>
                    查询
                </button>
            </div>
        </div>

        {!! Form::close() !!}
     </div>
    <table class="ui celled striped table userpage-content">
        <thead>
        <tr>
            <th class="center aligned">序号</th>
            <th class="center aligned">姓名</th>
            <th class="center aligned">身份证</th>
            <th class="center aligned">手机号</th>
            <th class="center aligned">公司名称</th>
            <th class="center aligned">级别</th>
            <th class="center aligned">状态</th>
            <th class="center aligned">详情</th>
            <th class="center aligned">设置</th>
            <th class="center aligned">升级</th>
            <th class="center aligned">转代理</th>
            <th class="center aligned">提交日期</th>
        </tr>
        </thead>
        <tbody>
        <?php $i = 1 ?>
        @foreach($accounts as $account)
            <tr>
                <td class="center aligned"><?php echo $i ?></td>
                <td class="center aligned">{!! $account->person_name !!}</td>
                <td class="center aligned">{!! $account->license_no !!}</td>
                <td class="center aligned">{!! $account->mobile !!}</td>
                <td class="center aligned">{!! $account->business_name !!}</td>
                <td class="center aligned">
                    @if($account->user->role_id == 1)
                        免费用户
                    @elseif($account->user->role_id == 2)
                        服务商
                    @elseif($account->user->role_id == 3)
                        运营商
                    @elseif($account->user->role_id == 4)
                        分公司
                    @endif
                </td>
                <td class="center aligned">
                    @if($account->status == 2)
                        正常
                    @elseif($account->status == 3)
                        关闭
                    @endif
                </td>
                <td class="center aligned"><a href="javascript:void(0);" data-modal-id="EditAttendee"
                       class="loadModal ui mini teal icon button"
                       data-href="{!! route('getCustomer', ['id' => $account->id]) !!}">
                        <i class="browser icon"></i>详情</a></td>
                <td class="center aligned">
                    <a href="javascript:void(0);" data-modal-id="EditAttendee"
                       class="loadModal ui mini teal icon button"
                       data-href="{!! route('settingCustomer', ['id' => $account->id]) !!}">
                        <i class="setting icon"></i>设置</a>
                </td>
                <td class="center aligned">
                    <a href="javascript:void(0);" data-modal-id="EditAttendee"
                       class="loadModal ui mini teal icon button"
                       data-href="{!! route('customerUpgrade', ['id' => $account->id]) !!}">
                        <i class="setting icon"></i>升降级</a>
                </td>
                <td class="center aligned">
                    <a href="javascript:void(0);" data-modal-id="EditAttendee"
                       class="loadModal ui mini teal icon button"
                       data-href="{!! route('customerConvertAgent', ['id' => $account->id]) !!}">
                        <i class="setting icon"></i>转代理</a>
                </td>
                <td class="center aligned">{!! $account->created_at !!}</td>
            </tr>
            <?php $i++ ?>
        @endforeach
        </tbody>
        @if(method_exists($accounts, 'links'))
        <tfoot>
        <tr>
            <th colspan="12">{!! $accounts->links() !!}</th>
        </tr>
        </tfoot>
         @endif
    </table>
@include('admin.accounts.create')
@stop