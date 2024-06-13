<?php
namespace CryptoTrade\App;

use CryptoTrade\App\Api\CoinMC;
use CryptoTrade\App\Api\CryptoApi;

class Tasks
{
    private CryptoApi $cryptoApi;
    public function __construct(string $ap)
    {
        $this->cryptoApi = new CoinMC($api);
    }
    private function latest(): array
    {
        $cryptoList = $this->cryptoApi->getResponse();
        $latest = [];
        $number = 1;
        foreach ($cryptoList as $item) {
            $latest[] = [
                'number' => $number,
                'name' => $item->getName()
            ];
            $number++;
            if($number > 10){
                break;
            }
        }

        return $latest;
    }

    private function search(): array
    {
        $searchInfo = [];
        $userSymbol = strtoupper(readline("Enter crypto symbol to search: "));
        $cryptoList = $this->cryptoApi->getResponse();
        foreach ($cryptoList as $item) {
            if ($userSymbol === $item->getSymbol()) {
                $searchInfo[] = [
                    "name" => $item->getName(),
                    "symbol" => $item->getSymbol(),
                    "price" => number_format($item->getPrice(),2, '.', ','),
                    "oneHour" => round($item->getOneHour(), 2),
                    "twentyFourHour" => round($item->getTwentyFourHour(), 2),
                    "sevenDays" => round($item->getSevenDays(), 2),
                    "marketCap" => number_format($item->getMarketCap(),0, '.', ',')
                ];
            }
        }
        return $searchInfo;
    }

    public function getLatest(): array
    {
        return $this->latest();
    }

    public function getSearch(): array
    {
        return $this->search();
    }
}
