@extends('partials.master')

@section('content')

    <div class="head-description">
        <div class="ui horizontal list">
            <div class="item">
                <div class="content">
                    <h3>充值记录</h3>
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
            <th class="one wide">序号</th>
            <th class="one wide">姓名</th>
            <th class="two wide">手机号</th>
            <th class="three wide">公司名称</th>
            <th class="two wide">充值金额</th>
            <th class="two wide">升级类型</th>
            <th class="two wide">状态</th>
            <th class="three wide">提交日期</th>
        </tr>
        </thead>
        <tbody>
        <?php $i = 1 ?>
        @foreach($deposits as $deposit)
            <tr>
                <td><?php echo $i ?></td>
                <td>{!! $deposit->account->person_name !!}</td>
                <td>{!! $deposit->account->mobile !!}</td>
                <td>{!! $deposit->account->business_name !!}</td>
                <td>{!! $deposit->amount !!}</td>
                <td>
                    {!! $deposit->upgrade_type->name !!}
                </td>
                <td>
                    {!! $deposit->status->display_name !!}
                </td>
                <td>{!! $deposit->created_at !!}</td>
            </tr>
            <?php $i++ ?>
        @endforeach
        </tbody>
    </table>
@stop