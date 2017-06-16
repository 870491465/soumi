@extends('partials.master')

@section('content')

    <div class="head-description">
        <div class="ui horizontal list">
            <div class="item">
                <div class="content">
                    <h3>账户余额</h3>
                </div>
            </div>
        </div>
    </div>
    <div class="new-product-container">
        <div class="ui grid">
            <div class="column">
        <div class="ui cards">
            <div class="card">
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
        </div>
            </div>
        </div>
    </div>
    @include('transfer.create')
@stop