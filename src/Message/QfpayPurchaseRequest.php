<?php

namespace Omnipay\Qfpay\Message;

use Omnipay\Common\Message\ResponseInterface;
use Omnipay\Qfpay\Helper;

/**
 * Class QfpayPurchaseRequest
 * @package Omnipay\Qfpay\Message
 */
class QfpayPurchaseRequest extends AbstractQfpayRequest
{

    /**
     * @return mixed
     */
    public function getData()
    {
        $this->validateData();

        $data = array (
            'mchid'     => $this->getMchid(),
            'out_trade_no'         => $this->getOutTradeNo(),
            'pay_type'       => $this->getPayType(),
            'txamt'       => $this->getAmount(),
            'txdtm'        => $this->getTxdtm(),
            'notify_url'     => $this->getSuccessUrl(),
            'return_url'        => $this->getFailUrl()
        );

        $data['query_string'] = Helper::getQueryString($data);

        if ($this->getKey()) {
            $data['sign'] = Helper::getSignByDataAndKey($data, $this->getKey());
        }

        return $data;
    }

    private function validateData()
    {
        $this->validate(
            'mchid',
            'out_trade_no',
            'pay_type',
            'txamt',
            'txdtm',
            'notify_url',
            'return_url'
        );
    }

    /**
     * Send the request with specified data
     *
     * @param  mixed $data The data to send
     *
     * @return ResponseInterface
     */
    public function sendData($data)
    {
        return $this->response = new QfpayPurchaseResponse($this, $data);
    }
}
