@extends('partials.master')

@section('content')

    <div class="head-description">
        <div class="ui horizontal list">
            <div class="item">
                <div class="content">
                    <h3>升级服务通道</h3>
                </div>
            </div>
            <div class="item">
                <a class="ui mini teal button openModal" href="javascript:void(0);"
                ><i class="add icon"></i>升级</a>
            </div>
        </div>
    </div>

    <table class="ui celled striped table userpage-content">
        <thead>
        <tr>
            <th class="one wide">序号</th>
            <th class="three wide">类型</th>
            <th class="three wide">状态</th>
            <th class="two wide">操作</th>
            <th class="three wide">日期</th>
        </tr>
        </thead>
        <tbody>
        <?php $i=1 ?>
        @foreach($upgrades as $grade)
        <tr>
            <td class="one wide"><?php echo $i ?></td>
            <td class="three wide">{!! $grade->type->name !!}</td>
            <td class="three wide">
                @if($grade->status == 0)
                    待充值
                @elseif($grade->status == 2)
                    已充值
                @elseif($grade->status == 1)
                    取消
                @endif

            </td>
            <td class="two wide">
                {!! Form::open(['url' => '/account/deposit', 'method' => 'post']) !!}
                <button class="ui mini secondary button
                @if($grade->status == 2)
                        disabled
                @endif
                        ">
                    <i class="yen icon"></i>充值</button>
                <input type="hidden" value="{!! $grade->id !!}" name="upgrade_id" />
                {!! Form::close() !!}
            </td>
            <td class="three wide">{!! $grade->created_at !!}</td>
        </tr>
            <?php $i++ ?>
        @endforeach
        </tbody>
    </table>
    @include('upgrade.create')
@stop