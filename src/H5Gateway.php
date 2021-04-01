<?php


namespace Omnipay\CmbPay;


use Omnipay\CmbPay\Message\CreateH5OrderRequest;
use Omnipay\CmbPay\Message\QueryPublicKeyRequest;
use Omnipay\CmbPay\Message\RefundRequest;
use Omnipay\CmbPay\Support\BaseGateway;
use Omnipay\CmbPay\Support\Helper;
use Omnipay\Common\Message\AbstractRequest;
use Omnipay\Common\Message\RequestInterface;

class H5Gateway extends BaseGateway
{
    /**
     * @return string
     */
    public function getName(): string
    {
        return 'CmbPay H5';
    }

    /**
     * @param array $options
     * @return AbstractRequest|RequestInterface
     */
    public function purchase(array $options = array())
    {
        return $this->createRequest(CreateH5OrderRequest::class, $options);
    }

    /**
     * @param $sign
     * @param $data
     * @return bool
     */
    public function verify($sign, $data): bool
    {
        $response = $this->createRequest(QueryPublicKeyRequest::class, $this->getParameters())->send();
        return Helper::verify($response->getPublicKey(), $sign, $data);
    }

    /**
     * @param array $options
     * @return RequestInterface
     */
    public function refund(array $options = array())
    {
        return $this->createRequest(RefundRequest::class, $options);
    }

    /**
     * @param $endpoint
     */
    public function setEndpoint($endpoint)
    {
        $this->setParameter('endpoint', $endpoint);
    }

    /**
     * @param $clientIp
     */
    public function setClientIp($clientIp)
    {
        $this->setParameter('clientIP', $clientIp);
    }

    /**
     * @param $cardType
     */
    public function setCardType($cardType)
    {
        $this->setParameter('cardType', $cardType);
    }

    /**
     * @param $agrNo
     */
    public function setAgrNo($agrNo)
    {
        $this->setParameter('agrNo', $agrNo);
    }

    /**
     * @param $merchantSerialNo
     */
    public function setMerchantSerialNo($merchantSerialNo)
    {
        $this->setParameter('merchantSerialNo', $merchantSerialNo);
    }

    /**
     * @param $userId
     */
    public function setUserId($userId)
    {
        $this->setParameter('userID', $userId);
    }

    /**
     * @param $mobile
     */
    public function setMobile($mobile)
    {
        $this->setParameter('mobile', $mobile);
    }

    /**
     * @param $lon
     */
    public function setLon($lon)
    {
        $this->setParameter('lon', $lon);
    }

    /**
     * @param $lat
     */
    public function setLat($lat)
    {
        $this->setParameter('lat', $lat);
    }

    /**
     * @param $riskLevel
     */
    public function setRiskLevel($riskLevel)
    {
        $this->setParameter('riskLevel', $riskLevel);
    }

    /**
     * @param $signNoticeUrl
     */
    public function setSignNoticeUrl($signNoticeUrl)
    {
        $this->setParameter('signNoticeUrl', $signNoticeUrl);
    }

    /**
     * @param $extendInfo
     */
    public function setExtendInfo($extendInfo)
    {
        $this->setParameter('extendInfo', $extendInfo);
    }

    /**
     * @param $extendInfoEncrypType
     */
    public function setExtendInfoEncrypType($extendInfoEncrypType)
    {
        $this->setParameter('extendInfoEncrypType', $extendInfoEncrypType);
    }

    /**
     * @param $refundSerialNo
     */
    public function setRefundSerialNo($refundSerialNo)
    {
        $this->setParameter('refundSerialNo', $refundSerialNo);
    }
}
