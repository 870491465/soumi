<div class="ui four column center aligned grid">
        <div class="sixteen wide {!! session('color') !!} column">
            <h3 class="ui inverted header">{!! session('role_name') !!}管理前台</h3>
        </div>
            <div class="column">
                <a href="/account/customer">
                    <h5 class="ui icon {!! session('color') !!} header">
                        <i class="circular users icon"></i>
                        <div class="content">
                            商户管理
                        </div>
                    </h5>

                </a>
            </div>
            <div class="column" >
                <a  href="/account/bonus">
                    <h5 class="ui icon {!! session('color') !!} header">
                        <i class="circular pie chart icon"></i>
                        <div class="content">
                            我的权益
                        </div>
                    </h5>
                </a>
            </div>
            <div class="column">
                <a  href="/account/deposit">
                    <h5 class="ui icon {!! session('color') !!} header">
                        <i class="circular building icon"></i>
                        <div class="content">
                            充值记录
                        </div>
                    </h5>
                </a>
            </div>
            <div class="column">
                <a  href="/account/transfer">
                   <h5 class="ui icon {!! session('color') !!} header">
                       <i class="circular circular building outline icon"></i>
                       <div class="content">
                           提现记录
                       </div>
                   </h5>

                </a>
            </div>
    </div>

