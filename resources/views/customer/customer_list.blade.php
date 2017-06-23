<div class="ui icon secondary vertical pointing menu">
    @foreach($customers as $customer)
        <a href="/account/customer/{!! $customer->child_id !!}" class="item">
            {!! $customer->account->person_name!!}
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
        </a>

    @endforeach
</div>
