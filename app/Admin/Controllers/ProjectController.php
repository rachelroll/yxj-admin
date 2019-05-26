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
                1 => '河北省',
                2 => '山西省',
                1 => '内蒙古自治区',
                2 => '辽宁省',
                1 => '吉林省',
                2 => '黑龙江省',
                1 => '上海市',
                2 => '江苏省',
                1 => '浙江省',
                2 => '安徽省',
                1 => '福建省',
                2 => '江西省',
                1 => '山东省',
                2 => '河南省',
                1 => '湖北省',
                2 => '湖南省',
                1 => '广东省',
                2 => '广西壮族自治区',
                1 => '海南省',
                2 => '重庆市',
                1 => '四川省',
                2 => '贵州省',
                1 => '云南省',
                2 => '西藏自治区',
                1 => '陕西省',
                2 => '甘肃省',
                1 => '青海省',
                2 => '宁夏回族自治区',
                1 => '新疆维吾尔自治区',
                2 => '香港特别行政区',
                1 => '澳门特别行政区',
                2 => '台湾省',
                'val' => '北京市'
        ]);

        $form->checkbox('category', '分类')->options([1 => '概念规划', 2 => '总体规划', 3 => '详细规划',4 => '总体规划',5 => '品牌规划',6 => '产业振兴',7 => '主题艺术节',8 => '村落发展',9 => '培训教育',10 => '艺乡建资助体系',11 => '调查科研',12 => '志愿者平台',13 => '国际合作',14 => '媒体合作',15 => '乡建人才', 16 => '乡建生态',17 => '文化振兴',18 => '乡村经营', 19 => '产业植入',20 => '投资开发',21 => '资产管理','val' => '概念规划']);

        $options = [
            'on'  => ['value' => 1, 'text' => '是', 'color' => 'primary'],
            'off' => ['value' => 0, 'text' => '否', 'color' => 'default'],
        ];

        $form->switch('enabled', '是否启用')->states($options);

        return $form;
    }
}

