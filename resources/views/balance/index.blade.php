@extends('layout.master')

@section('left-sidebar')

@stop

@section('top')
    @include('partials.child_top_siderbar_menu')
@stop
@section('main-content')


            <div class="ui card">
                <div class="content">
                    <div class="header">
                        {!! $account->person_name !!}
                    </div>
                    <div class="meta">
                        您的账户余额为
                    </div>
                    <div class="description">
                        @if(isset($account->balance))
                            ￥ {!! $account->balance->amount !!}
                        @else
                            ￥0.00
                        @endif

                    </div>
                </div>
                <div class="extra content">
                    <div class="ui two buttons">
                        <button class="ui basic green button openModal">提现</button>
                        <a class="ui basic red button" href="/account/bonus">收益记录</a>
                    </div>
                </div>
            </div>
@stop