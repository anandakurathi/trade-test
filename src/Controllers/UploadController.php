<?php


namespace Src\Controllers;


use Src\Model\Stock;
use Src\Services\ParseCsv;

class UploadController extends BaseController
{
    public function index()
    {
        $errors = []; // Store errors here
        $fileExtensionsAllowed = ['csv']; // These will be the only file extensions allowed

        if (isset($_POST['submit'])) {
            if (isset($_FILES['upload']) && $_FILES['upload']['error'] === UPLOAD_ERR_OK) {
                $fileName = $_FILES['upload']['name'];
                $fileTmpName = $_FILES['upload']['tmp_name'];
                $fileExt = explode('.', $fileName);
                $fileExtension = strtolower(end($fileExt));
                $fileSize = $_FILES['upload']['size'];

                if (!in_array($fileExtension, $fileExtensionsAllowed)) {
                    $errors[] = "This file extension is not allowed. Please upload a CSV file";
                }

                if ($fileSize > 2000000) {
                    $errors[] = "File exceeds maximum size (2MB)";
                }

                if($errors) {
                    $msg = implode(',', $errors);
                    $_SESSION['msg'] = $msg;
                    header('Location: /');
                    exit();
                }

                $csvReader = new ParseCsv($fileTmpName, ',');
                $currenTime = date('Y-m-d H:i:s');
                $csvData = [];
                foreach ($csvReader->csvToArray() as $data) {
                    foreach ($data as $key => $entry) {
                        $csvData[$key]['stock_name'] = $entry['stock_name'];
                        $csvData[$key]['stock_price'] = $entry['price'];
                        $csvData[$key]['stock_date'] = date('Y-m-d', strtotime($entry['date']));
                        $csvData[$key]['created_at'] = $currenTime;
                        $csvData[$key]['updated_at'] = $currenTime;
                    }
                    $insertStock = new Stock();
                    $insertStock->insertStocks($csvData);
                }

                $_SESSION['msg'] = 'Stocks information loaded successfully!';
                header('Location: /stocks');
                exit();
            }
        }
    }

}