<?php

namespace Omnipay\Qfpay\Message;

use Omnipay\Common\Message\AbstractResponse;

/**
 * Class TradeCompletePurchaseResponse
 * @package Omnipay\Qfpay\Message
 */
class TradeCompletePurchaseResponse extends AbstractResponse
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
        return true;
    }
}
