<?php


namespace Omnipay\CmbPay\Message;


class QuerySingleOrderResponse extends \Omnipay\CmbPay\Support\BaseAbstractResponse
{
    /**
     * @return bool
     */
    public function isSuccessful(): bool
    {
        $content = json_decode($this->getData(), true);

        return $content['rspData']['rspCode'] == 'SUC0000';
    }

    /**
     * @return mixed
     */
    public function getResult()
    {
        return json_decode($this->getData(), true);
    }
}
