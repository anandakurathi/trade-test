<?php


namespace Src\Controllers;


use Src\Model\Stock;
use Src\Services\View;

class StocksController extends BaseController
{
    /**
     * StocksController constructor.
     */
    public function __construct()
    {
    }


    public function index()
    {
        View::render('stock-list');
    }

    public function stocksByName()
    {
        $params = ($_REQUEST['phrase']) ?: null;
        $stock = new Stock();
        $stockList = $stock->getStocksByName($params);
        echo json_encode($stockList); exit();
    }

    public function stockForecast()
    {
        $stock = new Stock();
        $stockList = $stock->getStockForecast($_POST['stock'],$_POST['startDate'],$_POST['endDate']);
        $suggestedStockToBuy = self::findLowestPrice($stockList);
        View::render('forecast', [
            'forecastData' => $stockList,
            'suggestedStockToBuy' => $suggestedStockToBuy
        ]);
    }

    public function findLowestPrice($stockList)
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
            return $this->findLowestPrice($stockList);
        } else {
            return $stockList[$index];
        }
    }

}