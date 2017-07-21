<?php
namespace Omnipay\Qfpay;

/**
 * Class Helper
 * @package Omnipay\Qfpay
 */
class Helper
{
    public static function getQueryString($data)
    {
        ksort($data);

        return urldecode(http_build_query($data));
    }

    public static function getSignByDataAndKey($data, $key)
    {
        $query_string = self::getQueryString($data);

        return strtoupper(md5($query_string . $key));
    }

    public static function sendHttpRequest($url, $params)
    {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
        curl_setopt($ch, CURLOPT_SSLVERSION, 3);
        curl_setopt($ch, CURLOPT_TIMEOUT, 10);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array ('Content-type:application/x-www-form-urlencoded;charset=UTF-8'));
        curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($params));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $result = curl_exec($ch);
        curl_close($ch);

        return $result;
    }

    public static function sendRefundHttpRequest($url, $params)
    {
        ob_start();
        $ch = curl_init();
        curl_setopt ($ch, CURLOPT_URL, $url);
        curl_setopt ($ch, CURLOPT_POST, 1);
        curl_setopt ($ch, CURLOPT_POSTFIELDS, http_build_query($params));
        curl_setopt ($ch, CURLOPT_SSL_VERIFYPEER, 0);
        curl_exec ($ch);
        $response = ob_get_contents();
        ob_end_clean();

        $message = "";

        if(strchr($response,"<html>") || strchr($response,"<html>")) {;
            $message = $response;
        } else {
            if (curl_error($ch))
                $message = "%s: s". curl_errno($ch) . "<br/>" . curl_error($ch);
        }

        curl_close ($ch);

        $map = array();
        if (strlen($message) == 0) {
            $pairArray = explode("&", $response);
            foreach ($pairArray as $pair) {
                $param = explode("=", $pair);
                $map[urldecode($param[0])] = urldecode($param[1]);
            }
        }

        return $map;
    }

    /**
     * 2999状态时查询退款是否成功
     *
     * @param $data
     * @return mixed|null
     */
    public static function query ($app_code, $pay_url, $data)
    {
        // 设置Header
        $header = array();
        $header[] = 'X-QF-APPCODE:' . $app_code;
        $header[] = 'X-QF-SIGN:' . $data['sign'];

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $pay_url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $header);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data['query_string']);
        $response = curl_exec($ch);
        curl_close($ch);

        return json_decode($response, JSON_UNESCAPED_UNICODE);
    }
}
