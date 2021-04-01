# Omnipay:CmbPay

**CmbPay driver for the Omnipay PHP payment processing library**

[Omnipay](https://github.com/omnipay/omnipay) is a framework agnostic, multi-gateway payment
processing library for PHP 5.3+. This package implements WechatPay support for Omnipay.

## Installation

Omnipay is installed via [Composer](http://getcomposer.org/). To install:

    composer require tanjarlan/omnipay-cmbpay

## Basic Usage

The following gateways are provided by this package:

* CmbPay_H5 (Cmb H5 Gateway) 招行支付H5网关
* Coming soon...

## Usage

### Create Order [doc](http://openhome.cmbchina.com/PayNew/pay/doc/cell/H5/OneCardPayAPI)

```php
//gateways: CmbPay_H5, ...
$gateway    = Omnipay::create('CmbPay_H5');
$gateway->setBranchNo($config['branchNo']);
$gateway->setMerchantNo($config['merchantNo']);
$gateway->setMerchantKey($config['merchantKey']);

$order = [
    'orderNo' => '202104011000000002',
    'amount' => '0.01'
];

$request  = $gateway->purchase($order);
$response = $request->send();

if ($response->isSuccessful()) {
    return $response->redirect();
} else {
    return $response->getMessage();
}
```

### Refund [doc](http://openhome.cmbchina.com/PayNew/pay/doc/cell/H5/RefundAPI)

```php
$response = $gateway->refund([
    'orderNo' => '202104011000000002',
    'amount' => '0.01',
    'refundSerialNo' => 'RFD0002'
])->send();

if ($response->isSuccessful()) {
    return 'refund success';
}

return $response->getMessage();
```
