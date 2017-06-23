@extends('layout.master')

@section('left-sidebar')

@stop

@section('top')
    @include('partials.child_top_siderbar_menu')
@stop
@section('main-content')
    <div class="ui grid">
        <div class="column">
            <div class="ui middle aligned divided list">
                <div class="item">
                    <div class="right floated content">
                        <i class="ui chevron right icon"></i>
                    </div>
                    <div class="content">
                        <div class="header"><i class="ui user icon"></i>个人信息</div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="ui divider"></div>
    <div class="ui grid">
        <div class="column">
            <div class="ui middle aligned divided list">
                <a class="item" href="/account/profile">
                    <div class="right floated content">
                        <i class="ui chevron right icon"></i>
                    </div>
                    <a class="content" href="/account/bank">
                        <div class="header"><i class="ui university icon"></i>银行账户</div>
                    </a>
                </a>
            </div>
        </div>
    </div>
@stop
