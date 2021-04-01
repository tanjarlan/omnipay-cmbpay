<?php


namespace Omnipay\CmbPay\Message;


use Omnipay\CmbPay\Support\Helper;

class CreateH5OrderRequest extends \Omnipay\CmbPay\Support\BaseAbstractRequest
{
    /**
     * CMB H5 Gateway Endpoint
     * @var string
     */
    protected $endpoint = 'https://netpay.cmbchina.com/netpayment/BaseHttp.dll?MB_EUserPay';

    /**
     * @param $endpoint
     */
    public function setEndpoint($endpoint)
    {
        $this->setParameter('endpoint', $endpoint);
        $this->endpoint = $endpoint;
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

    /**
     * @return array
     * @throws \Omnipay\Common\Exception\InvalidRequestException
     */
    public function getData()
    {
        // 验证必要参数
        $this->validate(
            'branchNo',
            'merchantNo',
            'orderNo',
            'amount',
            'expireTimeSpan',
            'payNoticeUrl'
        );

        // 构建必要参数
        $reqData = [
            'dateTime' => date('YmdHis'),
            'branchNo' => $this->getBranchNo(),
            'merchantNo' => $this->getMerchantNo(),
            'date' => date('Ymd'),
            'orderNo' => $this->getOrderNo(),
            'amount' => $this->getAmount(),
            'expireTimeSpan' => $this->getExpireTimeSpan(),
            'payNoticeUrl' => $this->getPayNoticeUrl()
        ];

        // 合并参数
        $reqData = array_merge($reqData, $this->getOptionalParameters());

        $data = [
            'version' => '1.0',
            'charset' => 'UTF-8',
            'sign' => Helper::sign($reqData, $this->getMerchantKey()),
            'signType' => 'SHA-256',
            'reqData' => $reqData
        ];

        return ['jsonRequestData' => json_encode($data)];
    }

    /**
     * @inheritDoc
     */
    public function sendData($data)
    {
        $response = $this->sendRequest('POST', $this->endpoint, $data);

        return $this->response = new CreateH5OrderResponse($this, $response);
    }

    /**
     * @return string[]
     */
    protected function getOptionalParameterKeys(): array
    {
        return [
            'returnUrl',
            'payNoticePara',
            'returnUrl',
            'clientIP',
            'cardType',
            'agrNo',
            'merchantSerialNo',
            'userID',
            'mobile',
            'lon',
            'lat',
            'riskLevel',
            'signNoticeUrl',
            'signNoticePara',
            'extendInfo',
            'extendInfoEncrypType'
        ];
    }
}
