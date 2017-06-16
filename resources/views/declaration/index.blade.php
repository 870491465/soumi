@extends('partials.master')

@section('content')

    <div class="head-description">
        <div class="ui horizontal list">
            <div class="item">
                <div class="content">
                    <h3>报单</h3>
                </div>
            </div>
            <div class="item">
                <a class="ui mini teal button openModal" href="javascript:void(0);"
                ><i class="add icon"></i>新增报单</a>
            </div>
        </div>
    </div>

    <table class="ui celled striped table userpage-content">
        <thead>
        <tr>
            <th class="one wide">序号</th>
            <th class="three wide">报单金额</th>
            <th class="three wide">状态</th>
            <th class="two wide">发票</th>
            <th class="three wide">日期</th>
        </tr>
        </thead>
        <tbody>
        <?php $i=1 ?>
        @if(isset($account->declarations))
        @foreach($account->declarations as $declaration)
            <tr>
                <td class="one wide"><?php echo $i ?></td>
                <td class="three wide">{!! $declaration->amount !!}</td>
                <td class="three wide">
                    {!! $declaration->status->display_name !!}
                </td>
                <td class="two wide">
                    <img class="ui small rounded image" src="{!! $declaration->invoice_pic !!}" />
                </td>
                <td class="three wide">{!! $declaration->created_at !!}</td>
            </tr>
            <?php $i++ ?>
        @endforeach
        @endif
        </tbody>
    </table>
    @include('declaration.create')
@stop