@extends('partials.master')

@section('content')

    <div class="head-description">
        <div class="ui horizontal list">
            <div class="item">
                <div class="content">
                    <h3>发布消息</h3>
                </div>
            </div>
            <div class="item">
                <a class="ui mini teal button openModal" href="javascript:void(0);"
                ><i class="add icon"></i>新增消息</a>
            </div>
        </div>
    </div>
    <table class="ui celled striped table userpage-content">
        <thead>
        <tr>
            <th class="center aligned">序号</th>
            <th class="center aligned">标题</th>
            <th class="center aligned">内容</th>
            <th class="center aligned">提交日期</th>
        </tr>
        </thead>
        <tbody>
        <?php $i = 1 ?>
        @foreach($messages as $message)
            <tr>
                <td class="one wide"><?php echo $i ?></td>
                <td class="four wide">{!! $message->title !!}</td>
                <td>{!! $message->content !!}</td>
                <td class="two wide">{!! $message->created_at !!}</td>
            </tr>
            <?php $i++ ?>
        @endforeach
        </tbody>
    </table>
    @include('admin.messages.create')
@stop