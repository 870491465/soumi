@extends('partials.master')

@section('content')

    <div class="head-description">
        <div class="ui horizontal list">
            <div class="item">
                <div class="content">
                    <h3>提现记录</h3>
                </div>
            </div>
            <div class="item">
                <button class="ui mini teal openModal button"><i class="add icon"></i>提现</button>
            </div>
        </div>
    </div>

    <table class="ui celled striped table userpage-content">
        <thead>
        <tr>
            <th class="one wide">序号</th>
            <th class="three wide">取款金额</th>
            <th class="two wide">状态</th>
            <th class="twelve wide">日期</th>
        </tr>
        </thead>
        <tbody>
        <?php $i = 1 ?>
        @foreach($transfers as $transfer)
        <tr>
            <td class="one wide"><?php echo $i ?></td>
            <td class="three wide">{!! $transfer->amount !!}</td>
            <td class="tow wide">{!! $transfer->status->display_name !!}</td>
            <td class="twelve wide">{!! $transfer->created_at !!}</td>
        </tr>
            <?php $i++ ?>
        @endforeach
        </tbody>
    </table>
    @include('transfer.create')
@stop