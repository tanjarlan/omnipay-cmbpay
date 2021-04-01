<?php


namespace Omnipay\CmbPay\Message;


use Omnipay\CmbPay\Support\Helper;
use Omnipay\Common\Message\ResponseInterface;

class RefundRequest extends \Omnipay\CmbPay\Support\BaseAbstractRequest
{
    /**
     * @var string
     */
    protected $endpoint = 'https://merchserv.netpay.cmbchina.com/merchserv/BaseHttp.dll?DoRefundV2';

    /**
     * @param $refundSerialNo
     */
    public function setRefundSerialNo($refundSerialNo)
    {
        $this->setParameter('refundSerialNo', $refundSerialNo);
    }

    /**
     * @return mixed
     */
    public function getRefundSerialNo()
    {
        return $this->getParameter('refundSerialNo');
    }

    /**
     * @inheritDoc
     */
    public function getData()
    {
        $this->validate('branchNo', 'merchantNo');

        $reqData = [
            'dateTime' => date('YmdHis'),
            'branchNo' => $this->getBranchNo(),
            'merchantNo' => $this->getMerchantNo(),
            'date' => date('Ymd'),
            'orderNo' => $this->getOrderNo(),
            'refundSerialNo' => $this->getRefundSerialNo(),
            'amount' => $this->getAmount()
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
        if ($this->getTestMode()) {
            $this->endpoint = 'http://121.15.180.66:801/netpayment_directlink_nosession/BaseHttp.dll?DoRefundV2';
        }

        $response = $this->sendRequest('POST', $this->endpoint, $data)->getBody()->getContents();

        return $this->response = new RefundResponse($this, $response);
    }

    protected function getOptionalParameterKeys(): array
    {
        return [];
    }
}
