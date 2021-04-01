<?php


namespace Omnipay\CmbPay\Message;


use Omnipay\CmbPay\Support\Helper;
use Omnipay\Common\Message\ResponseInterface;

class QueryPublicKeyRequest extends \Omnipay\CmbPay\Support\BaseAbstractRequest
{
    protected $endpoint = 'https://b2b.cmbchina.com/CmbBank_B2B/UI/NetPay/DoBusiness.ashx';

    /**
     * @inheritDoc
     */
    public function getData()
    {
        $this->validate('branchNo', 'merchantNo');

        $reqData = [
            'dateTime' => date('YmdHis'),
            'txCode' => 'FBPK',
            'branchNo' => $this->getBranchNo(),
            'merchantNo' => $this->getMerchantNo()
        ];

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
        if ($this->getTestMode()) {
            $this->endpoint = 'http://mobiletest.cmburl.cn/CmbBank_B2B/UI/NetPay/DoBusiness.ashx';
        }

        $response = $this->sendRequest('POST', $this->endpoint, $data)->getBody()->getContents();

        return $this->response = new QueryPublicKeyResponse($this, $response);
    }
}
