<?php


namespace Src\Controllers;


use Src\Model\Stock;
use Src\Model\Transaction;
use Src\Services\StockBuySellSuggester;
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
        $transactions = new Transaction();
        $lastTransaction = $transactions->getLastTransaction($_POST['stock'], $this->session->user_id);

        $sellSuggestions = $stock->getForecastForPurchasedStocks($_POST['stock'], $this->session->user_id);

        $buySuggester = new StockBuySellSuggester();
        $suggestedStockToBuy = $buySuggester->bestPriceToBuy($stockList);

        $suggestionForStockSell = $buySuggester->bestPriceToSell(
            $sellSuggestions,
            $lastTransaction['stock_price']
        );
        View::render(
            'forecast',
            [
                'forecastData' => $stockList,
                'suggestedStockToBuy' => $suggestedStockToBuy,
                'suggestedStockToSell' => $suggestionForStockSell,
                'lastPurchase' => $lastTransaction
            ]
        );
    }

    public function viewSelectedSellStock()
    {
        $stockId = $_POST['stockId'];
        $stock = new Stock();
        $stockInfo = $stock->getStockById($stockId);

        $transactions = new Transaction();
        $lastTransaction = $transactions->getLastTransaction($stockInfo['stock_name'], $this->session->user_id);

        $sellSuggestions = $stock->getForecastForPurchasedStocks($stockInfo['stock_name'], $this->session->user_id);

        $buySellSuggester = new StockBuySellSuggester();
        $suggestionForStockSell = $buySellSuggester->bestPriceToSell(
            $sellSuggestions,
            $lastTransaction['stock_price']
        );

        $totalAssets = $transactions->totalAssetsUserHas($stockInfo['stock_name'], $this->session->user_id);

        View::render(
            'sell-stock',
            [
                'stockInfo' => $stockInfo,
                'lastPurchase' => $lastTransaction,
                'suggestedStockToSell' => $suggestionForStockSell,
                'total' => $totalAssets,
            ]
        );
    }

    public function viewSelectedBuyStock()
    {
        $stockId = $_POST['stockId'];
        $stock = new Stock();
        $stockInfo = $stock->getStockById($stockId);
        $stockList = $stock->getStockForecast(
            $stockInfo['stock_name'],
            $_POST['startDate'],
            $_POST['endDate']
        );
        $buySuggester = new StockBuySellSuggester();
        $suggestedStockToBuy = $buySuggester->bestPriceToBuy($stockList);
        View::render(
            'buy-stock',
            [
                'stockInfo' => $stockInfo,
                'suggestedStockToBuy' => $suggestedStockToBuy
            ]
        );
    }

}