<?php

namespace App\Admin\Controllers;

use App\Project;
use App\Http\Controllers\Controller;
use Encore\Admin\Controllers\HasResourceActions;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Layout\Content;
use Encore\Admin\Show;

class ProjectController extends Controller
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
            ->header('案例')
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
        $grid = new Grid(new Project);

        $grid->id('ID');
        $grid->title('案例名称');
        $grid->description('案例简介');

        $status = [
            'on'  => ['value' => 1, 'text' => '启用', 'color' => 'success'],
            'off' => ['value' => 0, 'text' => '禁用', 'color' => 'danger'],
        ];
        $grid->enabled('是否启用')->switch($status)->sortable();
        $grid->created_at('创建时间');
        $grid->updated_at('更新时间');

        // 禁用查看按钮
        $grid->actions(function ($actions) {
            $actions->disableView();
            //$actions->disableDelete();
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
        $show = new Show(Project::findOrFail($id));
        return $show;
    }

    /**
     * Make a form builder.
     *
     * @return Form
     */
    protected function form()
    {
        $form = new Form(new Project);

        $form->text('title', '案例名称')->rules('required',['required'=>'必填项']);
        $form->text('description', '案例简介')->rules('required',['required'=>'必填项']);
        $form->text('author', '作者姓名');
        $form->simditor('content', '案例内容')->rules('required',['required'=>'必填项']);
        $form->image('cover', '封面图')->rules('required',['required'=>'必填项']);

        $form->select('district', '地区')
            ->options([
                1 => '北京市',
                2 => '天津市',
                3 => '河北省',
                4 => '山西省',
                5 => '内蒙古自治区',
                6 => '辽宁省',
                7 => '吉林省',
                8 => '黑龙江省',
                9 => '上海市',
                10 => '江苏省',
                11 => '浙江省',
                12 => '安徽省',
                13 => '福建省',
                14 => '江西省',
                15 => '山东省',
                16 => '河南省',
                17 => '湖北省',
                18 => '湖南省',
                19 => '广东省',
                20 => '广西壮族自治区',
                21 => '海南省',
                22 => '重庆市',
                23 => '四川省',
                24 => '贵州省',
                25 => '云南省',
                26 => '西藏自治区',
                27 => '陕西省',
                28 => '甘肃省',
                29 => '青海省',
                30 => '宁夏回族自治区',
                31 => '新疆维吾尔自治区',
                32 => '香港特别行政区',
                33 => '澳门特别行政区',
                34 => '台湾省',
                'val' => '北京市'
        ]);

        $form->checkbox('category', '分类（可多选）')->options([1 => '概念规划', 2 => '总体规划', 3 => '详细规划', 4=> '乡镇计划', 5 => '品牌规划',6 => '产业振兴', 15 => '乡建人才', 16 => '乡建生态',17 => '文化振兴',18 => '乡村经营', 19 => '产业植入',20 => '投资开发',21 => '资产管理','val' => '概念规划']);

        $options = [
            'on'  => ['value' => 1, 'text' => '是', 'color' => 'primary'],
            'off' => ['value' => 0, 'text' => '否', 'color' => 'default'],
        ];

        $form->switch('enabled', '是否启用')->states($options);

        return $form;
    }
}

