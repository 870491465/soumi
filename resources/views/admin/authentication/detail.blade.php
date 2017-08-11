<div class="ui small modal">
    <i class="close icon"></i>
    <div class="header">商户详情</div>
    <div class="content">
        {!! Form::open(['url' => '/admin/customer/update/'. $account->id, 'class' => 'ui form ajax form-horizontal', 'method' => 'post']) !!}
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
            <div class="field">
                <label>sig</label>
                <input type="text" name ="sig" value="{!! $sig !!}" />
            </div>
            <input type="hidden" name="_token" value="{{ csrf_token() }}" />
            <input id="license_pic"  type="hidden" name="license_pic" value="{!! $account->license_pic !!}">
            <input id="identity_card_pic"  type="hidden" name="identity_card_pic" value="{!! $account->identity_card_pic !!}">
            <div class="field add-col-width">
                <button class="ui teal button" type="submit">
                    编辑
                </button>
            </div>
        {!! Form::close() !!}
        <h4 class="ui horizontal divider header"><i class="tag icon"></i>附件</h4>
            <div class="filed">
                <div class="two fields">
                    <div class="field">
                        <lable>身份证照片:</lable>
                        @if(isset($account))
                            <img class="ui large rounded image" src="{!! $account->identity_card_pic !!}" />
                        @endif
                    </div>
                    <div class="field">
                        <lable>营业执照照片:</lable>
                        @if(isset($account))
                            <img class="ui large rounded image" src="{!! $account->license_pic !!}" />
                        @endif
                    </div>
                </div>
            </div>
        <h4 class="ui horizontal divider header"><i class="tag icon"></i>上传附件</h4>
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
    </div>
    <div class="actions">
        <div class="ui black deny button">
            关闭
        </div>
    </div>

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
</div>
