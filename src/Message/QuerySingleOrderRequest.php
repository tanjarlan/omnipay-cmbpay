<?php


namespace Omnipay\CmbPay\Message;


use Omnipay\CmbPay\Support\Helper;
use Omnipay\Common\Exception\InvalidRequestException;

class QuerySingleOrderRequest extends \Omnipay\CmbPay\Support\BaseAbstractRequest
{
    /**
     * @var string
     */
    protected $endpoint = 'https://merchserv.netpay.cmbchina.com/merchserv/BaseHttp.dll?QuerySingleOrder';

    public function setType($type)
    {
        $this->setParameter('type', $type);
    }

    public function getType()
    {
        return $this->getParameter('type');
    }

    public function setBankSerialNo($bankSerialNo)
    {
        $this->setParameter('bankSerialNo', $bankSerialNo);
    }

    public function getBankSerialNo()
    {
        return $this->getParameter('bankSerialNo');
    }

    public function setOrderNo($orderNo)
    {
        $this->setParameter('orderNo', $orderNo);
    }

    public function getOrderNo()
    {
        return $this->getParameter('orderNo');
    }

    public function setDate($date)
    {
        $this->setParameter('date', $date);
    }

    public function getDate()
    {
        return $this->getParameter('date');
    }

    protected function getOptionalParameterKeys(): array
    {
        return [
            'bankSerialNo',
            'orderNo'
        ];
    }

    /**
     * @return array
     * @throws InvalidRequestException
     */
    public function getData(): array
    {
        $this->validate('branchNo', 'merchantNo', 'date');

        $reqData = [
            'dateTime' => date('YmdHis'),
            'branchNo' => $this->getBranchNo(),
            'merchantNo' => $this->getMerchantNo(),
            'type' => $this->getType(),
            'date' => $this->getDate()
        ];

        $reqData = array_merge($reqData, $this->getOptionalParameters());

        $data = [
            'version' => '2.0',
            'charset' => 'UTF-8',
            'sign' => Helper::sign($reqData, $this->getMerchantKey()),
            'signType' => 'SHA-256',
            'reqData' => $reqData
        ];

        return ['jsonRequestData' => json_encode($data)];
    }

    /**
     * @param mixed $data
     * @return QuerySingleOrderResponse
     */
    public function sendData($data): QuerySingleOrderResponse
    {
        if ($this->getTestMode()) {
            $this->endpoint = 'http://121.15.180.66:801/netpayment_directlink_nosession/BaseHttp.dll?QuerySingleOrder';
        }

        $response = $this->sendRequest('POST', $this->endpoint, $data)->getBody()->getContents();

        return $this->response = new QuerySingleOrderResponse($this, $response);
    }
}
