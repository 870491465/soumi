@extends('partials.master')
@section('content')
    <div class="head-description">
        <div class="ui horizontal list">
            <div class="item">
                <div class="content">
                    <h3>提现记录</h3>
                </div>
            </div>
            <div class="item">
                <div class="content">
                    {!! Form::open(['url' => '/admin/transfer/export', 'method' => 'post']) !!}
                    <button class="ui small button" type="submit">导出可提现记录</button>
                    {!! Form::close() !!}
                </div>
            </div>
            <div class="item">
                <div class="content">
                    {!! Form::open(['url' =>'/admin/transfer/success', 'class' => 'ui form ajax']) !!}
                    <button class="ui mini positive button" type="submit">完成今日提现</button>
                    {!! Form::close() !!}
                </div>
            </div>
        </div>
    </div>
    <div class="new-product-container">
        {!! Form::open(['url' => '/admin/transfer/search', 'class'=> 'ui mini form']) !!}
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
            <th>序号</th>
            <th>姓名</th>
            <th>级别</th>
            <th>手机号</th>
            <th>取款金额</th>
            <th>取款信息</th>
            <th>状态</th>
            <th>操作</th>
            <th>提交日期</th>
        </tr>
        </thead>
        <tbody>
        <?php $i = 1 ?>
        @foreach($transfers as $transfer)
            {!! Form::open(['url' => '/admin/transfer/update/'. $transfer->account_id .'/'.$transfer->id, 'class' => 'ui form ajax']) !!}
            <tr
                @if($transfer->account->user->role_id == 3 || $transfer->account->user->role_id == 4)
                    @if(\Carbon\Carbon::now()->diffInDays($transfer->created_at) >= 1
                        && $transfer->status_id == \App\Models\TransferStatus::PENDING)
                        class="warning"
                    @endif
                @elseif(\Carbon\Carbon::now()->diffInDays($transfer->created_at) >= 15 && $transfer->status_id == \App\Models\TransferStatus::PENDING)
                    class="warning"
                @endif
            >
                <td><?php echo $i ?></td>
                <td>{!! $transfer->account->person_name !!}</td>
                <td> @if ($transfer->account->user->role_id ==1)
                        免费用户
                     @elseif($transfer->account->user->role_id ==2)
                        服务商
                     @elseif($transfer->account->user->role_id ==3)
                        运营商
                     @elseif($transfer->account->user->role_id ==4)
                        分公司
                     @endif
                </td>
                <td>{!! $transfer->account->mobile !!}</td>
                <td>{!! $transfer->amount !!}</td>
                <td>
                    <div class="ui list">
                        <div class="item">
                            <div class="content">
                                卡号:{!! $transfer->bankInfo->card_no!!}
                            </div>
                        </div>
                        <div class="item">
                            <div class="content">
                                银行:{!! $transfer->bankInfo->bank_name !!}
                            </div>
                        </div>
                        <div class="item">
                            <div class="content">
                                开户网点:{!! $transfer->bankInfo->open_point !!}
                            </div>
                        </div>
                    </div>
                </td>
                <td>
                    {!! $transfer->status->display_name !!}
                </td>
                <td><button type="submit" class="ui teal button {!! $transfer->status_id == 3 ? 'disabled' : '' !!}">完成</button></td>
                <td>{!! $transfer->created_at !!}</td>
            </tr>
            {!! Form::close() !!}
            <?php $i++ ?>
        @endforeach
        </tbody>
        @if(isset($transfer->links))
        <tfoot>
        <tr>
            <th>{!! $transfer->links() !!}</th>
        </tr>
        </tfoot>
        @endif
    </table>
@stop