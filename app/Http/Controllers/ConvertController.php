<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use Log;

class ConvertController extends Controller
{

    /**
     * html转换为 pdf
     *
     * @param Request $request
     * @return array|string
     */
    public function Html2Pdf(Request $request)
    {
        $name = $this->uploadFile($request);
        if(!$name){
            return self::$response->error(CODE_C_UPLOAD_FILE_TYPE_ERR);
        }

        $upload_html = APP_TEMPFILE_OUTPUT_PATH.'/'.$name;
        $out_pdf = APP_TEMPFILE_OUTPUT_PATH.'/'.$name.'.pdf';
        $command = config('common.wkhtmltopdf');
        //检查是否存在,执行权限
        if(!is_executable($command)){
            Log::warning($command." 没有权限执行");
            return self::$response->error(CODE_B_COMMAND_EXEC_ERR);
        }

        $cmd = $command.' '.$upload_html.' '.$out_pdf;
        shell_exec($cmd);
        $pdf_content = file_get_contents($out_pdf);
        unlink($upload_html);
        unlink($out_pdf);
        return $pdf_content;
    }

    /**
     * html转换为 docx的 word 文件
     *
     * @param Request $request
     * @return array|string
     */
    public function Html2Word(Request $request)
    {
        $name = $this->uploadFile($request);
        if(!$name){
            return self::$response->error(CODE_C_UPLOAD_FILE_TYPE_ERR);
        }

        $upload_html = APP_TEMPFILE_OUTPUT_PATH.'/'.$name;
        $out_docx = APP_TEMPFILE_OUTPUT_PATH.'/'.$name.'.docx';
        $command = config('common.pandoc');
        //检查是否存在,执行权限
        if(!is_executable($command)){
            Log::warning($command." 没有权限执行");
            return self::$response->error(CODE_B_COMMAND_EXEC_ERR);
        }

        $cmd = $command.' -f html -t docx -o '.$out_docx.' '.$upload_html;
        shell_exec($cmd);
        $docx_content = file_get_contents($out_docx);
        unlink($upload_html);
        unlink($out_docx);
        return $docx_content;
    }



    /*********非接口了︿(￣︶￣)︿**********/
    private function uploadFile(Request $request)
    {
        $file = $request->file('file');
        if(is_null($file) || $file->getMimeType() != 'text/html') {
            return false;
        }
        $name = md5(rand(1,time())).'_'.$file->getClientOriginalName();
        $file->move(APP_TEMPFILE_OUTPUT_PATH,$name);
        return $name;
    }

}
