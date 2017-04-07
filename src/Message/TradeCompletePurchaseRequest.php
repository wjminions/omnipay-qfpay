<?php

namespace Omnipay\Qfpay\Message;

use Omnipay\Common\Message\ResponseInterface;
use Omnipay\Qfpay\Helper;

/**
 * Class TradeCompletePurchaseRequest
 * @package Omnipay\Qfpay\Message
 */
class TradeCompletePurchaseRequest extends AbstractTradeRequest
{

    /**
     * Get the raw data array for this message. The format of this varies from gateway to
     * gateway, but will usually be either an associative array, or a SimpleXMLElement.
     *
     * @return mixed
     */
    public function getData()
    {
        return $this->getRequestParams();
    }


    public function setRequestParams($value)
    {
        $this->setParameter('request_params', $value);
    }


    public function getRequestParams()
    {
        return $this->getParameter('request_params');
    }


    public function getRequestParam($key)
    {
        $params = $this->getRequestParams();
        if (isset($params[$key])) {
            return $params[$key];
        } else {
            return null;
        }
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
        return $this->response = new TradeCompletePurchaseResponse($this, $data);
    }
}
