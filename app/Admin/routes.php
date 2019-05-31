<?php

use Illuminate\Routing\Router;

Admin::registerAuthRoutes();

Route::group([
    'prefix'        => config('admin.route.prefix'),
    'namespace'     => config('admin.route.namespace'),
    'middleware'    => config('admin.route.middleware'),
], function (Router $router) {

    $router->get('/', 'HomeController@index')->name('admin.home');

    // ��Ѷ
    $router->resource('news', NewsController::class);

    // ����
    $router->resource('projects',ProjectController::class);

    // ���ı��ļ��ϴ�
    $router->post('/simditor/upload','UploadController@upload');

    // ѧԱ����
    $router->resource('members',MemberController::class);

    // ��Ƶ
    $router->resource('video',MediaController::class);
});
