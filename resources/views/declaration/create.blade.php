
<div class="ui small modal">
    <i class="close icon"></i>
    <div class="header">报单</div>
    <div class="content">
        {!! Form::open(['url' => '/account/declaration', 'method' => 'post', 'class' => 'ui ajax form', 'id' => 'form1']) !!}
        <div class="field">
            <label>报单金额:</label>
            {!! Form::number('amount') !!}
        </div>
        <input type="hidden" name="invoice_pic" id="invoice_pic" />
        <div class="field">
            <button class="ui icon teal button" type="submit"><i class="add icon"></i>提交</button>
        </div>
        {!! Form::close() !!}
        {!! Form::open(array('url' =>['/account/upload?type=license_pic'], 'method' => 'post', 'id'=>'imgForm', 'files'=>true, 'class' => 'ui form')) !!}
        <div class="field">
            <label>发票:</label>
            <input id="thumb" name="file" type="file"  required="required">

        </div>
        {!! Form::close() !!}
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
                    $('#invoice_pic').val(response.pic);
                }
            }

        })
    </script>
</div>