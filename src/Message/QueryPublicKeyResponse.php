<?php


namespace Omnipay\CmbPay\Message;


class QueryPublicKeyResponse extends \Omnipay\CmbPay\Support\BaseAbstractResponse
{

    /**
     * @inheritDoc
     */
    public function isSuccessful()
    {
        $content = json_decode($this->getData(), true);

        return $content['rspData']['rspCode'] == 'SUC0000';
    }

    public function getPublicKey()
    {
        if ($this->isSuccessful()) {
            $content = json_decode($this->getData(), true);
            return $content['rspData']['fbPubKey'];
        }

        return null;
    }
}
