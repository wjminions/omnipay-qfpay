<?php

namespace Omnipay\Qfpay\Message;

use Omnipay\Common\Message\ResponseInterface;
use Omnipay\Qfpay\Helper;

/**
 * Class TradePurchaseRequest
 *
 * @package Omnipay\Qfpay\Message
 */
class TradePurchaseRequest extends AbstractTradeRequest
{

    /**
     * @return mixed
     */
    public function getData()
    {
        $this->validateData();

        $data = array(
            'mchid'        => $this->getMchid(),
            'out_trade_no' => $this->getOutTradeNo(),
            'pay_type'     => $this->getPayType(),
            'txamt'        => $this->getTxamt(),
            'txdtm'        => $this->getTxdtm(),
            'notify_url'   => $this->getNotifyUrl(),
            'return_url'   => $this->getReturnUrl()
        );

        if ($this->getKey()) {
            $data['sign'] = Helper::getSignByDataAndKey($data, $this->getKey());
        }

        $data['query_string'] = Helper::getQueryString($data);

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
     * @return ResponseInterface
     */
    public function sendData($data)
    {
        return $this->response = new TradePurchaseResponse($this, $data);
    }
}
