<?php

namespace CryptoTrade\App\Api;

use CryptoTrade\App\Currency;

class CoinMC implements CryptoApi
{
    protected string $api;
    protected string $url;

    public function __construct(string $api, string $url)
    {
        $this->api = $api;
        $this->url = $url;
    }

    public function getResponse(): array
    {
        $parameters = [
            'start' => '1',
            'limit' => '5000',
            'convert' => 'USD'
        ];

        $headers = [
            'Accepts: application/json',
            'X-CMC_PRO_API_KEY: ' . $this->api,
        ];
        $qs = http_build_query($parameters);
        $request = "{$this->url}?{$qs}";


        $curl = curl_init();
        curl_setopt_array($curl, [
            CURLOPT_URL => $request,
            CURLOPT_HTTPHEADER => $headers,
            CURLOPT_RETURNTRANSFER => 1
        ]);

        $response = curl_exec($curl);
        $data = json_decode($response);
        $currencies = [];
        foreach ($data->data as $currency) {
            $currencies[] = new Currency(
                $currency->name,
                $currency->symbol,
                $currency->quote->USD->price,
                $currency->quote->USD->percent_change_1h,
                $currency->quote->USD->percent_change_24h,
                $currency->quote->USD->percent_change_7d,
                $currency->quote->USD->market_cap
            );
        }
        curl_close($curl);
        return $currencies;
    }
}
