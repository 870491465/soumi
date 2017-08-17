@extends('partials.master')

@section('content')

    <div class="head-description">
        <div class="ui horizontal list">
            <div class="item">
                <div class="content">
                    <h3>商户权益</h3>
                </div>
            </div>
        </div>
    </div>
    <div class="new-product-container">
        {!! Form::open(['url' => '/admin/bonus/search', 'class'=> 'ui mini form']) !!}
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
            <th class="center aligned">权益金额</th>
            <th class="center aligned">发生人</th>
            <th class="center aligned">发生金额</th>
            <th class="center aligned">提交日期</th>
        </tr>
        </thead>
        <tbody>
        <?php $i = 1 ?>
        @foreach($bonus as $bonu)
            <tr>
                <td class="center aligned"><?php echo $i ?></td>
                <td class="center aligned">{!! $bonu->account->person_name !!}</td>
                <td class="center aligned">{!! $bonu->account->mobile !!}</td>
                <td class="center aligned">{!! $bonu->amount !!}</td>
                <td class="center aligned">{!! $bonu->childAccount->person_name !!}</td>
                <td class="center aligned">{!! $bonu->paid_amount !!}</td>
                <td class="center aligned">{!! $bonu->created_at !!}</td>
            </tr>
            <?php $i++ ?>
        @endforeach
        </tbody>
        @if(method_exists($bonus, 'links'))
            <tfoot>
            <tr>
                <th colspan="7">{!! $bonus->links()!!}</th>
            </tr>
            </tfoot>
        @endif
    </table>
@stop