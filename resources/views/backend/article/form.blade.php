@extends('backend.layouts.main')

@section('title')
    文章表单
@endsection

@section('breadcrumb')
    文章表单
@endsection

@section('content')
    <form action="{{ url('article/save') }}" method="post"  class="form-horizontal container-fluid page-content">
        @csrf
        <div class="form-group">
            <label class="col-lg-1 control-label no-padding-right" for="title"  title="Heading">标题：</label>
            <div class="col-lg-6">
                <input type="text" id="title" name="title" value="@if(isset($data->title)) {{$data->title}} @endif" class="form-control" required>
            </div>
            <span class="red">*</span>
        </div>
        <div class="space-4"></div>
        <div class="form-group">
            <label class="col-lg-1 control-label no-padding-right" for="link" title="link" nowrap >网址：</label>
            <div class="col-lg-6">
                <input type="text" id="link" name="link" value="@if(isset($data->link)) {{$data->link}} @endif"  style='font-family:verdana' class="form-control" />
            </div>
        </div>
        <div class="space-4"></div>
        <div class="form-group">
            <label class="col-lg-1 control-label no-padding-right" >属性：</label>
            <div class="col-lg-6">
                <input type="checkbox" name="highlight" value="1" id="highlight" class="ace" @if(isset($data->highlight) && $data->highlight==1) checked @endif>
                <label for="highlight" class="lbl"> 高亮 </label>&ensp;
                <input type="checkbox" name="stick" value="1" id="stick" class="ace" @if(isset($data->stick) && $data->stick==1) checked @endif>
                <label for="stick" class="lbl"> 置顶 </label>&ensp;
                作者：
                <input type="text" name="author" size="10" value="{{ session('userinfo') }}">
            </div>
        </div>
        <div class="space-4"></div>
        <div class="form-group">
            <label class="col-lg-1 control-label no-padding-right">正文：</label>
            <div class="col-lg-8">
                <script type="text/plain" id="content" name="content" style="width:100%;"></script>
                <script type="text/javascript">
                var ue = UE.getEditor('content', {
                    initialFrameHeight: 350,
                    autoHeightEnabled: true,
                    autoFloatEnabled: true,
                });
                ue.ready(function (){
                    ue.setContent('@if(isset($data->content)){!! $data->content !!}@endif');
                });
                </script>
            </div>
        </div>
        <div class="form-group">
            <div class="col-lg-offset-2 col-lg-9">
                <button class="btn btn-info" type="submit">
                    <i class="ace-icon fa fa-save bigger-110"></i>
                    保存
                </button>
                <input type="hidden" name="publish" value="2"/>
                <input type="hidden" name="id" value="@if(isset($data->id)) {{ $data->id }} @endif"/>
                <button class="btn btn-info" type="button" onclick="this.form.publish.value='1';this.form.submit();">
                    <i class="ace-icon fa fa-external-link bigger-110"></i>
                    保存 并 发布
                </button>
                <button class="btn" type="button" onclick="history.go(-1)">
                    <i class="ace-icon fa fa-undo bigger-110"></i>
                    返回
                </button>
            </div>
        </div>
    </form>
@endsection