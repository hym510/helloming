<?php

namespace App\Library\IAP;

use Exception;
use App\Models\{Diamond, Order, User};

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
            'purchaseDate' => date('Y/m/d H:i:s', ($receipt->purchase_date_ms / 1000))
        );
    }

    public static function success($userId, array $data)
    {
        $diamond = Diamond::get(['product_id', 'quantity'])->toArray();

        $length = count($diamond);

        for ($i = 0; $i < $length; $i++) {
            if ($diamond[$i]['product_id'] == $data['productId']) {
                Order::create([
                    'user_id' => $userId,
                    'quantity' => $data['quantity'],
                    'product_id' => $data['productId'],
                    'transaction_id' => $data['transactionId'],
                    'purchase_date' => $data['purchaseDate']
                ]);

                User::replenishDiamond($userId, $diamond[$i]['quantity']);
            }
        }
    }
}
