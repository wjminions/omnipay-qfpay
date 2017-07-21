<?php

namespace Omnipay\Qfpay\Message;

use Omnipay\Common\Message\ResponseInterface;
use Omnipay\Qfpay\Helper;

/**
 * Class TradeQueryRequest
 * @package Omnipay\Qfpay\Message
 */
class TradeQueryRequest extends AbstractTradeRequest
{

    /**
     * Get the raw data array for this message. The format of this varies from gateway to
     * gateway, but will usually be either an associative array, or a SimpleXMLElement.
     *
     * @return mixed
     */
    public function getData()
    {
        $this->validate('syssn');

        $data = array(
            'syssn'        => $this->getSyssn()
        );

        return $data;
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
        $query = array(
            'mchid'        => $this->getMchid(),
            'respcd'        => '0000'
        );

        if ($this->getKey()) {
            $query['sign'] = Helper::getSignByDataAndKey($query, $this->getKey());
        }

        $query['query_string'] = Helper::getQueryString($query);

        sleep(3);

        $queryData = Helper::query($this->getAppCode(), $this->getPayUrl('query'), $query);

        foreach ($queryData['data'] as $value) {
            if ($data['syssn'] == $value['syssn']) {
                $data = $value;
                break;
            }
        }

        return $data;
    }
}
