<?php

namespace App\Http\Controllers;

use App\Models\Article;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class WeChatController extends Controller
{
    public function index(Request $request)
    {
        $param = $request->all();
        Log::info('wechat：' . json_encode($param, JSON_UNESCAPED_UNICODE));
        return 'index';
    }

    /**
     * Title for current resource.
     *
     * @var string
     */
    protected $title = 'WeChat';

    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        $grid = new Grid(new Article());

        $grid->column('id', __('Id'));
        $grid->column('title', __('标题'));
        $grid->column('author', __('作者'));
        $grid->column('article_content', __('内容'));
        $grid->column('created_at', __('创建时间'));
        $grid->column('updated_at', __('更新时间'));
        //$grid->column('deleted_at', __('Deleted at'));

        return $grid;
    }

    /**
     * Make a show builder.
     *
     * @param mixed $id
     * @return Show
     */
    protected function detail($id)
    {
        $show = new Show(Article::findOrFail($id));

        $show->field('id', __('Id'));
        $show->field('title', __('标题'));
        $show->field('author', __('作者'));
        $show->field('article_content', __('文章内容'));
        $show->field('created_at', __('创建时间'));
        $show->field('updated_at', __('更新时间'));
        //$show->field('deleted_at', __('Deleted at'));

        return $show;
    }

    /**
     * Make a form builder.
     *
     * @return Form
     */
    protected function form()
    {
        $form = new Form(new Article());

        $form->text('title', __('标题'));
        $form->text('author', __('作者'));
        $form->textarea('article_content', __('文章内容'));

        return $form;
    }
}
