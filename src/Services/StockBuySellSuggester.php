<?php


namespace Src\Services;


class StockBuySellSuggester
{
    public function bestPriceToBuy($stockList)
    {
        $prices = array_column($stockList, 'stock_price');
        $index =  array_search(min($prices), $prices);

        if($index === 0) {
            // continues price drop case
            $sorted = array_values($prices);
            sort($sorted);
            if ( $prices === $sorted ) {
                return [];
            }
            // initial price drop case
            unset($stockList[0]);
            $stockList = array_values($stockList);
            return self::bestPriceToBuy($stockList);
        } else {
            return $stockList[$index];
        }
    }

    public function bestPriceToSell($stockList, $purchasePrice)
    {
        if(!$stockList) {
            return;
        }
        $prices = array_column($stockList, 'stock_price');
        $index =  array_search(max($prices), $prices);
        return $stockList[$index];
    }
}