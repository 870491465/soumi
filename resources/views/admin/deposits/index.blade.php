@extends('partials.master')

@section('content')

    <div class="head-description">
        <div class="ui horizontal list">
            <div class="item">
                <div class="content">
                    <h3>充值审核</h3>
                </div>
            </div>
        </div>
    </div>
    <div class="new-product-container">
        {!! Form::open(['url' => '/admin/customer/search', 'class'=> 'ui mini form']) !!}
        <div class=" inline fields">
            <div class="field">
                <label>姓名：</label>
                <input type="text" name="name" />
            </div>
            <div class="field">
                <label>手机号:</label>
                <input type="text" name="mobile"/>
            </div>
            <div class="field">
                <label>公司名称:</label>
                <input type="text" name="business_name" />
            </div>
            <div class="field">
                <button class="ui icon teal button">
                    <i class="search icon"></i>
                    查询
                </button>
            </div>
        </div>

        {!! Form::close() !!}
    </div>
    <table class="ui celled striped table userpage-content">
        <thead>
        <tr>
            <th class="center aligned">序号</th>
            <th class="center aligned">姓名</th>
            <th class="center aligned">手机号</th>
            <th class="center aligned">公司名称</th>
            <th class="center aligned">充值金额</th>
            <th class="center aligned">升级类型</th>
            <th class="center aligned">状态</th>
            <th>操作</th>
            <th class="center aligned">提交日期</th>
        </tr>
        </thead>
        <tbody>
        <?php $i = 1 ?>
        @foreach($deposits as $deposit)
            <tr
                @if (isset($deposit->account->agent))
                    @if ($deposit->account->agent->primaryAccount->user->role_id < $deposit->upgrade_type_id)
                       class="error"
                    @endif
                @endif
            >
                <td><?php echo $i ?>
                    @if (isset($deposit->account->agent))
                        @if ($deposit->account->agent->primaryAccount->user->role_id < $deposit->upgrade_type_id)
                            <div class="ui ribbon label">上级代理级别不够</div>
                        @endif
                    @endif

                </td>
              {{--  <td>{!! $deposit->account->person_name !!}</td>
                <td>{!! $deposit->account->mobile !!}</td>
                <td>{!! $deposit->account->business_name !!}</td>--}}
                <td>{!! $deposit->amount !!}</td>
                <td>@if ($deposit->upgrade_type_id == 2)
                        服务商
                    @elseif ($deposit->upgrade_type_id == 3)
                        运营商
                    @endif
                </td>
                <td>
                    @if ($deposit->status_id == 2)
                        待审
                    @elseif ($deposit->status_id == 3)
                        成功
                    @elseif ($deposit->status_id == 4)
                        取消
                    @elseif ($deposit->status_id == 5)
                        失败
                    @endif
                </td>
                <td>
                    @if ($deposit->status_id == 2)
                        <a class="ui small button loadModal" href="javascript:void(0)" data-href="/admin/deposit/{!! $deposit->id !!}">审核</a>
                     @endif

                </td>
                <td>{!! $deposit->created_at !!}</td>
            </tr>
            @if (isset($deposit->account->agent))
                <tr>
                    <td  colspan="10">
                        <div class="ui horizontal bulleted list">
                            <div class="item">
                                上级代理:{!! $deposit->account->agent->primaryAccount->person_name !!}
                            </div>
                            <div class="item">
                                代理级别: @if ($deposit->account->agent->primaryAccount->user->role_id == 2)
                                    服务商
                                @elseif ($deposit->account->agent->primaryAccount->user->role_id == 3)
                                    运营商
                                @endif
                            </div>
                            <div class="item">
                                手机号:{!! ($deposit->account->agent->primaryAccount->user->mobile) !!}
                            </div>
                            <div class="item">
                                <a class="ui loadModal " href="javascript:void(0)"
                                   data-href="/admin/upgrade/sms?mobile={!! $deposit->account->agent->primaryAccount->user->mobile !!}
                                           &name={!! $deposit->account->agent->primaryAccount->user->name !!}
                                           &upgradename={!! $deposit->account->person_name !!}">
                                    短信通知</a>
                            </div>
                        </div>
                    </td>

                </tr>
            @endif
            <?php $i++ ?>
        @endforeach
        </tbody>
    </table>
@stop