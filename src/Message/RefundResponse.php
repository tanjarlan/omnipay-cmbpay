<?php


namespace Omnipay\CmbPay\Message;


class RefundResponse extends \Omnipay\CmbPay\Support\BaseAbstractResponse
{

    /**
     * @inheritDoc
     */
    public function isSuccessful()
    {
        $content = json_decode($this->getData(), true);

        return $content['rspData']['rspCode'] == 'SUC0000';
    }

    /**
     * @return mixed|string|null
     */
    public function getCode()
    {
        $content = json_decode($this->getData(), true);

        return $content['rspData']['rspCode'];
    }

    public function getMessage()
    {
        $content = json_decode($this->getData(), true);
        return $content['rspData']['rspMsg'];
    }
}
