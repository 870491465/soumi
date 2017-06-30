@extends('layout.master')

@section('left-sidebar')

@stop

@section('top')
    @include('partials.child_top_siderbar_menu')
@stop
@section('main-content')
    @if(isset($transfers))
        @foreach($transfers as $transfer)
            <div class="ui gray divided list">
                <div class="item">
                    <div class="right floated content">
                        <div class="meta">
                            <span>状态：{!! $transfer->status->display_name !!}</span>
                        </div>
                    </div>
                    <div class="content">
                        <div>取款金额:￥{!! $transfer->amount !!}</div>
                    </div>
                    <br>
                    <div class="right floated content">
                        <div class="meta">到帐日期:{!! \Carbon\Carbon::parse($transfer->created_at)->addDay(15)->format('Y-m-d') !!}</div>
                    </div>
                    <div class="content">
                        取款日期:{!! $transfer->created_at !!}
                    </div>
                </div>
                <div class="ui divider"></div>
            </div>
        @endforeach
    @endif
@stop