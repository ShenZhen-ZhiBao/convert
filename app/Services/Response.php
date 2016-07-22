<?php
/**
 * 响应客户端数据课时
 * User: kang
 * Date: 16/6/4
 * Time: 13:41
 */
namespace App\Services;
use Request;

class Response
{
    /**
     * 成功响应,根据 header 里 source 参数,响应不同格式的数据
     *
     * @param array $data
     * @return array
     */
    public function success(array $data=array())
    {
        $source = Request::header("source","web");
        $method = "success_".$source;
        if(! method_exists($this, $method)){
            return $this->success_web($data);
        }
        return $this->$method($data);
    }

    /**
     * 响应 web 端格式
     *
     * @param array $data
     * @return array
     */
    private function success_web(array $data)
    {
        $response = $this->getFormatRes(CODE_SUCCESS);
        if(!empty($data)) {
            $response['data'] = $data;
        }
        return $response;
    }

    /**
     * 响应 app 端格式
     *
     * @param array $data
     * @return array
     */
    private function success_app(array $data)
    {
        $response = $this->getFormatRes(CODE_SUCCESS);
        if(!empty($data)) {
            $response = array_merge($response,$data);
        }
        return $response;
    }

    /**
     * 错误响应
     *
     * @param int $code
     * @param string $msg
     * @return array
     */
    public function error($code=CODE_FAIL)
    {
        $response = $this->getFormatRes($code);
        return $response;
    }


    /**
     * 响应格式
     *
     * @param $code
     * @return array
     */
    private function getFormatRes($code)
    {
        $msg = config("code_msg.".$code);
        $response = array(
            "status" => $code,
            "msg"    => is_null($msg) ? "错误信息没写啊":$msg
        );
        return $response;
    }

}