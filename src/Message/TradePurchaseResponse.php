<?php

namespace Omnipay\Qfpay\Message;

use Omnipay\Common\Message\AbstractResponse;
use Omnipay\Common\Message\RedirectResponseInterface;
use Omnipay\Qfpay\Helper;

/**
 * Class TradePurchaseResponse
 * @package Omnipay\Qfpay\Message
 */
class TradePurchaseResponse extends AbstractResponse implements RedirectResponseInterface
{

    public function isSuccessful()
    {
        return true;
    }

    public function isRedirect()
    {
        return true;
    }

    public function getRedirectUrl()
    {
        return false;
    }

    public function getRedirectMethod()
    {
        return 'POST';
    }

    public function getRedirectData()
    {
        return $this->data;
    }

    public function getRedirectHtml()
    {
        $data = $this->data;

        // 设置Header
        $header = array();
        $header[] = 'X-QF-APPCODE:' . $this->getRequest()->getAppCode();
        $header[] = 'X-QF-SIGN:' . $data['sign'];

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $this->getRequest()->getPayUrl());
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $header);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data['query_string']);
        $response = curl_exec($ch);
        curl_close($ch);

        $responseData = json_decode($response, true);

        if (! isset($responseData['pay_url'])) {
            throw new  \Exception('Error: missing pay_url parameter');
        }

        return "<script>top.location.href='" . $responseData['pay_url'] . "';</script>";
    }
}
