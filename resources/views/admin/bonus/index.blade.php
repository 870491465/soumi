@extends('partials.master')

@section('content')

    <div class="head-description">
        <div class="ui horizontal list">
            <div class="item">
                <div class="content">
                    <h3>商户权益</h3>
                </div>
            </div>
        </div>
    </div>
    <div class="new-product-container">
        {!! Form::open(['url' => '/admin/bonus/search', 'class'=> 'ui mini form']) !!}
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
            <th>手机号</th>
            <th>公司名称</th>
            <th>权益金额</th>
            <th>权益名称</th>
            <th>类型</th>
            <th>提交日期</th>
        </tr>
        </thead>
        <tbody>
        <?php $i = 1 ?>
        @foreach($bonus as $bonu)
            <tr>
                <td><?php echo $i ?></td>
                <td>{!! $bonu->account->person_name !!}</td>
                <td>{!! $bonu->account->mobile !!}</td>
                <td>{!! $bonu->account->business_name !!}</td>
                <td>{!! $bonu->amount !!}</td>
                <td>{!! $bonu->type->name !!}</td>
                <td>{!! $bonu->type->deposit_type->name !!}</td>
                <td>{!! $bonu->created_at !!}</td>
            </tr>
            <?php $i++ ?>
        @endforeach
        </tbody>
    </table>
@stop