<div class="ui inverted icon left  vertical sidebar menu uncover" id="left_sidebar">
    @foreach($customers as $customer)
        <i class="user icon"></i>
        <a href="/account/customer/{!! $customer->child_id !!}" class="item">
            {!! $customer->account->person_name!!}
        </a>
        [
        @if ($customer->account->user->role_id == 1)
            免费用户
        @elseif($customer->account->user->role_id == 2)
            服务商
        @elseif($customer->account->user->role_id == 3)
            运营商
        @elseif($customer->account->user->role_id == 4)
            分公司
        @endif
        ]
    @endforeach
</div>

@section('script')
    <script>
        $(document).ready(function(){
            $('#left_sidebar').sidebar('show');
        })
    </script>
@stop