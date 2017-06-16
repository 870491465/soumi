@extends('partials.master')

@section('content')

    <div class="head-description">
        <h3>充值列表</h3>
    </div>

    <table class="ui celled striped table userpage-content">
        <thead>
        <tr>
            <th class="one wide">序号</th>
            <th class="three wide">充值金额</th>
            <th class="three wide">充值类型</th>
            <th class="two wide">状态</th>
            <th class="three wide">日期</th>
        </tr>
        </thead>
        <tbody>
        <?php $i =1 ?>
        @foreach($deposits as $deposit)
        <tr>
            <td class="one wide"><?php echo $i ?></td>
            <td class="three wide">{!! $deposit->amount !!}</td>
            <td class="three wide">{!! $deposit->upgrade_type->name !!}</td>
            <td class="two wide">{!! $deposit->status->name !!}</td>
            <td class="three wide">{!! $deposit->created_at !!}</td>
        </tr>
         <?php $i++ ?>
        @endforeach
        </tbody>
    </table>
@stop