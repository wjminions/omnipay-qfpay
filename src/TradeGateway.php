<?php

namespace Omnipay\Qfpay;

use Omnipay\Common\AbstractGateway;

/**
 * Class TradeGateway
 * @package Omnipay\Qfpay
 */
class TradeGateway extends AbstractGateway
{

    /**
     * Get gateway display name
     *
     * This can be used by carts to get the display name for each gateway.
     */
    public function getName()
    {
        return 'Qfpay_Trade';
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


    public function purchase(array $parameters = array())
    {
        return $this->createRequest('\Omnipay\Qfpay\Message\TradePurchaseRequest', $parameters);
    }


    public function completePurchase(array $parameters = array())
    {
        return $this->createRequest('\Omnipay\Qfpay\Message\TradeCompletePurchaseRequest', $parameters);
    }

    public function refund(array $parameters = array())
    {
        return $this->createRequest('\Omnipay\Qfpay\Message\TradeRefundRequest', $parameters);
    }

    public function query(array $parameters = array())
    {
        return $this->createRequest('\Omnipay\Qfpay\Message\TradeQueryRequest', $parameters);
    }
}
