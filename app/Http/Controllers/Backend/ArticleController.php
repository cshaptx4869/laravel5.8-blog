<?php

namespace App\Http\Controllers\Backend;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;

class ArticleController extends Controller
{
    // 文章列表
    public function index(Request $request)
    {
        if ($request->isMethod('post')) {
            $where = [];
            $search = $request->post();
            if ($search['title']) {
                $where[] = ['title', 'like', '%' . $search['title'] . '%'];
            }
            if ($search['start']) {
                $where[] = ['create_time', '>=', strtotime($search['start'])];
            }
            if ($search['end']) {
                $where[] = ['create_time', '<=', strtotime($search['end'])];
            }
            if ($search['status']) {
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
                        throw new \InvalidArgumentException('状态错误！');
                }
                $where[] = [preg_replace('/^un/', '', $search['status']), '=', $value];
            }
        }
        $where[] = ['delete_time', '=', null];
        $articles = DB::table('article')->where($where)->orderBy('stick')->orderBy('id', 'desc')
            ->paginate(auto_pagesize());

        return view('backend.article.index', compact('articles'));
    }

    // 文章相关操作
    public function operation(Request $request)
    {
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
                $type = ['delete_time' => time()];
                break;
        }
        $num = DB::table('article')->whereIn('id', explode(',', $param['ids']))->update($type);
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
        $data = $request->post();
        $data['create_time'] = strtotime($data['create_time']);
        unset($data['_token']);
        if (isset($data['id'])) {
            DB::table('article')->where('id', $data['id'])->update($data);
            return view('jump', success('更新成功！', url('article/index')));
        } else {
            unset($data['id']);
            $bool = DB::table('article')->insert($data);
            if ($bool) {
                return view('jump', success('添加文章成功！', url('article/index')));
            } else {
                return view('jump', error('添加文章失败！'));
            }
        }
    }

    // 回显文章信息
    public function read($id)
    {
        $data = DB::table('article')->find($id);
        return view('backend.article.form', compact('data'));
    }
}
