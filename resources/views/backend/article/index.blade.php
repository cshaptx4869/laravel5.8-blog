@extends('backend.layouts.main')

@section('title', '文章列表')

@section('breadcrumb', '文章管理')

@section('content')
    <form method="post" action="{{ url('article/index') }}"  class="page-content">
        @csrf
        <div class="row">
            <div class="col-lg-1 col-sm-2 col-xs-4">
                <label style="margin-top: 4px">
                    <input type="checkbox" class="ace" onclick="check_all(this.form, 'id[]', this.checked)" id="checkall"/>
                    <span class="lbl">
                   全选
                </span>
                </label>
            </div>
            <div class="col-lg-2 col-sm-4 col-xs-8">
                <div class="row">
                    操作：
                    <select name="operation">
                        <option value="publish">发布</option>
                        <option value="unpublish">取消发布</option>
                        <option value="stick">置顶</option>
                        <option value="unstick">取消置顶</option>
                        <option value="highlight">高亮</option>
                        <option value="unhighlight">取消高亮</option>
                        <option value="delete">删除</option>
                    </select>
                    <button  type="button"  class="btn btn-sm btn-info"  onclick="article_operate(this.form)">
                        <i class="ace-icon fa  fa-sign-out bigger-110"></i>
                        执行
                    </button>
                </div>
            </div>
            <div class="col-lg-1 col-sm-3 col-xs-6">
                <button class="btn btn-info btn-sm" type="button" data-toggle="collapse" data-target="#collapse" aria-expanded="false" aria-controls="collapse">
                    <i class="ace-icon glyphicon glyphicon-search"></i>
                    <span>搜索</span>
                </button>
            </div>
            <div class="col-lg-offset-9">
                <a href="{{ url('article/create') }}">
                    <button  type="button"  class="btn btn-sm  btn-info" target="_self">
                        <i class="ace-icon fa  fa-plus-square bigger-110"></i>
                        添加新文章
                    </button>
                </a>
            </div>
        </div>

        <!-- 搜索 -->
        <div class="row">
            <div class="collapse widget-box widget-main col-lg-12" id="collapse">
                <div class="form-group">
                    <label for="title">标题：</label>
                    <input name="title" type="text" class="search-text" id="title" value="" />
                </div>
                <div class="form-group">
                    <label for="start">开始日期：</label>
                    <input name="start" type="text" class="search-text" id="start" value="" onfocus="WdatePicker({dateFmt:'yyyy-MM-dd H:mm:ss',isShowClear:false,readOnly:false,skin:'default'})"/>
                </div>
                <div class="form-group">
                    <label for="end">结束日期：</label>
                    <input name="end" type="text" class="search-text" id="end" value="" onfocus="WdatePicker({dateFmt:'yyyy-MM-dd H:mm:ss',isShowClear:false,readOnly:false,skin:'default'})"/>
                </div>
                <div class="form-group">
                    <label for="status">状态：</label>
                    <select name="status" id="status">
                        <option value="" >- 请选择 -</option>
                        <option value="publish" {if $Request.post.status == 'publish'}selected{/if}>- 发布 -</option>
                        <option value="unpublish" {if $Request.post.status == 'unpublish'}selected{/if}>- 未发布 -</option>
                        <option value="highlight" {if $Request.post.status == 'highlight'}selected{/if}>- 高亮 -</option>
                        <option value="unhighlight" {if $Request.post.status == 'unhighlight'}selected{/if}>- 非高亮 -</option>
                        <option value="stick" {if $Request.post.status == 'stick'}selected{/if}>- 置顶 -</option>
                        <option value="unstick" {if $Request.post.status == 'unstick'}selected{/if}>- 非置顶 -</option>
                    </select>
                </div>
                <div>
                    <input type="submit" name="button" class="btn btn-sm btn-primary" value="搜索" />
                </div>
            </div>
        </div>

        <div class="space-10"></div>
        <div id="select_status" style="background-color:#fcffb7;line-height:25px;text-align:center"></div>
        <div class="alert alert-info">
            <p class="text-center">
                <strong class="red glyphicon glyphicon-warning-sign">文章状态标识说明：</strong>
                <span class="blue glyphicon glyphicon-eye-open"></span>&nbsp;&nbsp;已发布 &nbsp;&nbsp;
                <span class="blue glyphicon glyphicon-hand-up"></span>&nbsp;&nbsp;置顶 &nbsp;&nbsp;
                <span class="blue glyphicon glyphicon-flash"></span>&nbsp;&nbsp;高亮
            </p>
        </div>
        <div class="space-10"></div>
        <div class="table-responsive">
            <table class="table table-bordered table-hover">
                <thead>
                <tr>
                    <th class="text-center">选择</th>
                    <th class="text-center hidden-xs">编号</th>
                    <th class="text-center hidden-xs">状态标识</th>
                    <th class="text-center">标题</th>
                    <th class="text-center hidden-xs">作者</th>
                    <th class="text-center hidden-xs">点击量</th>
                    <th class="text-center hidden-xs">发布日期</th>
                    <th class="text-center">编辑</th>
                    <th class="text-center">删除</th>
                </tr>
                </thead>
                @if($articles)
                @foreach($articles as $article)
                <tr>
                    <td class="text-center">
                        <input type="checkbox" name="id[]" class="ace" value="{{ $article->id }}"><span class="lbl"></span>
                    </td>
                    <td class="text-center hidden-xs">{{ $article->id }}</td>
                    <td class="text-center hidden-xs">
                        @if($article->publish == 1)<span class="blue glyphicon glyphicon-eye-open"></span> &ensp; @endif
                        @if($article->stick == 1)<span class="blue glyphicon glyphicon-hand-up"></span> &ensp; @endif
                        @if($article->highlight == 1)<span class="blue glyphicon glyphicon-flash"></span>@endif
                    </td>
                    <td class="text-center">
                        <a href="{{ url('article/read/'.$article->id) }}">{{ $article->title}}</a>
                    </td>
                    <td class="text-center hidden-xs">{{ $article->author }}</td>
                    <td class="text-center hidden-xs">{{ $article->hits }}</td>
                    <td class="text-center hidden-xs">{{ date("Y-m-d H:i:s", $article->create_time)}}</td>
                    <td class="text-center">
                        <a href="{{ url('article/read/'.$article->id) }}" >
                            <span class="glyphicon glyphicon-edit"></span></a>
                    </td>
                    <td class="text-center">
                        <a href="#" onclick="del({{ $article->id }});">
                            <span class="glyphicon glyphicon-trash"></span>
                        </a>
                    </td>
                </tr>
                @endforeach
                @else
                <tr>
                    <td colspan="10">
                        <h3 class="text-center">暂无数据</h3>
                    </td>
                </tr>
                @endif
            </table>
        </div>
        <div class="pull-right">
            {{ $articles->links() }}
        </div>
    </form>
@endsection

@section('js')
    <script>
        var url = "{{ url('article/operation') }}";
        /* 单个删除 */
        function del(id)
        {
            if(confirm("确实要删除ID为"+id+"的文章吗？该操作不可恢复。")){
                window.location.href = url + "?ids="+id+"&cmd=delete";
            }
        }
        /* 文章操作 */
        function article_operate(form)
        {
            var operation = form.operation.value;
            var ids = '';
            for (var i = 0; i < form.elements.length; i ++) {
                var e = form.elements[i];
                if (e.name == 'id[]' && e.checked) {
                    if (ids.length == 0){
                        ids = e.value;
                    } else{
                        ids = ids + ',' + e.value;
                    }
                }
            }
            if (ids.length == 0) {
                alert('没有选择任何文章');
                return;
            } else {
                // operate on selected articles
                if (operation == 'delete') {
                    if (!confirm("确认要删除选中的文章吗？该操作不可恢复。")){
                        return;
                    }
                }
                var uri =  url + '?ids=' + ids + '&cmd=' + operation;
                window.location.href = uri;
            }
        }
        /* 全选 全不选*/
        function check_all(form, check_name, flag) {
            var j = 0;
            for (var i=0; i<form.elements.length; i++) {
                var e = form.elements[i];
                if (e.name == check_name){
                    e.checked = flag;
                    j++;
                }
            }
            var obj = document.getElementById('select_status');
            if(flag){
                obj.innerHTML = '共选中<strong><span class="red"> '+j+' </span></strong>条记录';
                obj.style.display = 'block';
            }else{
                obj.style.display = 'none';
            }
        }
        $(function(){
            $("input[name='id[]']").click(function() {
                $("#checkall").attr("checked", false);
            });
        });
    </script>
@endsection