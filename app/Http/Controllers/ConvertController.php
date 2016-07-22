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
        $file->move(APP_TEMPFILE_OUTPUT_PATH,$name);

        $pdf = APP_TEMPFILE_OUTPUT_PATH.'/'.$name.'.pdf';
        $cmd = '/home/kang/Downloads/wkhtmltox/bin/wkhtmltopdf '.APP_TEMPFILE_OUTPUT_PATH.'/'.$name.' '.$pdf;
        shell_exec($cmd);
        return file_get_contents($pdf);
    }




}
