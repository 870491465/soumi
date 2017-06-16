@extends('partials.master')

@section('content')

    <div class="head-description">
        <div class="ui horizontal list">
            <div class="item">
                <div class="content">
                    <h3>商户列表</h3>
                </div>
            </div>
        </div>
    </div>
    <div class="new-product-container">
        {!! Form::open(['url' => '/admin/deposit/search', 'class'=> 'ui mini form']) !!}
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
            <th>序号</th>
            <th>姓名</th>
            <th>身份证</th>
            <th>手机号</th>
            <th>公司名称</th>
            <th>级别</th>
            <th>状态</th>
            <th>详情</th>
            <th>操作</th>
            <th>提交日期</th>
        </tr>
        </thead>
        <tbody>
        <?php $i = 1 ?>
        @foreach($accounts as $account)
            <tr>
                <td><?php echo $i ?></td>
                <td>{!! $account->person_name !!}</td>
                <td>{!! $account->license_no !!}</td>
                <td>{!! $account->mobile !!}</td>
                <td>{!! $account->business_name !!}</td>
                <td>
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
                <td>
                    @if($account->status == 2)
                        正常
                    @elseif($account->status == 3)
                        关闭
                    @endif
                </td>
                <td><a href="javascript:void(0);" data-modal-id="EditAttendee"
                       class="loadModal ui mini teal icon button"
                       data-href="{!! route('getCustomer', ['id' => $account->id]) !!}">
                        <i class="browser icon"></i>详情</a></td>
                <td>
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
                </td>
                <td>{!! $account->created_at !!}</td>
            </tr>
            <?php $i++ ?>
        @endforeach
        </tbody>
    </table>
    @include('admin.authentication.detail')
@stop