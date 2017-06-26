<div class="ui large modal">
    <i class="close icon"></i>
    <div class="header">消息发布</div>
    <div class="content">
        {!! Form::open(array('url' => '/admin/message/create', 'class' =>'ui form ajax')) !!}
            <div class="field">
                <div class="ui labeled input">
                    <label class="ui label">标题</label>
                    <input type="text" name="title" maxlength="20" />
                </div>
            </div>
            <div class="field">
                <div class="ui labeled input">
                    <label class="ui label">内容</label>
                    <textarea name="content" rows="5" maxlength="300">

                    </textarea>
                </div>
            </div>
            <div class="field">
                <button class="ui mini teal button" type="submit">发布</button>
            </div>
        </form>
    </div>
    <div class="actions">
        <div class="ui black deny button">
            关闭
        </div>
    </div>
</div>
