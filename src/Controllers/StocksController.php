<?php


namespace Src\Controllers;


use Src\Model\Stock;
use Src\Services\StockBuySuggester;
use Src\Services\View;

class StocksController extends BaseController
{
    public function index()
    {
        View::render('stock-list');
    }

    public function stocksByName()
    {
        $params = ($_REQUEST['phrase']) ?: null;
        $stock = new Stock();
        $stockList = $stock->getStocksByName($params);
        echo json_encode($stockList);
        exit();
    }

    public function stockForecast()
    {
        $stock = new Stock();
        $stockList = $stock->getStockForecast(
            $_POST['stock'],
            $_POST['startDate'],
            $_POST['endDate']
        );
        $buySuggester = new StockBuySuggester();
        $suggestedStockToBuy = $buySuggester->bestPriceToBuy($stockList);
        View::render(
            'forecast',
            [
                'forecastData' => $stockList,
                'suggestedStockToBuy' => $suggestedStockToBuy
            ]
        );
    }

    public function viewSelectedStock()
    {
        $stockId = $_POST['stockId'];
        $stock = new Stock();
        $stockInfo = $stock->getStockById($stockId);
        $stockList = $stock->getStockForecast(
            $stockInfo['stock_name'],
            $_POST['startDate'],
            $_POST['endDate']
        );
        $buySuggester = new StockBuySuggester();
        $suggestedStockToBuy = $buySuggester->bestPriceToBuy($stockList);
        View::render('buy-stock', [
            'stockInfo' => $stockInfo,
            'suggestedStockToBuy' => $suggestedStockToBuy
        ]);
    }

}