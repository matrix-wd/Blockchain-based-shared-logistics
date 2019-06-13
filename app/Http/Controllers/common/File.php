<?php

namespace App\Http\Controllers\common;
use Illuminate\Support\Facades\Storage;


class File
{
    const FILE_EXTENSION_FAIL = '传输文件格式不合法';
    const FILE_UPLOAD_FAIL = '未获取到上传文件或上传过程出错';
    const DELETE_FILE_FAIL = '删除文件失败';

    /**
     * @param Request $request
     * @param $path
     * @param $allowExtension
     * @return string
     * 上传文件
     */
    public static function upload($request, $path, $allowExtension) {
        if ($request->hasFile('file') && $request->file('file')->isValid()) {
            $photo = $request->file('file');
            $extension = $photo->extension();
            if(!in_array($extension, $allowExtension)) {
                return self::FILE_EXTENSION_FAIL;
            }
            $store_result = $photo->store($path);
            return $store_result;
        } else {
            return self::FILE_UPLOAD_FAIL;
        }
    }

    /**
     * @param $filename
     * @param $path
     * @return mixed
     * 删除文件
     */
    public static function delete($filename) {
        $res = Storage::delete($filename);
        return $res;
    }
}
