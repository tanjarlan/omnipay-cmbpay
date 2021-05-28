<?php


namespace Omnipay\CmbPay\Support;


use Omnipay\Common\Message\AbstractRequest;

abstract class BaseAbstractRequest extends AbstractRequest
{
    public function setBranchNo($branchNo)
    {
        $this->setParameter('branchNo', $branchNo);
    }

    public function getBranchNo()
    {
        return $this->getParameter('branchNo');
    }

    public function setMerchantNo($merchantNo)
    {
        $this->setParameter('merchantNo', $merchantNo);
    }

    public function getMerchantNo()
    {
        return $this->getParameter('merchantNo');
    }

    public function setMerchantKey($merchantKey)
    {
        $this->setParameter('merchantKey', $merchantKey);
    }

    public function getMerchantKey()
    {
        return $this->getParameter('merchantKey');
    }

    public function setOrderNo($orderNo)
    {
        $this->setParameter('orderNo', $orderNo);
    }

    public function getOrderNo()
    {
        return $this->getParameter('orderNo');
    }

    public function getAmount()
    {
        return $this->getParameter('amount');
    }

    public function setPayNoticeUrl($payNoticeUrl)
    {
        $this->setParameter('payNoticeUrl', $payNoticeUrl);
    }

    public function getPayNoticeUrl()
    {
        return $this->getParameter('payNoticeUrl');
    }

    public function setExpireTimeSpan($expireTimeSpan)
    {
        $this->setParameter('expireTimeSpan', $expireTimeSpan);
    }

    public function getExpireTimeSpan()
    {
        return $this->getParameter('expireTimeSpan');
    }

    public function setPayNoticePara($payNoticePara)
    {
        $this->setParameter('payNoticePara', $payNoticePara);
    }

    public function getPayNoticePara()
    {
        return $this->getParameter('payNoticePara');
    }

    /**
     * @param $method
     * @param $endpoint
     * @param $data
     * @param array $headers
     * @return \Psr\Http\Message\ResponseInterface
     */
    protected function sendRequest($method, $endpoint, $data, $headers = [])
    {
        if ('GET' !== strtoupper($method)) {
            $headers = array_merge($headers, ['Content-Type' => 'application/x-www-form-urlencoded']);
        }

        return $this->httpClient->request(
            $method,
            $endpoint,
            $headers,
            http_build_query($data)
        );
    }

    /**
     * 获取可选参数
     *
     * @return array
     */
    protected function getOptionalParameters(): array
    {
        $params = [];
        $keys = $this->getOptionalParameterKeys();
        if (!empty($keys)) {
            foreach ($keys as $key) {
                $this->getParameter($key) == null ?: $params[$key] = $this->getParameter($key);
            }
        }

        return $params;
    }

    /**
     * 声明可选参数，返回可选参数key数组
     *
     * @return array
     */
    abstract protected function getOptionalParameterKeys(): array;
}
