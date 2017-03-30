<?php

namespace Omnipay\Qfpay\Message;

use Omnipay\Common\Message\AbstractResponse;

/**
 * Class QfpayCompletePurchaseResponse
 * @package Omnipay\Qfpay\Message
 */
class QfpayCompletePurchaseResponse extends AbstractResponse
{

    public function isPaid()
    {
        return $this->data['is_paid'];
    }


    /**
     * Is the response successful?
     *
     * @return boolean
     */
    public function isSuccessful()
    {
        return $this->data['verify_success'];
    }
}
