@extends('layout.master')

@section('left-sidebar')

@stop

@section('top')
    @include('partials.child_top_siderbar_menu')
@stop
@section('main-content')
    <div class="ui grid">
        <div class="column">

            {!! Form::open(['url' =>'/account/bring/create', 'class' => 'ui form ajax']) !!}
            <div class="field disabled">
                <label>账户余额:</label>
                <input type="text" name="person_name" value="{!! isset($balance) ? $balance->amount : 0 !!}" placeholder="账户余额">
            </div>
            <div class="field">
                <label>金额</label>
                <input type="number" name="amount" placeholder="请输入转账金额"/>
            </div>
            <div class="field">
                <label>收款账户</label>
                <select class="ui fluid search  dropdown" name="collection_account">
                    <option value="">请选收款账户</option>
                    @foreach($accounts as $account2)
                        <option value="{!! $account2->account->id !!}">
                            {!! $account2->account->person_name !!}[{!! $account2->account->mobile !!}]
                        </option>
                    @endforeach
                </select>
            </div>
            <div class="field add-col-width">
                <button class="ui teal button" type="submit">
                    转账
                </button>
            </div>
            <input type="hidden" name="before_agent" value="{!! isset($customer->primaryAccount) ? $customer->primaryAccount->id : '' !!}" />
            <input type="hidden" name="account_id" value="{!! $account->id !!}" />
            {!! Form::close() !!}
        </div>
    </div>
@stop