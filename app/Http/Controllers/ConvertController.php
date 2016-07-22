<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;

class ConvertController extends Controller
{

    public function Html2Pdf(Request $request)
    {
        $file = $request->file('file');
        if($file->getMimeType() != 'text/html')
        {
            return self::$response->error(CODE_C_UPLOAD_FILE_TYPE_ERR);
        }
        $name = $file->getClientOriginalName();
        $path = $file->getRealPath();

        $cmd = '/home/kang/Downloads/wkhtmltox/bin/wkhtmltopdf '.$path.' '.$name.'.pdf';
        $out = shell_exec($cmd);
        return self::$response->success(['data'=>$out]);
    }




}
