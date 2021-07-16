<?php

\Src\Services\View::includeLayoutElement('header')
?>
<script src="https://code.jquery.com/jquery-3.3.1.min.js"></script>
<script src="../../assets/dist/js/bootstrap.bundle.js" type="text/javascript"></script>
<link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet"
      integrity="sha384-wvfXpqpZZVQGK6TAh5PVlGOfQNHSoD2xbE+QkPxCAFlNEevoEH3Sl0sibVcOQVnN" crossorigin="anonymous">
<link href="../../assets/css/easy-autocomplete.min.css" rel="stylesheet" type="text/css"/>
<script src="../../assets/js/jquery.easy-autocomplete.min.js" type="text/javascript"></script>
<main role="main" class="mt-6">
    <div class="container">
        <h1>My Orders</h1>
        <div class="text-success">
            <?php
            if (isset($_SESSION['msg'])) {
                echo $_SESSION['msg'];
                unset($_SESSION['msg']);
            }
            ?>
        </div>
        <form id="transaction-list" name="transaction-list" method="post" action="/my-orders">
            <div class="row">
                <div class="col-md-3 form-label-group">
                    <input type="hidden" name="stock_id" id="stock_id">
                    <label for="stockSuggestion">Stock List</label>
                    <input
                            type="text"
                            class="form-control"
                            id="stockSuggestion"
                            name="stock"
                            placeholder="Stock Name"
                            value=""
                            required
                    />
                </div>
                <div class="col-md-1">
                    <button type="submit" id="submit-btn" class="btn btn-primary submit-btn text-left">Submit</button>
                    <div class="fa-2x submit-btn" id="loading" style="display: none;">
                        <i class="fas fa-spinner fa-spin"></i>
                    </div>
                </div>
            </div>
        </form>
        <hr/>
        <div class="row">
            <div class="col-md-12">
                <div class="table-responsive">
                    <table class="table table-bordered table-hover">
                        <thead>
                        <tr>
                            <th>Transaction Ref</th>
                            <th>Stock Name</th>
                            <th>Stock Price</th>
                            <th>Stock Date</th>
                            <th>Order Quantity</th>
                            <th>Total price</th>
                            <th>Transaction type</th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php
                        if ($transactionList) {
                            foreach ($transactionList as $item) {
                                ?>
                                <tr>
                                    <td><?php echo $item['transaction_ref']; ?></td>
                                    <td><?php echo $item['stock_name']; ?></td>
                                    <td><?php echo $item['stock_price']; ?></td>
                                    <td><?php echo $item['stock_date']; ?></td>
                                    <td><?php echo $item['quantity']; ?></td>
                                    <td><?php echo $item['total_price']; ?></td>
                                    <td><?php echo $item['transaction_type']; ?></td>
                                </tr>
                                <?php
                            }
                        } else {
                            echo '<tr><td colspan="7">No records found</td> </tr>';
                        }
                        ?>

                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</main>
<script type="text/javascript">
    $(document).ready(function () {
        let options = {
            url: function (phrase) {
                return "/stock-list";
            },
            getValue: function (element) {
                return element.stock_name;
            },
            ajaxSettings: {
                dataType: "json",
                method: "POST",
                data: {
                    dataType: "json"
                }
            },
            preparePostData: function (data) {
                data.phrase = $("#stockSuggestion").val();
                return data;
            },
            requestDelay: 400
        };
        $("#stockSuggestion").easyAutocomplete(options);
    });
</script>
<?php
\Src\Services\View::includeLayoutElement('footer')
?>
