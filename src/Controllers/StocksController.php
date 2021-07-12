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

    public function getStocksByName()
    {
        $params = ($_REQUEST['phrase']) ?: null;
        $stock = new Stock();
        $stockList = $stock->getStocksByName($params);
        echo json_encode($stockList); exit();
    }

}