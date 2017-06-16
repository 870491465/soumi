@extends('partials.master')

@section('content')
    <div class="head-description">
        <div class="ui horizontal list">
            <div class="item">
                <div class="content">
                    <h3>实名认证</h3>
                </div>
            </div>
            @if($account->status ==2)
            <div class="item">
                <a class="ui mini teal button openModal" href="javascript:void(0);"
                ><i class="add icon"></i>银行卡信息</a>
            </div>
            @endif
        </div>
    </div>
    <div class="new-product-container">
        <form class="ui form ajax form-horizontal" action="/account/customer/edit/{!! $account->id !!}" method="post">
            <h4 class="ui horizontal divider header">
                <i class="user icon"></i>
                个人信息
            </h4>
            <div class="field">
                <div class="two fields">
                    <div class="field">
                        <label>姓名:</label>
                        <input type="text" name="person_name" value="{!! isset($account) ? $account->person_name : '' !!}" placeholder="姓名">
                    </div>
                    <div class="field">
                        <lable>手机号:</lable>
                        <input type="text" name="mobile" value="{!! isset($account) ? $account->mobile : '' !!}">
                    </div>

                </div>
            </div>
            <div class="filed">
                <div class="two fields">
                    <div class="field">
                        <lable class="">性别:</lable>
                        <input type="radio" name="person_sex" value="1"
                        @if(isset($account))
                            {!! $account->person_sex == 1 ? 'checked' : '' !!}
                                @endif
                        >男
                        <input type="radio" name="person_sex" value="0"
                        @if(isset($account))
                            {!! $account->person_sex == 0 ? 'checked' : '' !!}

                                @endif
                        >女
                    </div>
                    <div class="field">
                        <lable>身份证号:</lable>
                        <input type="text" name="identity_card" value="{!! isset($account) ? $account->identity_card : '' !!}" checked>
                    </div>
                </div>
            </div>
            <h4 class="ui horizontal divider header">
                <i class="university icon"></i>公司信息
            </h4>
            <div class="filed">
                <div class="two fields">
                    <div class="field">
                        <label>公司名称</label>
                        <input type="text" name="business_name" value="{!! isset($account) ? $account->business_name : '' !!}" placeholder="Last Name">
                    </div>
                    <div class="field">
                        <label>公司营业执照编号:</label>
                        <input type="text" name="license_no" value="{!! isset($account) ? $account->license_no : '' !!}">
                    </div>
                </div>
            </div>

            <input type="hidden" name="_token" value="{{ csrf_token() }}" />
            <input id="license_pic"  type="hidden" name="license_pic" value="{!! $account->license_pic !!}">
            <input id="identity_card_pic"  type="hidden" name="identity_card_pic" value="{!! $account->identity_card_pic !!}">
            <div class="field add-col-width">
                <button class="ui teal button
                @if($account->status == 1 || $account->status ==2)
                    disabled
                @endif"
                >
                    @if($account->status == 0)
                        提交
                    @elseif($account->status == 1)
                        待审核
                    @elseif($account->status == 2)
                        通过
                    @elseif($account->status == 3)
                        未通过重新提交
                    @endif
                </button>
            </div>
            </form>
            <h4 class="ui horizontal divider header"><i class="tag icon"></i>附件</h4>
            @if(isset($account->identity_card_pic))
            <div class="filed">
                <div class="two fields">
                    <div class="field">
                        <lable>身份证照片:</lable>
                        @if(isset($account))
                            <img class="ui small rounded image" src="{!! $account->identity_card_pic !!}" />
                        @endif
                    </div>
                    <div class="field">
                        <lable>营业执照照片:</lable>
                        @if(isset($account))
                            <img class="ui small rounded image" src="{!! $account->license_pic !!}" />
                        @endif
                    </div>
                </div>
            </div>
            @else
                <div class="filed">
                    <div class="two fields">
                        {!! Form::open( array('url' =>['/account/upload?type=license_pic'], 'method' => 'post', 'id'=>'imgForm', 'files'=>true, 'class' => 'ui form') ) !!}
                        <div class="field">
                            <label>身份证:</label>
                            <input id="thumb" name="file" type="file"  required="required">
                        </div>
                        {!!Form::close()!!}
                        {!! Form::open( array('url' =>['/account/upload?type=identity_card_pic'], 'method' => 'post', 'id'=>'imgForm2', 'files'=>true, 'class' => 'ui form') ) !!}
                        <div class="field">
                            <label>营业执照:</label>
                            <input id="file2" name="file" type="file"  required="required">
                        </div>
                        {!!Form::close()!!}
                    </div>
                </div>
            @endif
    </div>
    @include('bank.index')
    <script>
        $(function(){
            //上传图片相关

            $('.upload-mask').on('click',function(){
                $(this).hide();
                $('.upload-file').hide();
            })

            $('.upload-file .close').on('click',function(){
                $('.upload-mask').hide();
                $('.upload-file').hide();
            })

            var imgSrc = $('.pic-upload').next().attr('src');
            console.log(imgSrc);
            if(imgSrc == ''){
                $('.pic-upload').next().css('display','none');
            }
            $('.pic-upload').on('click',function(){
                $('.upload-mask').show();
                $('.upload-file').show();
                console.log($(this).next().attr('id'));
                var imgID = $(this).next().attr('id');
                $('#imgID').attr('value',imgID);
            })


            //ajax 上传
            $(document).ready(function() {
                var options = {
                    beforeSubmit:  showRequest,
                    success:       showResponse,
                    dataType: 'json'
                };
                $('#imgForm input[name=file]').on('change', function(){
                    //$('#upload-avatar').html('正在上传...');
                    $('#imgForm').ajaxForm(options).submit();
                });
                $('#file2').on('change', function(){
                    //$('#upload-avatar').html('正在上传...');
                    $('#imgForm2').ajaxForm(options).submit();
                });
            });

            function showRequest() {
                $("#validation-errors").hide().empty();
                $("#output").css('display','none');
                return true;
            }

            function showResponse(response)  {
                if(response.success == false)
                {
                    var responseErrors = response.errors;
                    $.each(responseErrors, function(index, value)
                    {
                        if (value.length != 0)
                        {
                            $("#validation-errors").append('<div class="alert alert-error"><strong>'+ value +'</strong><div>');
                        }
                    });
                    $("#validation-errors").show();
                } else {
                    alert('上传成功');
                    if(response.type == 'identity_card_pic') {
                        $('#identity_card_pic').val(response.pic);
                    } else {
                        $('#license_pic').val(response.pic);
                    }
                }
            }

        })
    </script>
@stop