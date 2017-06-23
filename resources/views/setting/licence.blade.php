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