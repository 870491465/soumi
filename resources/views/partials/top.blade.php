<div class="ui teal inverted menu">
    <a class="item" id="sidebar_menu">
            <i class="sidebar icon"></i>
            Menu
    </a>
    <div class="item">
        <h2 class="ui inverted header">
            <i class="user icon"></i>
            <div class="content">
                江苏嗖米网络
                <div class="sub header">--商户权益系统</div>
            </div>
        </h2>
    </div>
    <div class="ui right teal  inverted menu">
        <div class="item"><h5 class="ui inverted header">{!! session('username') !!}[{!! session('role_name') !!}]</h5></div>
        <div class="item"><h3><a href="/logout"><i class="power icon"></i></a></h3></div>
    </div>
</div>