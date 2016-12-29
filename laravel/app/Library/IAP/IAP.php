<?php

namespace App\Library\IAP;

use Exception;

class IAP
{
    public static function getReceiptData($receipt, $isSandbox = false): array
    {
        if ($isSandbox) {
            $endPoint = 'https://sandbox.itunes.apple.com/verifyReceipt';
        } else {
            $endPoint = 'https://buy.itunes.apple.com/verifyReceipt';
        }

        $postData = json_encode(
            array('receipt-data' => $receipt)
        );

        $ch = curl_init($endPoint);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $postData);
        curl_setopt ($ch, CURLOPT_SSL_VERIFYPEER, 0);
        curl_setopt ($ch, CURLOPT_SSL_VERIFYHOST, 0);

        $response = curl_exec($ch);
        $errno = curl_errno($ch);
        $error = curl_error($ch);
        curl_close($ch);

        if ($errno != 0) {
            throw new Exception($error, $errno);
        }

        $data = json_decode($response);
        $receipt = $data->receipt->in_app[0];

        if (! is_object($data)) {
            throw new Exception('Invalid response data');
        }

        if (! isset($data->status) || $data->status != 0) {
            throw new Exception('Invalid receipt');
        }

        return array(
            'quantity' => $receipt->quantity,
            'productId' => $receipt->product_id,
            'transactionId' => $receipt->transaction_id,
            'purchaseDate' => $receipt->purchase_date
        );
    }
}
