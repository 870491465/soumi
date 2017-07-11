@extends('layout.master')

@section('left-sidebar')
    @include('partials.left_sidebar_menu')
@stop

@section('main-content')
    <div class="ui top attached tabular menu">
        <div class="item"><h5 class="header">公告</h5></div>
    </div>
    @if(isset($message->content))
    <div class="ui segment">
        {!! $message->content !!}
    </div>
    @endif
    <div class="ui top attached tabular menu">
        <div class="item"><h5 class="header">权益</h5></div>
    </div>
    @if(isset($bonuses))
        @foreach($bonuses as $bonus)
            <div class="ui teal segment">
                <div class="ui gray divided list">
                    <div class="item">
                        <div class="right floated content">
                            <div class="meta">
                                <span>发生人：{!! $bonus->childAccount->person_name !!}</span>
                            </div>
                        </div>
                        <div class="content">
                            <div class="header">权益金额:￥{!! $bonus->amount !!}</div>
                        </div>
                        <br>
                        <div class="content">
                            日期:{!! $bonus->created_at !!}
                        </div>
                    </div>
                    <div class="ui divider"></div>
                </div>
            </div>
        @endforeach
    @else
        无权益
    @endif
@stop

@section('top')
    @include('partials.top_sidebar_menu')
@stop

@section('bottom-sidebar')
    @include('partials.bottom_sidebar_menu')
@stop

@section('script')
    <script>
        $(document).ready(function() {

            $('#left_sidebar')
                    .sidebar('attach events', '#sidebar_menu')
        })

    </script>
@stop