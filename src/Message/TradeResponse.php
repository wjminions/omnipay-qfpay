<?php

namespace Omnipay\Qfpay\Message;

use Omnipay\Common\Message\AbstractResponse;

/**
 * Class TradeResponse
 * @package Omnipay\Qfpay\Message
 */
class TradeResponse extends AbstractResponse
{

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
}
