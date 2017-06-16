@extends('partials.master')

@section('content')

    <div class="head-description">
        <div class="ui horizontal list">
            <div class="item">
                <div class="content">
                    <h3>报单审核</h3>
                </div>
            </div>
        </div>
    </div>

    <table class="ui celled striped table userpage-content">
        <thead>
        <tr>
            <th>序号</th>
            <th>姓名</th>
            <th>手机号</th>
            <th>公司名称</th>
            <th>报单金额</th>
            <th>发票</th>
            <th>状态</th>
            <th>操作</th>
            <th>提交日期</th>
        </tr>
        </thead>
        <tbody>
        <?php $i = 1 ?>
        @if($declarations->count()>0)
        @foreach($declarations as $declaration)
            <tr>
                <td><?php echo $i ?></td>
                <td>{!! $declaration->account->person_name !!}</td>
                <td>{!! $declaration->account->mobile !!}</td>
                <td>{!! $declaration->account->business_name !!}</td>
                <td>{!! $declaration->amount !!}</td>
                <td>
                    <img src="{!! $declaration->invoice_pic !!}" class="ui mini image"/>
                </td>
                <td>
                    {!! $declaration->status->display_name !!}
                </td>
                <td>
                    <div class="ui mini buttons">
                        <button class="ui mini button ">不通过</button>
                        <div class="or"></div>
                        <button class="ui mini positive button">通过</button>
                    </div>
                </td>
                <td>{!! $declaration->created_at !!}</td>
            </tr>
            <?php $i++ ?>
        @endforeach
        @endif
        </tbody>
    </table>
@stop