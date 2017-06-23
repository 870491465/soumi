@extends('layout.master')

@section('left-sidebar')

@stop

@section('top')
    @include('partials.child_top_siderbar_menu')
@stop
@section('main-content')


    {{--<table class="ui celled striped table userpage-content">
        <thead>
        <tr>
            <th class="one wide">序号</th>
            <th class="three wide">收益类型</th>
            <th class="two wide">收益金额</th>
            <th class="three wide">发生类型</th>
            <th class="three wide">日期</th>
        </tr>
        </thead>
        <tbody>--}}
        <?php $i=1 ?>
        @if(isset($bonuses))
        @foreach($bonuses as $bonus)
            <div class="ui divided items">
                <div class="item">
                    <div class="content">
                       <span>收益金额：{!! $bonus->amount !!}</span>
                    </div>
                </div>
            </div>
     {{--   <tr>
            <td class="one wide"><?php echo $i ?></td>
            <td class="three wide">{!! $bonus->type->name !!}</td>
            <td class="tow wide">{!! $bonus->amount !!}</td>
            <td class="two wide">{!! $bonus->type->deposit_type->name !!}</td>
            <td class="two wide">{!! $bonus->created_at !!}</td>
        </tr>--}}
            <?php $i++ ?>
         @endforeach
         @endif
     {{--   </tbody>
    </table>--}}
@stop