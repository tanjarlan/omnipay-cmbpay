<?php


namespace Omnipay\CmbPay\Support;


class Helper
{
    /**
     * 参数签名
     *
     * @param $data
     * @param $merchantKey
     * @return string
     */
    public static function sign($data, $merchantKey): string
    {
        ksort($data);

        $strToSign = urldecode(http_build_query($data));
        $strToSign .= '&' . $merchantKey;

        //SHA-256签名
        $baSrc = mb_convert_encoding($strToSign, "UTF-8");
        return hash('sha256', $baSrc);
    }

    /**
     * 参数验签
     *
     * @param $publicKey
     * @param $sign
     * @param $data
     * @return bool
     */
    public static function verify($publicKey, $sign, $data)
    {
        $pem = chunk_split($publicKey, 64, "\n");
        $pem = "-----BEGIN PUBLIC KEY-----\n" . $pem . "-----END PUBLIC KEY-----\n";
        $publicKeyId = openssl_pkey_get_public($pem);
        if (empty($publicKeyId)) {
            die('获取 pkey 失败');
        }

        ///
        ksort($data);
        $strToSign = urldecode(http_build_query($data));
        $ok = openssl_verify($strToSign, base64_decode($sign), $publicKeyId, OPENSSL_ALGO_SHA1);
        return $ok == 1;
    }
}
