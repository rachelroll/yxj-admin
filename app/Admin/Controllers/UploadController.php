<?php

namespace App\Admin\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;

class UploadController extends Controller
{

    public function upload(Request $request)
    {
        $file=$request->file('upload_file');
        if ($file->isValid()) {
            //$extension=$file->getClientOriginalExtension();
            $path=$file->getRealPath();
            $filename = 'images/' . date('Y-m-d-h-i-s') . '-' .  $file->getClientOriginalName();
            $bool= Storage::disk('oss')->put($filename,file_get_contents($path));
            if ($bool) {
                return [
                    'success'   => true,
                    'msg'       => "�ɹ��ϴ�",
                    'file_path' => env('CDN_DOMAIN') . '/' .$filename,
                ];
            } else {
                return [
                    'success'   => false,
                    'msg'       => "�ϴ�ʧ��,����ϵ����Ա",
                    'file_path' => '',
                ];
            }
        }
    }
}