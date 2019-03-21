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
                <input type="text" id="title" name="title" value="@if(isset($data->title)) {{$data->title}} @else @endif" class="form-control">
            </div>
        </div>
        <div class="space-4"></div>
        <div class="form-group">
            <label class="col-lg-1 control-label no-padding-right" for="link" title="link" nowrap >网址：</label>
            <div class="col-lg-6">
                <input type="text" id="link" name="link" value="@if(isset($data->link)) {{$data->link}} @else @endif"  style='font-family:verdana' class="form-control" />
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
                日期：
                <input type="text" name="create_time" value="@if(isset($data->create_time)) {{date('Y-m-d H:i:s',$data->create_time)}} @else {{ date('Y-m-d H:i:s') }}@endif" onFocus="WdatePicker({dateFmt:'yyyy-MM-dd HH:mm:ss',isShowClear:false,readOnly:false})"/>&nbsp;
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
                <input type="hidden" name="publish" value="@if(isset($data->publish)) {{ $data->publish }} @else 2 @endif"/>
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