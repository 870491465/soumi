@extends('layout.master')

@section('left-sidebar')

@stop

@section('top')
    @include('partials.child_top_siderbar_menu')
@stop
@section('main-content')
    <div class="ui grid">
        <div class="column">
            {!! Form::open(['url' => '/account/transfer', 'method' => 'post', 'class' => 'ui ajax form', 'id' => 'form1']) !!}
            <div class="field">
                <label>账户余额:</label>
                <div class="ui disabled icon input">
                    <i class="money icon"></i>
                    <input type="text" value="{!! isset($account->balance) ? $account->balance->amount : 0 !!}" name="available">
                </div>
            </div>
            <div class="field">
                <label>提现金额：</label>
                {!! Form::number('amount') !!}
            </div>
            <div class="field">
                <label>银行账户:</label>
                <select class="ui dropdown" name="account_bank_id">
                    <option value="">选择银行账户</option>
                    @if (isset($account->bank))
                    <option value="{!! $account->bank->id !!}">[{!! $account->bank->bank_name !!}]{!! $account->bank->card_no !!}</option>
                    @endif
                </select>
            </div>
            <div class="field">
                <button type="submit" class="ui teal button">提交 </button
            </div>
            {!! Form::close() !!}
        </div>
    </div>

@stop