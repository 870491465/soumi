@extends('layout.master')

@section('left-sidebar')

@stop

@section('top')
    @include('partials.child_top_siderbar_menu')
@stop
@section('main-content')
        @if(isset($deposits))
            @foreach($deposits as $deposit)
                <div class="ui gray divided list">
                    <div class="item">
                        <div class="right floated content">
                            <div class="meta">
                                <span>充值日期：{!! $deposit->created_at !!}</span>
                            </div>
                        </div>
                        <div class="content">
                            <div class="header">充值金额:￥{!! $deposit->amount !!}</div>
                        </div>
                    </div>
                    <div class="ui divider"></div>
                </div>
            @endforeach
        @endif
@stop