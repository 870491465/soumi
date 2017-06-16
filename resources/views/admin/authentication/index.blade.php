@extends('partials.master')

@section('content')

    <div class="head-description">
        <div class="ui horizontal list">
            <div class="item">
                <div class="content">
                    <h3>实名认证审核</h3>
                </div>
            </div>
        </div>
    </div>

    <table class="ui celled striped table userpage-content">
        <thead>
        <tr>
            <th>序号</th>
            <th>姓名</th>
            <th>身份证</th>
            <th>手机号</th>
            <th>公司名称</th>
            <th>详情</th>
            <th>操作</th>
            <th>提交日期</th>
        </tr>
        </thead>
        <tbody>
        <?php $i = 1 ?>
        @foreach($accounts as $account)
            <tr>
                <td><?php echo $i ?></td>
                <td>{!! $account->person_name !!}</td>
                <td>{!! $account->license_no !!}</td>
                <td>{!! $account->mobile !!}</td>
                <td>{!! $account->business_name !!}</td>
                <td><a href="javascript:void(0);" data-modal-id="EditAttendee"
                       class="loadModal ui mini teal icon button"
                       data-href="{!! route('getCustomer', ['id' => $account->id]) !!}">
                        <i class="browser icon"></i>详情</a></td>
                <td>
                    <div class="ui mini buttons">
                        {!! Form::open(array('url' => route('postAuthentication', ['id' => $account->id, 'status' =>1]),
                        'class' => 'ui form ajax', 'id' => 'form'. $account->id)) !!}
                        <button class="ui mini button " type="submit">不通过</button>
                        {!! Form::close() !!}
                        <div class="or"></div>
                        {!! Form::open(array('url' => route('postAuthentication', ['id' => $account->id, 'status' =>2]),
                        'class' => 'ui ajax form', 'id' => 'form'. $account->id)) !!}
                        <button class="ui mini positive button">通过</button>
                        {!! Form::close() !!}
                    </div>
                </td>
                <td>{!! $account->created_at !!}</td>
            </tr>
            <?php $i++ ?>
        @endforeach
        </tbody>
    </table>
    @include('admin.authentication.detail')
@stop