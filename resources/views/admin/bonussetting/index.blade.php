@extends('partials.master')

@section('content')
    <div class="head-description">
        <div class="ui horizontal list">
            <div class="item">
                <div class="content">
                    <h3>权益设置</h3>
                </div>
            </div>
            <div class="item">
                <a class="ui mini teal button openModal" href="javascript:void(0);"
                ><i class="add icon"></i>新增权益</a>
            </div>
        </div>
    </div>
    <div class="new-product-container">
        @foreach($bonus as $bonu)
        {!! Form::open(['url' => route('postBonusEdit', ['id' => $bonu->id]), 'class' => 'ui ajax form', 'id' => 'form'.$bonu->id]) !!}
            <div class="inline fields">
                <div class="two wide field">
                    <div class="ui labeled input">
                        <label class="ui label">名称</label>
                        <input type="text" name="name" value="{!! $bonu->name !!}" />
                    </div>
                </div>
                <div class="two wide field">
                    <select class="ui dropdown" name="primary_role">
                        @foreach($roles as $role)
                            <option value="{!! $role->id !!}"
                            @if($bonu->primary_role == $role->id)
                             selected
                            @endif
                            >{!! $role->display_name !!}</option>
                        @endforeach
                    </select>
                </div>
                <div class="two wide field">
                    <select class="ui dropdown" name="agent_role">
                        @foreach($roles as $role)
                            <option value="{!! $role->id !!}"
                                    @if($bonu->agent_role == $role->id)
                                    selected
                                    @endif
                            >{!! $role->display_name !!}</option>
                        @endforeach
                    </select>
                </div>
                <div class="two wide field">
                    <select class="ui dropdown" name="level">
                        @foreach($levels as $level)
                            <option value="{!! $level->level !!}"
                            @if($bonu->level == $level->level)
                            selected
                            @endif
                            >{!! $level->name !!}</option>
                        @endforeach
                    </select>
                </div>

                <div class="field">
                    <div class="ui right labeled input">
                        <input type="number" name="rate" value="{!! $bonu->rate * 100 !!}"/><label class="ui label">%</label>
                    </div>
                </div>

                <div class="field">
                    <div class="ui right labeled input">
                        <input type="number" value="{!! $bonu->fixed !!}" name="fixed"/>
                        <label class="ui label">￥</label>
                    </div>
                </div>
                <div class="one field">
                    <div class="ui mini buttons">
                        <button class="ui mini teal button" type="submit">修改</button>
                    </div>

                </div>
            </div>
        </form>
        @endforeach
    </div>
@include('admin.bonussetting.create')
@stop
