<?php

function bubbleSort($array)
{
    $len = count($array);
    if ($len <= 1) {
        return $array;
    }
    for ($i = 0; $i < $len - 1; ++$i) {
        for ($j = 0; $j < $len - 1 - $i; ++$j) {
            if ($array[$j] > $array[$j + 1]) {
                $temp = $array[$j];
                $array[$j] = $array[$j + 1];
                $array[$j + 1] = $temp;
            }
        }
    }
    return $array;
}

function selectionSort($array)
{
    $len = count($array);
    if ($len <= 1) {
        return $array;
    }
    for ($i = 0; $i < $len - 1; ++$i) {
        $minIndex = $i;
        for ($j = $i; $j < $len; ++$j) {
            if ($array[$minIndex] > $array[$j]) {
                $minIndex = $j;
            }
        }
        $temp = $array[$minIndex];
        $array[$minIndex] = $array[$i];
        $array[$i] = $temp;
    }
    return $array;
}

function insertionSort($array)
{
    $len = count($array);
    if ($len <= 1) {
        return $array;
    }
    for ($i = 1; $i < $len; ++$i) {
        for ($j = $i; $j > 0; --$j) {
            if ($array[$j] < $array[$j - 1]) {
                $temp = $array[$j];
                $array[$j] = $array[$j - 1];
                $array[$j - 1] = $temp;
            }
        }
    }
    return $array;
}

function shellSort($array)
{
    $len = count($array);
    if ($len <= 1) {
        return $array;
    }
    for ($gap = floor($len / 2); $gap > 0; $gap = floor($gap / 2)) {
        for ($i = $gap; $i < $len; $i++) {
            $j = $i;
            $current = $array[$i];
            while ($j - $gap >= 0 && $current < $array[$j - $gap]) {
                $array[$j] = $array[$j - $gap];
                $j = $j - $gap;
            }
            $array[$j] = $current;
        }
    }
    return $array;
}

function mergeSort($array)
{
    $len = count($array);
    if ($len <= 1) {
        return $array;
    }
    $mid = intval($len / 2);
    $left = array_slice($array, 0, $mid);
    $right = array_slice($array, $mid);
    $left = mergeSort($left);
    $right = mergeSort($right);
    $temp = [];
    while (count($left) && count($right)) {
        $temp[] = $left[0] < $right[0] ? array_shift($left) : array_shift($right);
    }
    $array = array_merge($temp, $left, $right);
    return $array;
}

function quickSort($array)
{
    $len = count($array);
    if ($len <= 1) {
        return $array;
    }
    $v = $array[0];
    $up = $low = [];
    for ($i = 1; $i < $len; ++$i) {
        $array[$i] > $v ? $up[] = $array[$i] : $low[] = $array[$i];
    }
    $low = quickSort($low);
    $up = quickSort($up);
    return array_merge($low, [$v], $up);
}

/**
 * 获取上层最小整10数 例如 6->10
 * @param $number
 * @return float|int
 */
function getMinimumWholeDecimal($number, $is_carry = true)
{
    if (!is_numeric($number)) return false;
    $number_length = strlen(number_format($number, 2)) - 4;
    $number_length = $number_length - 2;
    if ($number_length <= 0) {
        $number_length = 1;
    }
    if ($is_carry) {
        return ceil($number / pow(10, $number_length)) * pow(10, $number_length);
    } else {
        return floor($number / pow(10, $number_length)) * pow(10, $number_length);
    }
}

/**
 * 	作用：产生随机字符串，不长于32位
 */
function createNoncestr($length = 32)
{
    $chars = "abcdefghijklmnopqrstuvwxyz0123456789";
    $str ="";
    for ( $i = 0; $i < $length; $i++ )  {
        $str.= substr($chars, mt_rand(0, strlen($chars)-1), 1);
    }
    return $str;
}

function is_mobile_number($string) {
    return !!preg_match('/^1[3|4|5|7|8]\d{9}$/', $string);
}

function build_url($url,$param)
{
    if (strpos($url,"?"))
    {
        $temp = explode("?",$url);
        $url = $temp[0];
        parse_str($temp[1],$origin_param);
        $param = array_merge($param,$origin_param);
    }
    $query = http_build_query($param);
    return "{$url}?{$query}";
}

function getCurrentRoute()
{
    $route['route'] = \Illuminate\Support\Facades\Route::currentRouteAction();
    $route_array = explode('\\',$route['route']);
    $c_a = $route_array[count($route_array)-1];
    list($route['controller'],$route['action']) = explode('@',$c_a);
    $route['module'] = count($route_array) == 5 ? $route_array[3] : '';
    return $route;
}

/*
 * php输入毫秒部分的代码
 * */
function msectime() {
    list($msec, $sec) = explode(' ', microtime());
    $msectime =  (float)sprintf('%.0f', (floatval($msec) + floatval($sec)) * 1000);
    return $msectime;
}

/**
 * 计算中文字符串长度d
 * @param string $string 字符串
 * @return number 字符串长度
 */
function utf8_strlen($string = null)
{
    // 将字符串分解为单元
    preg_match_all("/./us", $string, $match);
    // 返回单元个数
    return count($match[0]);
}

/**
 * 获取汉字首字母
 * @param string $s0 汉字
 * @return unknown|string|NULL 返回首字母大写
 */
function getfirstchar($s0)
{
    $fchar = ord($s0{0});
    if ($fchar >= ord("A") and $fchar <= ord("z")) return strtoupper($s0{0});
    $s1 = iconv("UTF-8", "gb2312", $s0);
    $s2 = iconv("gb2312", "UTF-8", $s1);
    if ($s2 == $s0) {
        $s = $s1;
    } else {
        $s = $s0;
    }
    $asc = ord($s{0}) * 256 + ord($s{1}) - 65536;
    if ($asc >= -20319 and $asc <= -20284) return "A";
    if ($asc >= -20283 and $asc <= -19776) return "B";
    if ($asc >= -19775 and $asc <= -19219) return "C";
    if ($asc >= -19218 and $asc <= -18711) return "D";
    if ($asc >= -18710 and $asc <= -18527) return "E";
    if ($asc >= -18526 and $asc <= -18240) return "F";
    if ($asc >= -18239 and $asc <= -17923) return "G";
    if ($asc >= -17922 and $asc <= -17418) return "H";
    if ($asc >= -17417 and $asc <= -16475) return "J";
    if ($asc >= -16474 and $asc <= -16213) return "K";
    if ($asc >= -16212 and $asc <= -15641) return "L";
    if ($asc >= -15640 and $asc <= -15166) return "M";
    if ($asc >= -15165 and $asc <= -14923) return "N";
    if ($asc >= -14922 and $asc <= -14915) return "O";
    if ($asc >= -14914 and $asc <= -14631) return "P";
    if ($asc >= -14630 and $asc <= -14150) return "Q";
    if ($asc >= -14149 and $asc <= -14091) return "R";
    if ($asc >= -14090 and $asc <= -13319) return "S";
    if ($asc >= -13318 and $asc <= -12839) return "T";
    if ($asc >= -12838 and $asc <= -12557) return "W";
    if ($asc >= -12556 and $asc <= -11848) return "X";
    if ($asc >= -11847 and $asc <= -11056) return "Y";
    if ($asc >= -11055 and $asc <= -10247) return "Z";
    return null;
}

/**
 * 获取中文的拼音
 * @param string $zh 中文
 * @return Ambigous <string, unknown, NULL>
 */
function pinyin($zh)
{
    $ret = "";
    $s1 = iconv("UTF-8", "gb2312", $zh);
    $s2 = iconv("gb2312", "UTF-8", $s1);
    if ($s2 == $zh) {
        $zh = $s1;
    }
    for ($i = 0; $i < strlen($zh); $i++) {
        $s1 = substr($zh, $i, 1);
        $p = ord($s1);
        if ($p > 160) {
            $s2 = substr($zh, $i++, 2);
            $ret .= getfirstchar($s2);
        } else {
            $ret .= $s1;
        }
    }
    return $ret;
}

/**
 * 截取中文字符串
 * @param string $string 中文字符串
 * @param int $sublen 截取长度
 * @param int $start 开始长度 默认0
 * @param string $code 编码方式 默认UTF-8
 * @param string $omitted 末尾省略符 默认...
 * @return string
 */
function cut_str($string, $sublen = 100, $start = 0, $code = 'UTF-8', $omitted = '...')
{
    if ($code == 'UTF-8') {
        $pa = "/[\x01-\x7f]|[\xc2-\xdf][\x80-\xbf]|\xe0[\xa0-\xbf][\x80-\xbf]|[\xe1-\xef][\x80-\xbf][\x80-\xbf]|\xf0[\x90-\xbf][\x80-\xbf][\x80-\xbf]|[\xf1-\xf7][\x80-\xbf][\x80-\xbf][\x80-\xbf]/";
        preg_match_all($pa, $string, $t_string);
        if (count($t_string[0]) - $start > $sublen) return join('', array_slice($t_string[0], $start, $sublen)) . $omitted;
        return join('', array_slice($t_string[0], $start, $sublen));
    } else {
        $start = $start * 2;
        $sublen = $sublen * 2;
        $strlen = strlen($string);
        $tmpstr = '';
        for ($i = 0; $i < $strlen; $i++) {
            if ($i >= $start && $i < ($start + $sublen)) {
                if (ord(substr($string, $i, 1)) > 129) {
                    $tmpstr .= substr($string, $i, 2);
                } else {
                    $tmpstr .= substr($string, $i, 1);
                }
            }
            if (ord(substr($string, $i, 1)) > 129) $i++;
        }
        if (strlen($tmpstr) < $strlen) $tmpstr .= $omitted;
        return $tmpstr;
    }
}

/**
 * 通过URL获取页面信息
 * @param string $url 地址
 * @return string 返回页面信息
 */
function get_url($url)
{
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);  //设置访问的url地址
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
    curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);//不输出内容
    $result = curl_exec($ch);
    curl_close($ch);
    return $result;
}

/**
 * 对象转化为数组
 * @param object $obj 对象
 * @return array 数组
 */
function object_to_array($obj)
{
    $_arr = is_object($obj) ? get_object_vars($obj) : $obj;
    foreach ($_arr as $key => $val) {
        $val = (is_array($val) || is_object($val)) ? object_to_array($val) : $val;
        $arr[$key] = $val;
    }
    return $arr;
}

/**
 *    作用：array转xml
 */
function array_to_xml($arr)
{
    $xml = "<xml>";
    foreach ($arr as $key => $val) {
        if (is_numeric($val)) {
            $xml .= "<" . $key . ">" . $val . "</" . $key . ">";
        } else
            $xml .= "<" . $key . "><![CDATA[" . $val . "]]></" . $key . ">";
    }
    $xml .= "</xml>";
    return $xml;
}

/**
 *    作用：将xml转为array
 */
function xml_to_array($xml)
{
    //将XML转为array
    $array_data = json_decode(json_encode(simplexml_load_string($xml, 'SimpleXMLElement', LIBXML_NOCDATA)), true);
    return $array_data;
}

function http_json_post_data($url, $data_string) {
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_POST, 1);
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $data_string);
    curl_setopt($ch, CURLOPT_HTTPHEADER, array(
            "Content-Type: application/json; charset=utf-8",
            "Content-Length: " . strlen($data_string))
    );
    ob_start();
    curl_exec($ch);
    $return_content = ob_get_contents();
    ob_end_clean();
    $return_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    return array($return_code, $return_content);
}

/**
 * 模拟POST提交
 * @param string $url 地址
 * @param string $data 提交的数据
 * @return string 返回结果
 */
function post_url($url, $data)
{
    $curl = curl_init(); // 启动一个CURL会话
    curl_setopt($curl, CURLOPT_URL, $url); // 要访问的地址
    curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, FALSE); // 对认证证书来源的检查
    curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, FALSE); // 从证书中检查SSL加密算法是否存在
    curl_setopt($curl, CURLOPT_USERAGENT, 'Mozilla/5.0 (compatible; MSIE 5.01; Windows NT 5.0)'); // 模拟用户使用的浏览器
    //curl_setopt($curl, CURLOPT_FOLLOWLOCATION, 1); // 使用自动跳转
    //curl_setopt($curl, CURLOPT_AUTOREFERER, 1);    // 自动设置Referer
    curl_setopt($curl, CURLOPT_POST, 1);             // 发送一个常规的Post请求
    curl_setopt($curl, CURLOPT_POSTFIELDS, $data);   // Post提交的数据包x
    curl_setopt($curl, CURLOPT_TIMEOUT, 30);         // 设置超时限制 防止死循环
    curl_setopt($curl, CURLOPT_HEADER, 0);           // 显示返回的Header区域内容
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);   // 获取的信息以文件流的形式返回
    $tmpInfo = curl_exec($curl); // 执行操作
    if(curl_errno($curl))
    {
        echo 'Errno'.curl_error($curl);//捕抓异常
    }
    curl_close($curl); // 关闭CURL会话
    return $tmpInfo; // 返回数据
}

/**
 * 去除多维数组中的空值
 * @author
 * @return mixed
 * @param $arr 目标数组
 * @param array $values 去除的值  默认 去除  '',null,false,0,'0',[]
 */
function filter_array($arr, $values = ['', null, false, 0, '0',[]]) {
    foreach ($arr as $k => $v) {
        if (is_array($v) && count($v)>0) {
            $arr[$k] = filter_array($v, $values);
        }
        foreach ($values as $value) {
            if ($v === $value) {
                unset($arr[$k]);
                break;
            }
        }
    }
    return $arr;
}

/**
 * 	作用：格式化参数，签名过程需要使用
 */
function formatBizQueryParaMap($paraMap, $urlencode = false)
{
    $buff = "";
    ksort($paraMap);
    foreach ($paraMap as $k => $v)
    {
        if($urlencode)
        {
            $v = urlencode($v);
        }
        //$buff .= strtolower($k) . "=" . $v . "&";
        $buff .= $k . "=" . $v . "&";
    }
    $reqPar = '';
    if (strlen($buff) > 0)
    {
        $reqPar = substr($buff, 0, strlen($buff)-1);
    }
    return $reqPar;
}

/**
 * 调用api接口
 * @param url $apiurl api.muxiangdao.cn/Article/articleList
 * @param array $param ['status'=>'1','page'=>'2','pageshow'=>'10'];
 * @param string $format eg:array(arr),object(obj),json;defalut = array
 */
function get_api($apiurl, $param, $format = 'array')
{
    if (is_array($param)) {
        $string = '?';
        foreach ($param as $key => $val) {
            $string .= $key . '=' . $val . '&';
        }
        $param = substr($string, 0, -1);
    }
    $url = $apiurl . $param;
    $json = get_url($url);
    $start = strpos($json, '{');
    $end = -1 * (strlen(strrchr($json, '}')) - 1);
    if ($end) {
        $json = substr($json, $start, $end);
    } else {
        $json = substr($json, $start);
    }
    $obj = json_decode($json);
    $array = json_decode($json, 1);
    switch ($format) {
        case 'array':
            $data = $array;
            break;
        case 'arr':
            $data = $array;
            break;
        case 'obj':
            $data = $obj;
            break;
        case 'object':
            $data = $obj;
            break;
        case 'json':
            $data = $json;
            break;
        default:
            $data = $array;
    }
    return $data;
}

/**
 * 判断手机登录
 * @return boolean
 */
function is_mobile_request()
{
    $_SERVER['ALL_HTTP'] = isset($_SERVER['ALL_HTTP']) ? $_SERVER['ALL_HTTP'] : '';
    $mobile_browser = '0';
    if (preg_match('/(up.browser|up.link|mmp|symbian|smartphone|midp|wap|phone|iphone|ipad|ipod|android|xoom)/i', strtolower($_SERVER['HTTP_USER_AGENT'])))
        $mobile_browser++;
    if ((isset($_SERVER['HTTP_ACCEPT'])) and (strpos(strtolower($_SERVER['HTTP_ACCEPT']), 'application/vnd.wap.xhtml+xml') !== false))
        $mobile_browser++;
    if (isset($_SERVER['HTTP_X_WAP_PROFILE']))
        $mobile_browser++;
    if (isset($_SERVER['HTTP_PROFILE']))
        $mobile_browser++;
    $mobile_ua = strtolower(substr($_SERVER['HTTP_USER_AGENT'], 0, 4));
    $mobile_agents = array(
        'w3c ', 'acs-', 'alav', 'alca', 'amoi', 'audi', 'avan', 'benq', 'bird', 'blac',
        'blaz', 'brew', 'cell', 'cldc', 'cmd-', 'dang', 'doco', 'eric', 'hipt', 'inno',
        'ipaq', 'java', 'jigs', 'kddi', 'keji', 'leno', 'lg-c', 'lg-d', 'lg-g', 'lge-',
        'maui', 'maxo', 'midp', 'mits', 'mmef', 'mobi', 'mot-', 'moto', 'mwbp', 'nec-',
        'newt', 'noki', 'oper', 'palm', 'pana', 'pant', 'phil', 'play', 'port', 'prox',
        'qwap', 'sage', 'sams', 'sany', 'sch-', 'sec-', 'send', 'seri', 'sgh-', 'shar',
        'sie-', 'siem', 'smal', 'smar', 'sony', 'sph-', 'symb', 't-mo', 'teli', 'tim-',
        'tosh', 'tsm-', 'upg1', 'upsi', 'vk-v', 'voda', 'wap-', 'wapa', 'wapi', 'wapp',
        'wapr', 'webc', 'winw', 'winw', 'xda', 'xda-'
    );
    if (in_array($mobile_ua, $mobile_agents))
        $mobile_browser++;
    if (strpos(strtolower($_SERVER['ALL_HTTP']), 'operamini') !== false)
        $mobile_browser++;
    // Pre-final check to reset everything if the user is on Windows
    if (strpos(strtolower($_SERVER['HTTP_USER_AGENT']), 'windows') !== false)
        $mobile_browser = 0;
    // But WP7 is also Windows, with a slightly different characteristic
    if (strpos(strtolower($_SERVER['HTTP_USER_AGENT']), 'windows phone') !== false)
        $mobile_browser++;
    if ($mobile_browser > 0)
        return true;
    else
        return false;
}

/**
 * 删除空格
 * @param string $str
 * @return mixed
 */
function trim_all($string)
{
    $search = array(" ", "　", "\t", "\n", "\r");
    $replace = array("", "", "", "", "");
    return str_replace($search, $replace, $string);
}

/**
 * 阿拉伯数字转化汉字
 * @param number $num 阿拉伯数字
 * @param string $mode
 * @return string 中文数字
 */
function ch_num($num, $mode = true)
{
    $char = array('零', '一', '二', '三', '四', '五', '六', '七', '八', '九');
    //$char = array('零','壹','贰','叁','肆','伍','陆','柒','捌','玖);
    $dw = array('', '十', '百', '千', '', '万', '亿', '兆');
    //$dw = array('','拾','佰','仟','','萬','億','兆');
    $dec = '点';  //$dec = '點';
    $retval = '';
    if ($mode) {
        preg_match_all('/^0*(\d*)\.?(\d*)/', $num, $ar);
    } else {
        preg_match_all('/(\d*)\.?(\d*)/', $num, $ar);
    }
    if ($ar[2][0] != '') {
        $retval = $dec . ch_num($ar[2][0], false); //如果有小数，先递归处理小数
    }
    if ($ar[1][0] != '') {
        $str = strrev($ar[1][0]);
        for ($i = 0; $i < strlen($str); $i++) {
            $out[$i] = $char[$str[$i]];
            if ($mode) {
                $out[$i] .= $str[$i] != '0' ? $dw[$i % 4] : '';
                if ($str[$i] + $str[$i - 1] == 0) {
                    $out[$i] = '';
                }
                if ($i % 4 == 0) {
                    $out[$i] .= $dw[4 + floor($i / 4)];
                }
            }
        }
        $retval = join('', array_reverse($out)) . $retval;
    }
    return $retval;
}

function system_log($title, $content, $type, $level = 0, $operator_type = 'system', $ip = 'unknown', $operator_id = 0)
{
    $system_log = new \App\Http\Models\SystemLog();
    $system_log->type = $type;
    $system_log->level = $level;
    $system_log->title = $title;
    $system_log->content = $content;
    $system_log->operator_type = $operator_type;
    $system_log->operator_id = $operator_id;
    $system_log->ip = $ip;
    $system_log->save();
    return $system_log->id;
}