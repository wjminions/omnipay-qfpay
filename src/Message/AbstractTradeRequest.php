<?php

namespace Omnipay\Qfpay\Message;

use Omnipay\Common\Message\AbstractRequest;
use Omnipay\Qfpay\Helper;

/**
 * Class AbstractTradeRequest
 * @package Omnipay\Qfpay\Message
 */
abstract class AbstractTradeRequest extends AbstractRequest
{
    protected $production = 'https://osqt.qfpay.com/';
    protected $sandbox = 'https://osqt.qfpay.com/';

    protected $methods = array (
        'payment' => 'trade/v1/payment',
        'close'  => 'trade/v1/close',
        'refund'   => 'trade/v1/refund',
        'reversal' => 'trade/v1/reversal',
        'query' => 'trade/v1/query',
    );

    public function getPayUrl($type)
    {
        if ($this->getParameter('environment') == 'production') {
            return $this->production . $this->methods[$type];
        } else {
            return $this->sandbox . $this->methods[$type];
        }
    }

    public function setEnvironment($value)
    {
        return $this->setParameter('environment', $value);
    }


    public function getEnvironment()
    {
        return $this->getParameter('environment');
    }

    public function setMchid($value)
    {
        return $this->setParameter('mchid', $value);
    }


    public function getMchid()
    {
        return $this->getParameter('mchid');
    }

    public function setAppCode($value)
    {
        return $this->setParameter('app_code', $value);
    }


    public function getAppCode()
    {
        return $this->getParameter('app_code');
    }

    public function setKey($value)
    {
        return $this->setParameter('key', $value);
    }


    public function getKey()
    {
        return $this->getParameter('key');
    }

    public function setReturnUrl($value)
    {
        return $this->setParameter('return_url', $value);
    }


    public function getReturnUrl()
    {
        return $this->getParameter('return_url');
    }

    public function setNotifyUrl($value)
    {
        return $this->setParameter('notify_url', $value);
    }


    public function getNotifyUrl()
    {
        return $this->getParameter('notify_url');
    }

    public function setOutTradeNo($value)
    {
        return $this->setParameter('out_trade_no', $value);
    }


    public function getOutTradeNo()
    {
        return $this->getParameter('out_trade_no');
    }

    public function setPayType($value)
    {
        return $this->setParameter('pay_type', $value);
    }


    public function getPayType()
    {
        return $this->getParameter('pay_type');
    }

    public function setTxamt($value)
    {
        return $this->setParameter('txamt', $value);
    }


    public function getTxamt()
    {
        return $this->getParameter('txamt');
    }


    public function setTxdtm($value)
    {
        return $this->setParameter('txdtm', $value);
    }


    public function getTxdtm()
    {
        return $this->getParameter('txdtm');
    }


    public function setSyssn($value)
    {
        return $this->setParameter('syssn', $value);
    }


    public function getSyssn()
    {
        return $this->getParameter('syssn');
    }
}
