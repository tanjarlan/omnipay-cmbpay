<?php


namespace Omnipay\CmbPay\Message;


class CreateH5OrderResponse extends \Omnipay\CmbPay\Support\BaseAbstractResponse
{
    /**
     * @return bool
     */
    public function isSuccessful()
    {
        return $this->getData()->getStatusCode() === 200;
    }

    /**
     * @return bool
     */
    public function isRedirect()
    {
        return true;
    }

    public function redirect()
    {
        return $this->getData()->getBody();
    }

    public function getMessage(): ?string
    {
        return $this->getData()->getReasonPhrase();
    }
}
