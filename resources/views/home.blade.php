@extends('partials.master')

@section('content')
    <div class="head-description">
        <h3></h3>
    </div>
    <div class="new-product-container">
        <form class="ui form" id="form2" method="post" action="/api/upload/image" enctype="multipart/form-data" >
            <div class="fields">
                <div class="five wide fields">
                    <div class="twelve wide field">
                        <label for="input-file-now">课程图片</label>
                        <input type="file" id="uploadFile" name="file">
                        <div class="ui teal progress" id="example2">
                            <div class="bar"></div>
                            <div class="label"></div>
                        </div>
                    </div>
                    <div class="four wide field">
                        <input type="submit" value="上传">
                    </div>
                </div>
                <div class="six left aligned  field">

                </div>
            </div>
        </form>
        <form class="ui form" id="form1">
            <div class="field add-col-width">
                <div class="tow fields">
                    <div class="required field">
                        <label>课程名称</label>
                        <input  type="text" id="name" name="name" placeholder="课程名称">
                    </div>
                    <div class="required field">
                        <label>价格</label>
                        <div class="ui labeled input">
                            <div class="ui blue label">￥</div>
                            <input type="text" name="price" placeholder="">
                        </div>

                    </div>
                </div>

            </div>
            <div class="field add-col-width">

            </div>
            <div class="field add-col-width">
                <label>是否免费</label>
                <div class="ui toggle checkbox">
                    <input type="checkbox" name="isfree"  />
                    <label></label>
                </div>
            </div>
            <div class="field add-col-width">

               <textarea id="editor" name="summary">
                </textarea>
            </div>
            <div class="field add-col-width">
                <div class="ui submit button">新增</div>
            </div>
            <input type="hidden" name="_token" value="{{ csrf_token() }}" />
            <input type="hidden" name="logo" id="logo"/>
        </form>
    </div>
@stop