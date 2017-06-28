@extends('partials.master')

@section('content')

    <div class="head-description">
        <div class="ui horizontal list">
            <div class="item">
                <div class="content">
                    <h3>系统设置</h3>
                </div>
            </div>
        </div>
    </div>
    <div class="new-product-container">
        <div class="ui cards">
            <div class="card">
                <div class="content">
                    <a href="javascript:void(0)" data-href="/admin/setting/update/password" class="ui button loadModal">修改密码</a>
                </div>
            </div>
            <div class="card">
                <div class="content">
                    <a href="javascript:void(0)" data-href="/admin/setting/smscontent" class="ui button loadModal">修改短信内容</a>
                </div>
            </div>
            <div class="card">
                <div class="content">
                    <a href="javascript:void(0)" data-href="/admin/setting/depositamount" class="ui button loadModal">修改充值金额</a>
                </div>
            </div>
        </div>
    </div>

@stop