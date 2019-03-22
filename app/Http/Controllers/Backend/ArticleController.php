<?php

namespace App\Http\Controllers\Backend;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Model\ArticleModel;

class ArticleController extends Controller
{
    // 文章列表
    public function index(Request $request)
    {
        if ($request->isMethod('post')) {
            // 检索条件
            $where = [];
            $search = $request->post();
            if (isset($search['title'])) {
                $where[] = ['title', 'like', '%' . $search['title'] . '%'];
            }
            if (isset($search['start'])) {
                $where[] = ['created_at', '>=', strtotime($search['start'])];
            }
            if (isset($search['end'])) {
                $where[] = ['created_at', '<=', strtotime($search['end'])];
            }
            if (isset($search['status'])) {
                switch ($search['status']) {
                    case 'publish':
                        $value = 1;
                        break;
                    case 'unpublish':
                        $value = 2;
                        break;
                    case 'stick':
                        $value = 1;
                        break;
                    case 'unstick':
                        $value = 2;
                        break;
                    case 'highlight':
                        $value = 1;
                        break;
                    case 'unhighlight':
                        $value = 2;
                        break;
                    default:
                        throw new \InvalidArgumentException('文章状态错误！');
                }
                $where[] = [preg_replace('/^un/', '', $search['status']), '=', $value];
            }
        }

        if (isset($where)) {
            $articles = ArticleModel::where($where)->orderBy('stick')->orderBy('id', 'desc')->paginate(auto_pagesize());
        } else {
            $articles = ArticleModel::orderBy('stick')->orderBy('id', 'desc')->paginate(auto_pagesize());
        }

        $search = isset($search) ? $search : null;

        return view('backend.article.index', compact('articles','search'));
    }

    // 文章相关操作
    public function operation(Request $request)
    {
        $request->validate([
            'cmd' => 'required',
            'ids' => 'required'
        ]);
        $param = $request->only(['cmd', 'ids']);
        switch ($param['cmd']) {
            case 'publish':
                $type = ['publish' => 1];
                break;
            case 'unpublish':
                $type = ['publish' => 2];
                break;
            case 'stick':
                $type = ['stick' => 1];
                break;
            case 'unstick':
                $type = ['stick' => 2];
                break;
            case 'highlight':
                $type = ['highlight' => 1];
                break;
            case 'unhighlight':
                $type = ['highlight' => 2];
                break;
            case 'delete':
                $type = ['deleted_at' => time()];
                break;
            default:
                throw new \InvalidArgumentException('文章状态错误！');
        }
        $num = ArticleModel::whereIn('id', explode(',', $param['ids']))->update($type);

        return view('jump', success('成功更新' . $num . '条数据！'));
    }

    // 文章表单
    public function create()
    {
        return view('backend.article.form');
    }

    // 文章修改或添加
    public function save(Request $request)
    {
        $request->validate([
            'title' => 'required',
        ]);
        $data = $request->post();
        if (isset($data['id'])) {
            // 更新
            $data['highlight'] = isset($data['highlight']) ? $data['highlight'] : 2;
            $data['stick'] = isset($data['stick']) ? $data['stick'] : 2;
            $articleObj = ArticleModel::find($data['id']);
            $bool = $articleObj->update($data);
            return view('jump', success('更新成功！', url('article/index')));
        } else {
            // 新增
            $articleObj = ArticleModel::create($data);
            if ($articleObj->id) {
                return view('jump', success('添加文章成功！', url('article/index')));
            } else {
                return view('jump', error('添加文章失败！', url('article/index')));
            }
        }
    }

    // 回显文章信息
    public function read($id)
    {
        $data = ArticleModel::find($id);
        return view('backend.article.form', compact('data'));
    }
}
