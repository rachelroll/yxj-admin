<?php

namespace App\Admin\Controllers;

use App\News;
use App\Http\Controllers\Controller;
use Encore\Admin\Controllers\HasResourceActions;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Layout\Content;
use Encore\Admin\Show;

class NewsController extends Controller
{
    use HasResourceActions;

    /**
     * Index interface.
     *
     * @param Content $content
     * @return Content
     */
    public function index(Content $content)
    {
        return $content
            ->header('资讯')
            ->description('description')
            ->body($this->grid());
    }

    /**
     * Show interface.
     *
     * @param mixed $id
     * @param Content $content
     * @return Content
     */
    public function show($id, Content $content)
    {
        return $content
            ->header('Detail')
            ->description('description')
            ->body($this->detail($id));
    }

    /**
     * Edit interface.
     *
     * @param mixed $id
     * @param Content $content
     * @return Content
     */
    public function edit($id, Content $content)
    {
        return $content
            ->header('Edit')
            ->description('description')
            ->body($this->form()->edit($id));
    }

    /**
     * Create interface.
     *
     * @param Content $content
     * @return Content
     */
    public function create(Content $content)
    {
        return $content
            ->header('Create')
            ->description('description')
            ->body($this->form());
    }

    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        $grid = new Grid(new News);

        $grid->id('ID');
        $grid->title('文章标题');
        $grid->description('简介');

        $grid->category('分类')->display(function ($category) {
            if ($category == 1) {
                return '机构动态';
            } elseif ($category == 2) {
                return '项目报道';
            }elseif ($category == 3) {
                return '乡村观察';
            }else{
                return '最新动态';
            }
        });

        $status = [
            'on'  => ['value' => 1, 'text' => '启用', 'color' => 'success'],
            'off' => ['value' => 0, 'text' => '禁用', 'color' => 'danger'],
        ];
        $grid->enabled('是否启用')->switch($status)->sortable();
        $grid->time('发布时间');
        //$grid->created_at('创建时间');
        //$grid->updated_at('更新时间');

        // 禁用查看按钮
        $grid->actions(function ($actions) {
            $actions->disableView();
            $actions->disableDelete();
        });

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
        $show = new Show(News::findOrFail($id));

        $show->id('ID');
        $show->title('文章标题');
        $show->description('文章简介');

        $show->author('作者姓名');
        $show->simditor('文章内容');

        $show->category('分类')->as(function ($category) {
            if ($category == 1) {
                return '机构动态';
            } elseif ($category == 2) {
                return '项目报道';
            }elseif ($category == 3) {
                return '乡村观察';
            }else{
                return '最新动态';
            }
        });

        return $show;
    }

    /**
     * Make a form builder.
     *
     * @return Form
     */
    protected function form()
    {
        $form = new Form(new News);

        $form->text('title', '文章标题')->rules('required',['required'=>'必填项']);
        $form->text('description', '文章简介')->rules('required',['required'=>'必填项']);
        $form->text('author', '作者姓名');
        $form->simditor('content', '文章内容')->rules('required',['required'=>'必填项']);
        $form->image('cover', '封面图')->crop(233, 160)->rules('required',['required'=>'必填项']);

        //$form->cropper('cover','封面图')->cRatio(233,160)->rules('required',['required'=>'必填项']);

        $form->radio('category', '文章分类')->options([1 => '机构动态',2 => '项目报道', 3 => '乡村观察', 4 => '最新动态'])->default(1)->rules('required',['required'=>'必填项']);
        $form->datetime('time',  '发布时间')->options(['defaultDate' => date('Y-m-d H:m:s')]);
        $options = [
            'on'  => ['value' => 1, 'text' => '是', 'color' => 'primary'],
            'off' => ['value' => 0, 'text' => '否', 'color' => 'default'],
        ];

        $form->switch('enabled', '是否启用')->states($options);

        return $form;
    }
}
