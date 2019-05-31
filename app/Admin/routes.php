<?php

use Illuminate\Routing\Router;

Admin::registerAuthRoutes();

Route::group([
    'prefix'        => config('admin.route.prefix'),
    'namespace'     => config('admin.route.namespace'),
    'middleware'    => config('admin.route.middleware'),
], function (Router $router) {

    $router->get('/', 'HomeController@index')->name('admin.home');

    // 资讯
    $router->resource('news', NewsController::class);

    // 案例
    $router->resource('projects',ProjectController::class);

    // 富文本文件上传
    $router->post('/simditor/upload','UploadController@upload');

    // 学员管理
    $router->resource('members',MemberController::class);

    // 视频
    $router->resource('video',MediaController::class);
});
