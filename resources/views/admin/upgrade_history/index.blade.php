@extends('partials.master')

@section('content')
    <div class="head-description">
        <div class="ui horizontal list">
            <div class="item">
                <div class="content">
                    <h3>升级历史</h3>
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
            <th class="center aligned">身份证</th>
            <th class="center aligned">手机号</th>
            <th class="center aligned">原有级别</th>
            <th class="center aligned">现在级别</th>
            <th class="center aligned">升级日期</th>
        </tr>
        </thead>
        <tbody>
        <?php $i = 1 ?>
        @foreach($upgrade_historys as $upgrade_history)
            <tr>
                <td class="center aligned"><?php echo $i ?></td>
                <td class="center aligned">{!! $upgrade_history->account->person_name !!}</td>
                <td class="center aligned">{!! $upgrade_history->account->license_no !!}</td>
                <td class="center aligned">{!! $upgrade_history->account->mobile !!}</td>
                <td class="center aligned">@if($upgrade_history->before_role == 2)
                        服务商
                    @elseif($upgrade_history->before_role == 3)
                        运营商
                    @elseif($upgrade_history->before_role == 4)
                        分公司
                    @endif
                </td>
                <td class="center aligned">
                    @if($upgrade_history->after_role == 2)
                        服务商
                    @elseif($upgrade_history->after_role == 3)
                        运营商
                    @elseif($upgrade_history->after_role == 4)
                        分公司
                    @endif
                </td>
                <td class="center aligned">{!! $upgrade_history->created_at !!}</td>
            </tr>
            <?php $i++ ?>
        @endforeach
        </tbody>
    </table>
@stop