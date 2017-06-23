@extends('layout.master')

@section('left-sidebar')

@stop

@section('top')
    @include('partials.child_top_siderbar_menu')
@stop
@section('main-content')
    <div class="ui grid">
        <div class="column">
            {!! Form::open(['url' => '/account/bank', 'method' => 'post', 'class' => 'ui ajax form', 'id' => 'form1']) !!}
            <div class="field">
                <div class="two fields">
                    <div class="field">
                        <label>开户名:</label>
                        <input type="text" name="person_name" value="{!! $account->person_name !!}" placeholder="姓名">
                    </div>
                    <div class="field">
                        <lable>卡号:</lable>
                        <input type="text" name="card_no" value="{!! isset($account->bank->card_no) ? $account->bank->card_no : '' !!}">
                    </div>
                </div>
            </div>
            <div class="filed">
                <div class="two fields">
                    <div class="field">
                        <lable>所属银行:</lable>
                        <select class="ui fluid dropdown" name="bank_name">
                            <option value="">选择所属银行</option>
                            @foreach($banks as $bank)
                                <option value="{!! $bank->name !!}"
                                @if(isset($account->bank->bank_name))
                                    @if($account->bank->bank_name == $bank->name)
                                        selected
                                    @endif
                                @endif
                                >{!! $bank->name !!}</option>
                            @endforeach
                         </select>
                    </div>
                    <div class="field">
                        <lable>开户行</lable>
                        <input type="text" name="open_point" value="{!! isset($account->bank->open_point) ? $account->bank->open_point : ''!!}" placeholder="××银行-××分行">
                    </div>
                </div>
            </div>
            <input type="hidden" name="_token" value="{{ csrf_token() }}" />
            <div class="field">
                <button type="submit" class="ui teal button">提交</button>
            </div>
            {!! Form::close() !!}
        </div>
    </div>
@stop