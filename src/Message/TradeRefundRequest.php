<?php

namespace Omnipay\Qfpay\Message;

use Omnipay\Common\Message\ResponseInterface;
use Omnipay\Qfpay\Helper;

/**
 * Class TradeRefundRequest
 * @package Omnipay\Qfpay\Message
 */
class TradeRefundRequest extends AbstractTradeRequest
{

    /**
     * Get the raw data array for this message. The format of this varies from gateway to
     * gateway, but will usually be either an associative array, or a SimpleXMLElement.
     *
     * @return mixed
     */
    public function getData()
    {
        $this->validate('mchid', 'out_trade_no', 'pay_type', 'txamt', 'txdtm', 'notify_url', 'return_url');

        $data = array(
            'mchid'        => $this->getMchid(),
            'out_trade_no' => $this->getOutTradeNo(),
            'syssn'        => $this->getSyssn(),
            'txamt'        => $this->getTxamt(),
            'txdtm'        => $this->getTxdtm()
        );

        if ($this->getKey()) {
            $data['sign'] = Helper::getSignByDataAndKey($data, $this->getKey());
        }

        $data['query_string'] = Helper::getQueryString($data);

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
        // 设置Header
//        $header = array();
//        $header[] = 'X-QF-APPCODE:' . $this->getAppCode();
//        $header[] = 'X-QF-SIGN:' . $data['sign'];
//
//        $ch = curl_init();
//        curl_setopt($ch, CURLOPT_URL, $this->getPayUrl('refund'));
//        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
//        curl_setopt($ch, CURLOPT_HTTPHEADER, $header);
//        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
//        curl_setopt($ch, CURLOPT_POST, 1);
//        curl_setopt($ch, CURLOPT_POSTFIELDS, $data['query_string']);
//        $response = curl_exec($ch);
//        curl_close($ch);

        $responseData = Helper::query($this->getAppCode(), $this->getPayUrl('refund'), $data);

        if ($responseData['respcd'] == '2999') {
            sleep(3);

            $refundData = array(
                'mchid'        => $this->getMchid(),
                'respcd'        => '0000'
            );

            if ($this->getKey()) {
                $refundData['sign'] = Helper::getSignByDataAndKey($refundData, $this->getKey());
            }

            $refundData['query_string'] = Helper::getQueryString($refundData);

            $refundQueryData = Helper::query($this->getAppCode(), $this->getPayUrl('query'), $refundData);

            if (! in_array($responseData['syssn'],array_column($refundQueryData['data'],'syssn','sysdtm'))) {
                sleep(3);

                $refundQueryData = Helper::query($this->getAppCode(), $this->getPayUrl('query'), $refundData);

                if (in_array($responseData['syssn'],array_column($refundQueryData['data'],'syssn','sysdtm'))) {
                    $responseData['respcd'] = '0000';
                }
            } else {
                $responseData['respcd'] = '0000';
            }
        }

        return $this->response = new TradeResponse($this, $responseData);
    }
}
