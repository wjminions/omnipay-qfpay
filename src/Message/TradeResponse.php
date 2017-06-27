<?php

namespace Omnipay\Qfpay\Message;

use Omnipay\Common\Message\AbstractResponse;

/**
 * Class TradeResponse
 * @package Omnipay\Qfpay\Message
 */
class TradeResponse extends AbstractResponse
{
    public function isRedirect()
    {
        return false;
    }


    public function getRedirectMethod()
    {
        return 'POST';
    }


    public function getRedirectUrl()
    {
        return false;
    }


    public function getRedirectHtml()
    {
        return false;
    }


    public function getTransactionNo()
    {
        return isset($this->data['syssn']) ? $this->data['syssn'] : '';
    }


    public function isPaid()
    {
        if ($this->data['respcd'] == '0000') {
            return true;
        }

        return false;
    }


    /**
     * Is the response successful?
     *
     * @return boolean
     */
    public function isSuccessful()
    {
        if ($this->data['respcd'] == '0000') {
            return true;
        }

        return false;
    }

    public function getMessage()
    {
        return isset($this->data['respMsg']) ? $this->data['respMsg'] : '';
    }
}
