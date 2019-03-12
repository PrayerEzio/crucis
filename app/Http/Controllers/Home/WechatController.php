<?php

namespace App\Http\Controllers\Home;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class WechatController extends Controller
{
    const TOKEN = "I7RrDS8TdQrQCdZuYSlS1vrRnf2t2Erw";

    public function vail(Request $request)
    {
        $echoStr = $request->echostr;
        if($this->checkSignature($request)){
            echo $echoStr;
        }else {
            echo "false";
        }
        exit();
    }

    private function checkSignature($request)
    {
        $token = self::TOKEN;
        if (!$token) {
            throw new Exception('TOKEN is not defined!');
        }
        $signature = $request->signature;
        $timestamp = $request->timestamp;
        $nonce = $request->nonce;
        $tmpArr = array($token, $timestamp, $nonce);
        // use SORT_STRING rule
        sort($tmpArr, SORT_STRING);
        $tmpStr = implode( $tmpArr );
        $tmpStr = sha1( $tmpStr );
        if( $tmpStr == $signature ){
            return true;
        }else{
            return false;
        }
    }
}
