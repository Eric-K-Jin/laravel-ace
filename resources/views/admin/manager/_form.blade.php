<div class="form-group">
    <label for="tag" class="col-md-3 control-label">管理员名称</label>
    <div class="col-md-5">
        <input type="text" class="form-control" name="username" id="username" value="{{$username}}" autofocus>
    </div>
</div>
<div class="form-group">
    <label for="tag" class="col-md-3 control-label">管理员实名</label>
    <div class="col-md-5">
        <input type="text" class="form-control" name="realname" id="realname" value="{{$realname}}" autofocus>
    </div>
</div>

<div class="form-group">
    <label for="tag" class="col-md-3 control-label">管理员状态</label>
    <div class="col-md-5">
        <input type="radio" class="form-group-sm" name="status"  value="0" {{$status==0?"checked":""}}>锁定 &nbsp;
        <input type="radio" class="form-group-sm" name="status"  value="1" {{$status==1?"checked":""}}>开启
    </div>
</div>

<div class="form-group">
    <label for="tag" class="col-md-3 control-label">管理员密码</label>
    <div class="col-md-5">
        <input type="password" class="form-control" name="password" id="tag" value="" autofocus>
    </div>
</div>

<div class="form-group">
    <label for="tag" class="col-md-3 control-label">密码确认</label>
    <div class="col-md-5">
        <input type="password" class="form-control" name="password_confirmation" id="tag" value="" autofocus>
    </div>
</div>


<div class="form-group">
    <label for="tag" class="col-md-3 control-label">所属组列表</label>
    @if(isset($username)&&$username=="admin")
        <div class="col-md-4" style="float:left;padding-left:20px;margin-top:8px;"><h2>超级管理员</h2></div>
    @else
        <div class="col-md-6">
            @foreach($rolesAll as $v)
                <div class="col-md-4" style="float:left;padding-left:20px;margin-top:8px;">
            <span class="checkbox-custom checkbox-default">
                <i class="fa"></i>
                    <input class="form-actions"
                           @if(in_array($v['id'],$roles))
                           checked
                           @endif
                           id="inputChekbox{{$v['id']}}" type="Checkbox" value="{{$v['id']}}"
                           name="roles[]"> <label for="inputChekbox{{$v['id']}}">
                    {{$v['name']}}
                </label> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
            </span>
                </div>
            @endforeach
        </div>
    @endif

</div>