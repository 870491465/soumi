@extends('layout.master')

@section('left-sidebar')

@stop

@section('top')
    @include('partials.child_top_siderbar_menu')
@stop
@section('main-content')
    <a href="/account/bring/create" class="ui full teal button">转账</a>
    @if(isset($brings))
        @foreach($brings as $bring)
            <div class="ui teal segment">
                <div class="ui gray divided list">
                    <div class="item">
                        <div class="right floated content">
                            <div class="meta">
                                <span class="header">收款金额:￥{!! $bring->amount !!}</span>
                            </div>
                        </div>
                        <div class="content">
                            <div class="header">收款账户：{!! $bring->account->person_name !!}</div>
                        </div>
                        <br>
                        <div class="content">
                            日期:{!! $bring->created_at !!}
                        </div>
                    </div>
                </div>
            </div>
        @endforeach
    @endif
    {{--   </tbody>
   </table>--}}
@stop