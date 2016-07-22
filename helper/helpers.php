<?php
/**
 * 函数定义
 * User: kang
 * Date: 16/6/5
 * Time: 16:05
 */

/**
 * 对象转换成数组
 * @param $object
 * @return mixed
 */
function objToArray($object)
{
    if(empty($object)){
        return $object;
    }
    return json_decode(json_encode($object), true);
}

/**
 * 数组转换父子树形结果
 * @param $id
 * @param $data
 * @return array
 */
function parentSons($id, $data)
{
    $sons = [];
    foreach($data as $key=>$value)
    {
        if($value['parent_id'] == $id)
        {
            $value['sons'] = parentSons($value['id'],$data);
            $sons[] = $value;
            unset($data[$key]);
        }
    }
    return $sons;
}


/**
 * 发送 http 请求
 *
 * @param $url
 * @param null $post
 * @param null $header
 * @return mixed
 */
function curl($url,$post=null,$header=null)
{
    $start = microtime();
    $ch = curl_init(); //初始化curl
    curl_setopt($ch, CURLOPT_URL, $url);//设置链接
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);//设置是否返回信息
    if(!is_null($post)) {
        curl_setopt($ch, CURLOPT_POST, 1);//设置为POST方式
        curl_setopt($ch, CURLOPT_POSTFIELDS, $post);//POST数据
    }
    if(!is_null($header)){
        curl_setopt($ch, CURLOPT_HTTPHEADER , $header );
    }
    $response = curl_exec($ch);

    \Illuminate\Support\Facades\Log::info(['request'=>$url, "post"=>$post, "start"=>$start, "stop"=>microtime()]);
    return $response;
}


/**
 * 格式化请求题库接口参数
 *
 * @param $params
 * @return array
 */
function formatParams($params)
{
    if(empty($params)){
        return [];
    }else{
        return explode(',',$params);
    }
}

/**
 * 获取返回值对应的msg信息
 *
 * @param $code
 * @return mixed
 */
function getCodeMsg($code)
{
    return config("code_msg.".$code);
}

/**
 * 获取当前登录的教师用户信息
 *
 * @param null $field
 * @return mixed
 */
function getTeacherInfo($field=null, $default=null)
{
    $teacher_id = session('teacher_id',0);
    $redis_key = REDIS_TEACHER_INFO.':'.$teacher_id;
    if(is_null($field)){
        $data = \Illuminate\Support\Facades\Redis::hgetall($redis_key);
    }else{
        $data = \Illuminate\Support\Facades\Redis::hget($redis_key,$field);
    }
    return is_null($data) ? $default:$data;
}

/**
 * 获取当前登录的学生用户信息
 *
 * @param null $field
 * @param null $default
 * @return null
 */
function getStudentInfo($field=null, $default=null)
{
    $student_id = session('student_id', 0);
    $redis_key = REDIS_STU_INFO.':'.$student_id;

    if($field === null){
        $data = \Illuminate\Support\Facades\Redis::hgetall($redis_key);
    }
    else {
        $data = \Illuminate\Support\Facades\Redis::hget($redis_key,$field);
    }

    return $data === null ? $default : $data;
}

