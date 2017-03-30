<?php

namespace Omnipay\Qfpay\Message;

use Omnipay\Common\Message\AbstractResponse;
use Omnipay\Common\Message\RedirectResponseInterface;
use Omnipay\Qfpay\Helper;

/**
 * Class QfpayPurchaseResponse
 * @package Omnipay\Qfpay\Message
 */
class QfpayPurchaseResponse extends AbstractResponse implements RedirectResponseInterface
{

    public function isSuccessful()
    {
        return true;
    }

    public function isRedirect()
    {
        return true;
    }

    public function getRedirectMethod()
    {
        return 'POST';
    }

    public function getRedirectHtml()
    {
        var_dump($this->data);die;


        $data = $this->data;

        // 设置Header
        $header = array();
        $header[] = 'X-QF-APPCODE:' . $this->getRequest()->getParameters('app_code');
        $header[] = 'X-QF-SIGN:' . $sign;

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $header);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data['query_string']);
        $output = curl_exec($ch);
        curl_close($ch);



    }
}
