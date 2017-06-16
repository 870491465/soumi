@extends('partials.master')

@section('content')

    <div class="head-description">
        <div class="ui horizontal list">
            <div class="item">
                <div class="content">
                    <h3>系统设置</h3>
                </div>
            </div>
        </div>
    </div>
    <div class="new-product-container">
        <div class="ui grid">
            <div class="column">
                <div class="ui cards">
                    <div class="card">
                        <div class="content">
                            <a class="ui grey header " onclick="openChangePasswordModal()">
                               <i class="lock icon"></i> 修改密码
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script>
        function openChangePasswordModal()
        {
            $('#password').modal('show');
        }
        function openChangeMobileModal()
        {
            $('#mobile').modal('show');
        }
    </script>
    @include('setting.update_pssword')
    @include('setting.update_mobile')
@stop