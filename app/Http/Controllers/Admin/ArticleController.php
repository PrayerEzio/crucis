<?php
namespace App\Http\Controllers\Admin;
use App\Http\Models\Article;
use App\Http\Models\ArticleCategory;
use App\Http\Services\QiniuService;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\View;
class ArticleController extends CommonController
{
    public function index(Article $article)
    {
        $article_list = $article
                        /*->where('published_at','<=',Carbon::now())*/
                        ->orderBy('published_at','desc')
                        ->paginate(9);
        foreach ($article_list as $key => $article)
        {
            $article_list[$key]['tag'] = explode(',',$article['tag']);
        }
        return view('Admin.Article.index')->with(compact('article_list'));
    }

    public function show(Article $article,Request $request)
    {
        $slug = $request->slug;
        $article = $article::whereSlug($slug)
                    /*->where('published_at','<=',Carbon::now())*/
                    ->firstOrFail();
        $article['tag'] = explode(',',$article['tag']);
        return view('Admin.Article.show')->with(compact('article'));
    }

    public function add(Request $request,ArticleCategory $articleCategory,Article $article,QiniuService $qiniuService)
    {
        if ($request->isMethod('post'))
        {
            if ($request->file('image'))
            {
                $article->image = $qiniuService->upload($request->file('image'));
            }
            $article->category_id = $request->category_id;
            $article->title = $request->title;
            $article->slug = str_slug($article->title);
            $article->author = $request->author;
            $article->tag = $request->tag;
            $article->description = $request->description;
            $article->seo_title = $request->seo_title;
            $article->seo_keywords = $request->seo_keywords;
            $article->seo_description = $request->seo_description;
            $article->status = $request->status == 'on' ? 1 : 0;
            $article->body = $request->body;
            $article->sort = $request->sort;
            $res =$article->save();
            if ($res)
            {
                $alert = ['success','操作成功'];
            }else {
                $alert = ['error','操作失败'];
            }
            return redirect(config('crucis.app_url') . "/Admin/Article/index")->with('alert', $alert);
        }else {
            $article_cates = $articleCategory->get();
            return view('Admin.Article.add')->with(compact('article_cates'));
        }
    }

    public function edit(Request $request,ArticleCategory $articleCategory,Article $article,QiniuService $qiniuService)
    {
        if ($request->isMethod('post'))
        {
            $article = $article->findOrFail($request->id);
            if ($request->file('image'))
            {
                $article->image = $qiniuService->upload($request->file('image'));
            }
            $article->category_id = $request->category_id;
            $article->title = $request->title;
            $article->slug = str_slug($article->title);
            $article->author = $request->author;
            $article->tag = $request->tag;
            $article->description = $request->description;
            $article->seo_title = $request->seo_title;
            $article->seo_keywords = $request->seo_keywords;
            $article->seo_description = $request->seo_description;
            $article->status = $request->status == 'on' ? 1 : 0;
            $article->body = $request->body;
            $article->sort = $request->sort;
            $res =$article->save();
            if ($res)
            {
                $alert = ['success','操作成功'];
            }else {
                $alert = ['error','操作失败'];
            }
            return redirect(config('crucis.app_url') . "/Admin/Article/index")->with('alert', $alert);
        }else {
            $article_cates = $articleCategory->get();
            $id = $request->id;
            $article = $article->findOrFail($id);
            return view('Admin.Article.add')->with(compact('article_cates','article'));
        }
    }

    public function addCate(Request $request,ArticleCategory $articleCategory,$id)
    {
        if ($request->isMethod('post'))
        {
            $articleCategory->name = $request->name;
            $articleCategory->parent_id = $id;
            $articleCategory->sort = $request->sort;
            $articleCategory->status = $request->status == 'on' ? 1 : 0;
            $res = $articleCategory->save();
            if ($res)
            {
                $alert = ['success','操作成功'];
            }else {
                $alert = ['error','操作失败'];
            }
            return redirect(config('crucis.app_url') . "/Admin/Article/cateList")->with('alert', $alert);
        }else {
            return view('Admin.Article.add_cate');
        }
    }

    public function editCate(Request $request,ArticleCategory $articleCategory,$id)
    {
        if ($request->isMethod('post'))
        {
            $articleCategory = $articleCategory->findOrFail($id);
            $articleCategory->name = $request->name;
            $articleCategory->parent_id = $request->parent_id;
            $articleCategory->sort = $request->sort;
            $articleCategory->status = $request->status == 'on' ? 1 : 0;
            $res = $articleCategory->save();
            if ($res)
            {
                $alert = ['success','操作成功'];
            }else {
                $alert = ['error','操作失败'];
            }
            return redirect(config('crucis.app_url') . "/Admin/Article/cateList")->with('alert', $alert);
        }else {
            $article_cates = $articleCategory->get();
            $data = $articleCategory->findOrFail($request->id);
            return view('Admin.Article.add_cate')->with(compact('article_cates','data'));
        }
    }

    public function cateList()
    {
        return view('Admin.Article.cate_list');
    }

    public function delete(Request $request,Article $article)
    {
        $res = $article->destroy($request->id);
        if ($res)
        {
            return response([
                'status'  => 200,
                'message' => __('Operation succeed.'),
                'data' => $res
            ]);
        }else {
            return response([
                'status'  => 500,
                'message' => __('Operation fail.'),
                'data' => $res
            ]);
        }
    }

    public function deleteCate(Request $request,ArticleCategory $articleCategory)
    {
        $res = false;
        $child_count = $articleCategory->where('parent_id',$request->id)->count();
        if (!$child_count)
        {
            $res = $articleCategory->destroy($request->id);
        }
        if ($res)
        {
            return response([
                'status'  => 200,
                'message' => __('Operation succeed.'),
                'data' => $res
            ]);
        }else {
            return response([
                'status'  => 500,
                'message' => __('Operation fail.'),
                'data' => $res
            ]);
        }
    }
}
