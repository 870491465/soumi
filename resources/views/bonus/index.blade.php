@extends('layout.master')

@section('left-sidebar')

@stop

@section('top')
    @include('partials.child_top_siderbar_menu')
@stop
@section('main-content')
        @if(isset($bonuses))
        @foreach($bonuses as $bonus)
            <div class="ui gray divided list">
                <div class="item">
                    <div class="right floated content">
                        <div class="meta">
                            <span>发生人：{!! $bonus->childAccount->person_name !!}</span>
                        </div>
                    </div>
                    <div class="content">
                        <div class="header">权益金额:￥{!! $bonus->amount !!}</div>
                    </div>
                    <br>
                    <div class="content">
                        日期:{!! $bonus->created_at !!}
                    </div>
                </div>
                <div class="ui divider"></div>
            </div>

         @endforeach
         @endif
     {{--   </tbody>
    </table>--}}
@stop