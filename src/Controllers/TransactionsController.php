<?php


namespace Src\Controllers;


use Src\Model\Stock;
use Src\Model\Transaction;
use Src\Services\View;

class TransactionsController extends BaseController
{

    public function index()
    {
        $stockName = (isset($_REQUEST['stock'])) ? $_REQUEST['stock'] : '';
        $transactions = new Transaction();
        View::render(
            'my-orders',
            [
                'transactionList' => $transactions->getList($this->session->user_id, $stockName)
            ]
        );
    }

    /**
     * @throws \Exception
     */
    public function transaction()
    {
        $stockId = $_POST['stock_id'];
        $quantity = $_POST['quantity'];
        $transType = ($_POST['transType'] && $_POST['transType'] === 'Buy') ?
            Transaction::TRANSACTION_TYPE['Buy'] :
            Transaction::TRANSACTION_TYPE['Sell'];

        $stock = new Stock();
        $stockInfo = $stock->getStockById($stockId);
        $totalAmount = $quantity * $stockInfo['stock_price'];

        $transaction = new Transaction();
        $todayTransCount = $transaction->getLatestTransaction($stockInfo['stock_name'], $this->session->user_id);
        if ($todayTransCount <= 0) {
            $transactionId = $transaction->createTransaction(
                $stockInfo,
                $quantity,
                $this->session->user_id,
                $totalAmount,
                $transType
            );
            if ($transactionId) {
                $response = [
                    'error' => false,
                    'msg' => 'Transaction successful.<br/> Your reference Number is : <b>' . $transactionId . '</b>'
                ];
            } else {
                $response = ['error' => true, 'msg' => 'Transaction was not successful.'];
            }
        } else {
            $response = ['error' => true, 'msg' => 'Per day one transaction only allowed.'];
        }
        View::render('transaction-status', ['response' => $response]);
    }
}