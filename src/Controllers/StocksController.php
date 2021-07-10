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
        $stock = new Stock();
        $stockList = $stock->getDistinctStocks();
        View::render('stock-list', ['stockList' => $stockList]);
    }

}