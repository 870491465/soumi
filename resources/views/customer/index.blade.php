@extends('partials.master')

@section('content')
    <div class="head-description">
        <div class="ui horizontal list">
            <div class="item">
                <div class="content">
                    <h3>客户列表</h3>
                </div>
            </div>
            <div class="item">
                <a class="ui mini teal button openModal" href="javascript:void(0);"
                        ><i class="add icon"></i>新增客户</a>
            </div>
        </div>
    </div>
    <table class="ui celled striped table userpage-content">
        <tr class="">
            <td class="two top aligned center floated wide">
                <div class="ui animated list">
                    @foreach($customers as $customer)
                    <div class="item">
                        <i class="user icon"></i>
                        <div class="content">
                            <div><a href="/account/customer/{!! $customer->child_id !!}">{!! $customer->account->person_name!!}</a>
                                [{!! $customer->account->user->role->display_name !!}]</div>
                        </div>
                    </div>
                    @endforeach
                </div>
            </td>
            <td class="ten wide">
                <form class="ui form form-horizontal">
                    <div class="field">
                        <div class="two fields">
                            <div class="field">
                                <label>姓名:</label>
                                <div class="ui disabled input">
                                    <input type="text" name="person_name" value="{!! isset($account) ? $account->person_name : '' !!}" placeholder="姓名">
                                </div>
                            </div>
                            <div class="field">
                                <label>公司名称</label>
                                <div class="ui disabled input">
                                    <input type="text" name="business_name" value="{!! isset($account) ? $account->business_name : '' !!}" placeholder="Last Name">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="filed">
                        <div class="two fields">
                            <div class="field">
                                <lable>手机号:</lable>
                                <div class="ui disabled input">
                                 <input type="text" name="mobile" value="{!! isset($account) ? $account->mobile : '' !!}">
                                </div>
                            </div>
                            <div class="field">
                                <label>公司营业执照编号:</label>
                                <div class="ui disabled input">
                                <input type="text" name="license_no" value="{!! isset($account) ? $account->license_no : '' !!}">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="filed">
                        <div class="two fields">
                            <div class="field disabled">
                                <lable>性别:</lable>
                                <input type="radio" name="person_sex" value="1"
                                    @if(isset($account))
                                        {!! $account->person_sex == 1 ? 'checked' : '' !!}
                                    @endif
                                >男
                                <input type="radio" name="person_sex" value="0"
                                @if(isset($account))
                                    {!! $account->person_sex == 0 ? 'checked' : '' !!}

                                        @endif
                                >女
                            </div>
                            <div class="field">
                            </div>
                        </div>
                    </div>
                    <div class="filed">
                        <div class="two fields">
                            <div class="field">
                                <lable>身份证号:</lable>
                                <div class="ui disabled input">
                                <input type="text" name="identity_card" value="{!! isset($account) ? $account->identity_card : '' !!}" checked>
                                </div>
                            </div>
                            <div class="field">
                            </div>
                        </div>
                    </div>
                    <div class="filed">
                        <div class="two fields">
                            <div class="field">
                                <lable>身份证照片:</lable>
                                @if(isset($account))
                                <img src="{!! $account->identity_card_pic !!}" />
                                @endif
                            </div>
                            <div class="field">
                                <lable>营业执照照片:</lable>
                                @if(isset($account))
                                <img class="ui medium rounded image" src="{!! $account->license_pic !!}" />
                                @endif
                            </div>
                        </div>
                    </div>
                </form>
            </td>
        </tr>
    </table>

@stop
@section('modal')
@include('customer.create')
    <script>
        $('.ui.modal').modal();
        function openModal(){
            $('.ui.modal').modal('show');
        }
    </script>

@stop
