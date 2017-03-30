<?php

namespace Omnipay\Qfpay\Message;

use Omnipay\Common\Message\ResponseInterface;
use Omnipay\Qfpay\Helper;

/**
 * Class QfpayCompletePurchaseRequest
 * @package Omnipay\Qfpay\Message
 */
class QfpayCompletePurchaseRequest extends AbstractQfpayRequest
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
        if (isset($data['secureHash']) && $this->getSecurity()) {
            $data['verify_success'] = Helper::verify($this->getRequestParams(), $this->getSecurity());
            $data['is_paid']        = $data['verify_success'] && ($this->getRequestParam('successcode') == '0');
        } else if (! isset($data['secureHash']) && ! $this->getSecurity() && $this->getRequestParam('successcode') == '0') {
            $data['is_paid']        = true;
        } else {
            $data['is_paid']        = false;
        }

        return $this->response = new QfpayCompletePurchaseResponse($this, $data);
    }
}
