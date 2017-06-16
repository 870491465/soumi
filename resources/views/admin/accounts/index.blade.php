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

    <table class="ui celled striped table userpage-content">
        <thead>
        <tr>
            <th class="one wide">序号</th>
            <th class="one wide">姓名</th>
            <th class="two wide">身份证</th>
            <th class="two wide">手机号</th>
            <th class="three wide">公司名称</th>
            <th class="one wide">状态</th>
            <th class="one wide">详情</th>
            <th class="two wide">操作</th>
            <th class="three wide">提交日期</th>
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
                    @if($account->status == 2)
                        正常
                    @elseif($account->status == 1)
                        关闭
                    @endif
                </td>
                <td><a>详情</a></td>
                <td>
                    <div class="ui mini buttons">
                        <button class="ui mini button ">关闭</button>
                        <div class="or"></div>
                        <button class="ui mini positive button">开通</button>
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