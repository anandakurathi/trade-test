<div class="modal-dialog modal-lg">
    <form method="post" name="sell-stock" id="sell-stock">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Sell Stock</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-md-6 ">
                            <h6 class="alert alert-dark" data-total="<?php
                            echo $total['totalPrice']; ?>">Your Total asset Value is: <b><?php
                                    echo $total['totalPrice']; ?></b></h6>
                        </div>
                        <div class="col-md-6 ml-auto">
                            <h6 class="alert alert-dark" data-quntity="<?php
                            echo $total['totalQuantity']; ?>">Your Total asset Quantity is: <b><?php
                                    echo $total['totalQuantity']; ?></b></h6>
                        </div>
                    </div>

                    <div class="row">
                        <?php
                        $chosenStockId = ($stockInfo && array_key_exists(
                                'stock_id',
                                $stockInfo
                            )) ? $stockInfo['stock_id'] : 0;
                        $saleAvgValue = ($total && array_key_exists(
                                'saleAvgValue',
                                $total
                            )) ? $total['saleAvgValue'] : 0;
                        $boughtAvgValue = ($total && array_key_exists(
                                'boughtAvgValue',
                                $total
                            )) ? $total['boughtAvgValue'] : 0;
                        $suggestedStockId = ($suggestedStockToSell && array_key_exists(
                                'stock_id',
                                $suggestedStockToSell
                            )) ? $suggestedStockToSell['stock_id'] : 0;

                        $boughtPrice = ($lastPurchase && array_key_exists(
                                'stock_price',
                                $lastPurchase
                            )) ? $lastPurchase['stock_price'] : 0;

                        $suggestedPrice = ($suggestedStockToSell && array_key_exists(
                                'stock_price',
                                $suggestedStockToSell
                            )) ? $suggestedStockToSell['stock_price'] : 0;

                        $chosenPrice = ($stockInfo && array_key_exists(
                                'stock_price',
                                $stockInfo
                            )) ? $stockInfo['stock_price'] : 0;
                        if ($stockInfo) {
                            ?>
                            <div class="text-center col-md-<?php
                            echo ($chosenStockId !== $suggestedStockId) ? '4' : '12'; ?>">
                                <div class="card">
                                    <div class="card-body">
                                        <h5 class="card-title">
                                            <?php
                                            echo ($stockInfo && array_key_exists(
                                                    'stock_name',
                                                    $stockInfo
                                                )) ? $stockInfo['stock_name'] : ''; ?>
                                        </h5>
                                        <h6 class="card-subtitle mb-2 text-muted">Chosen by you</h6>

                                        <h4 class="card-text price" data-chosen-price="<?php
                                        echo $chosenPrice; ?>">
                                            <?php echo $chosenPrice; ?>
                                        </h4>
                                        <h6 class="card-subtitle mb-2 text-muted h8">
                                            <?php
                                            echo ($stockInfo && array_key_exists(
                                                    'stock_date',
                                                    $stockInfo
                                                )) ? $stockInfo['stock_date'] : ''; ?>
                                        </h6>
                                    </div>
                                </div>
                            </div>
                            <?php
                        }
                        if ($suggestedStockToSell && ($chosenStockId !== $suggestedStockId)) {
                            ?>
                            <div class="col-md-4">
                                <div class="card text-center border-warning">
                                    <div class="card-body">
                                        <h5 class="card-title">
                                            <?php
                                            echo ($suggestedStockToSell && array_key_exists(
                                                    'stock_name',
                                                    $suggestedStockToSell
                                                )) ? $suggestedStockToSell['stock_name'] : ''; ?>
                                        </h5>
                                        <h6 class="card-subtitle mb-2 text-warning">Tool Suggest</h6>

                                        <h4 class="card-text price" data-suggested-price="<?php
                                        echo $suggestedPrice; ?>">
                                            <?php
                                            echo $suggestedPrice; ?>
                                        </h4>
                                        <h6 class="card-subtitle mb-2 text-muted h8">
                                            <?php
                                            echo ($suggestedStockToSell && array_key_exists(
                                                    'stock_date',
                                                    $suggestedStockToSell
                                                )) ? $suggestedStockToSell['stock_date'] : ''; ?>
                                        </h6>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="card text-center border-info">
                                    <div class="card-body">
                                        <h5 class="card-title">
                                            <?php
                                            echo ($lastPurchase && array_key_exists(
                                                    'stock_name',
                                                    $lastPurchase
                                                )) ? $lastPurchase['stock_name'] : ''; ?>
                                        </h5>
                                        <h6 class="card-subtitle mb-2 text-info">You Last buy</h6>

                                        <h4 class="card-text price" data-bought-price="<?php
                                        echo $boughtPrice; ?>">
                                            <?php
                                            echo $boughtPrice; ?>
                                        </h4>
                                        <h6 class="card-subtitle mb-2 text-muted h8">
                                            <?php
                                            echo ($lastPurchase && array_key_exists(
                                                    'stock_date',
                                                    $lastPurchase
                                                )) ? $lastPurchase['stock_date'] : ''; ?>
                                        </h6>
                                    </div>
                                </div>
                            </div>
                            <?php
                        }
                        ?>
                        <div class="col-md-12 mt-3">
                            <?php
                            if ($chosenStockId === $suggestedStockId) {
                                echo '<p class="text-primary">
                                                        <i class="fa fa-thumbs-up"></i>&nbsp; You have chosen right stock
                                                    </p>';
                            } else {
                                echo '<p class="text-danger">
                                                        <i class="fa fa-thumbs-down"></i>&nbsp; Compare weasley and buy.
                                                    </p>';
                            }
                            ?>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12 ms-auto">
                            <input type="hidden" name="transType" value="Sell"/>
                            <input type="hidden" name="stock_id" value="<?php
                            echo ($stockInfo && array_key_exists(
                                    'stock_id',
                                    $stockInfo
                                )) ? $stockInfo['stock_id'] : 0; ?>"/>
                            <div class="form-group">
                                <label for="recipient-name" class="col-form-label">Stock quantity</label>
                                <input
                                        type="number"
                                        class="form-control"
                                        id="quantity"
                                        name="quantity"
                                        placeholder="quantity"
                                        value=""
                                        required
                                        min="1"
                                />
                            </div>
                            <input type="hidden" name="chosen-price" id="chosen-price" value="<?php echo $chosenPrice; ?>"/>
                            <input type="hidden" name="suggested-price" id="suggested-price" value="<?php echo $suggestedPrice; ?>"/>
                            <input type="hidden" name="bought-price" id="bought-price" value="<?php echo $boughtPrice; ?>"/>
                            <input type="hidden" name="sell-avg-price" id="sell-avg-price" value="<?php echo $saleAvgValue; ?>"/>
                            <input type="hidden" name="bought-avg-price" id="bought-avg-price" value="<?php echo $boughtAvgValue; ?>"/>
                        </div>
                        <div class="col-md-12 ms-auto" id="deviation" style="display: none;">
                            <h6 class="alert alert-dark">Deviation between Chosen and your avg bought price: <span id="chosenVal"></span></h6>
                            <h6 class="alert alert-warning">Deviation between Suggested and your avg bought price: <span id="suggestedVal"></span></h6>
                            <h6 class="alert alert-info">Deviation between Last Bought and your avg bought price: <span id="lastPurchased"></span></h6>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="submit" class="btn btn-primary buy-btn">Buy Now</button>
                <div class="fa-2x" id="loading-buy" style="display: none;">
                    <i class="fas fa-spinner fa-spin"></i>
                </div>
            </div>
        </div>
    </form>
</div>

<div id="transaction-status" class="modal fade" role="dialog"></div>
<script type="text/javascript">
    $(document).ready(function (e) {
        $('#quantity').keyup(function (e) {
            let qunty = $(this).val();
            console.log(qunty);
            let chosenValue = $('#chosen-price').val();
            let suggestedValue = $('#suggested-price').val();
            let lastPurchaseValue = $('#bought-price').val();
            let purchaseAvgValue = $('#bought-avg-price').val();
            let saleAvgValue = $('#sell-avg-price').val();

            let chosenVal = (chosenValue * qunty) - (purchaseAvgValue * qunty);
            let suggestedVal = (suggestedValue * qunty) - (purchaseAvgValue * qunty);
            let lastPurchased = (chosenValue * qunty) - (lastPurchaseValue * qunty);

            $('#chosenVal').html(chosenVal);
            $('#suggestedVal').html(suggestedVal);
            $('#lastPurchased').html(lastPurchased);

            $('#deviation').show();
        });

        $("#sell-stock").validate({
            submitHandler: function (form) {
                let serializedData = $(form).serialize();
                $.ajax({
                    url: '/make-transaction',
                    type: 'POST',
                    data: serializedData,
                    cache: false,
                    processData: false,
                    beforeSend: function () {
                        $('#buy-btn').hide();
                        $('#loading-buy').show();
                    },
                    complete: function () {
                        $("#buy-btn").show();
                    },
                    success: function (data) {
                        $('#buy-btn').show();
                        $('#loading-buy').hide();
                        $("#transaction-modal").html(data);
                        setTimeout(function () {
                            $('#transaction-modal').modal('hide');
                            window.location.replace('/my-orders');
                        }, 3000);
                    },
                    fail: function (jqXHR, textStatus) {
                        alert("Request failed: " + textStatus);
                    }
                });
                return false;
            },
            rules: {
                quantity: {
                    required: true,
                    number: true,
                    min: 1
                }
            },
            messages: {
                quantity: {
                    required: 'Please enter a valid number',
                    number: 'Please enter a valid number'
                }
            },
            errorElement: "em",
            errorPlacement: function (error, element) {
                // Add the `invalid-feedback` class to the error element
                error.addClass("invalid-feedback");

                error.insertAfter(element.closest('div'));
            },
            highlight: function (element, errorClass, validClass) {
                $(element).addClass("is-invalid").removeClass("is-valid");
            },
            unhighlight: function (element, errorClass, validClass) {
                $(element).addClass("is-valid").removeClass("is-invalid");
            }
        });
    });
</script>