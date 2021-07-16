<div class="container">
    <div class="row">
        <div class="col-md-9">
            <div class="table-responsive">
                <table class="table table-bordered table-hover">
                    <thead>
                    <tr>
                        <th>Stock</th>
                        <th>Price</th>
                        <th>Date</th>
                        <th>Actions</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php
                    if ($forecastData) {
                        foreach ($forecastData as $data) {
                            ?>
                            <tr>
                                <td>
                                    <?php
                                    echo $data['stock_name']; ?>
                                </td>
                                <td>
                                    <?php
                                    echo $data['stock_price']; ?>
                                </td>
                                <td>
                                    <?php
                                    echo $data['stock_date']; ?>
                                </td>
                                <td>
                                    <?php
                                    $buyAdvice = ($suggestedStockToBuy) ? $suggestedStockToBuy['stock_id'] : null;
                                    $sellAdvice = ($suggestedStockToSell) ? $suggestedStockToSell['stock_id'] : null;
                                    $btnStyle = 'btn-primary';
                                    $suggestion = '';
                                    if ($buyAdvice == $data['stock_id']) {
                                        $btnStyle = 'btn-warning';
                                        $suggestion = '<i 
                                                id="tooltip"
                                                class="fa fa-info-circle" 
                                                data-toggle="tooltip"
                                                data-bs-placement="top" 
                                                title="Best Buy suggestion"></i>';
                                    }
                                    if($lastPurchase) {
                                        $btnSellStyle = 'btn-dark';
                                        $sellSuggestion = '';
                                        if ($sellAdvice == $data['stock_id']) {
                                            $btnSellStyle = 'btn-success';
                                            $sellSuggestion = '<i 
                                                id="tooltip"
                                                class="fa fa-info-circle" 
                                                data-toggle="tooltip"
                                                data-bs-placement="top" 
                                                title="Best Sell suggestion"></i>';
                                        }
                                    }
                                    ?>
                                    <a href="javascript:void(0);"
                                       data-stock-id="<?php
                                       echo $data['stock_id']; ?>"
                                       class="buyStock btn <?php
                                       echo $btnStyle; ?>">
                                        <i class="fa fa-shopping-cart"></i> <?php
                                        echo $suggestion; ?>
                                    </a>
                                    <?php if($lastPurchase) {?>
                                        <a href="javascript:void(0);"
                                           data-stock-id="<?php
                                           echo $data['stock_id']; ?>"
                                           class="sellStock btn <?php
                                           echo $btnSellStyle; ?>">
                                            <i class="fa fa-usd"></i> <?php
                                            echo $sellSuggestion; ?>
                                        </a>
                                    <?php } ?>
                                </td>
                            </tr>
                            <?php
                        }
                    } else {
                        echo '<tr><td colspan="4">No records found</td> </tr>';
                    }
                    ?>
                    </tbody>
                </table>
            </div>
        </div>
        <div class="col-md-3 vertical-separation">
            <h5>Purchased Stock Comparison</h5>
            <hr/>
            <h6>Last Purchase</h6>
            <?php
            if ($lastPurchase) { ?>
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title"><?php echo $lastPurchase['stock_name'] ?></h5>
                        <h6 class="card-subtitle mb-2 text-muted"><?php echo $lastPurchase['stock_price'] ?> per unit</h6>
                        <h6 class="card-subtitle mb-2 text-muted"><?php echo $lastPurchase['stock_date'] ?></h6>
                        <h3 class="card-title"><?php echo $lastPurchase['total_price'] ?>
                            <smal class="text-muted h8">(x<?php echo $lastPurchase['quantity'] ?> units)</smal>
                        </h3>
                    </div>
                </div>
                <hr/>
                <h6>Suggestion For Sell</h6>
                <?php if($suggestedStockToSell) { ?>
                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title"><?php echo $suggestedStockToSell['stock_name'] ?></h5>
                            <h6 class="card-subtitle mb-2 text-muted"><?php echo $suggestedStockToSell['stock_date'] ?></h6>
                            <h3 class="card-subtitle mb-2"><?php echo $suggestedStockToSell['stock_price'] ?>
                                <smal class="text-muted h8">per unit</smal>
                            </h3>
                            <a href="javascript:void(0);"
                               data-stock-id="<?php
                               echo $suggestedStockToSell['stock_id']; ?>"
                               class="sellStock btn btn-success">
                                <i class="fa fa-usd"></i>&nbsp;Sell
                                <i class="fa fa-info-circle"
                                data-toggle="tooltip"
                                data-bs-placement="top"
                                title="Best Sell suggestion"></i>
                            </a>
                        </div>
                    </div>
                <?php } else {
                    echo '<div class="alert alert-primary" role="alert">
                      No suggestions available
                    </div>';
                }?>
                <?php
            } else {
                echo '<div class="alert alert-primary" role="alert">
                      You do not have any.
                    </div>';
            }

            ?>
        </div>
    </div>

</div>
<script>
    $(function () {
        $('[data-toggle="tooltip"]').tooltip();
    })

    $(document).ready(function () {
        $('.buyStock').click(function (e) {
            e.preventDefault();
            let stockId = $(this).data('stock-id');
            let startDate = $('#startDate').val();
            let endDate = $('#endDate').val();
            $.ajax({
                url: '/stock-buy-info',
                method: 'POST',
                data: 'stockId=' + stockId + '&startDate=' + startDate + '&endDate=' + endDate,
                cache: false,
                processData: false,
                beforeSend: function () {
                    $("#overlay").fadeIn(300);
                },
                complete: function () {
                    $("#overlay").fadeOut(300);
                },
                success: function (data) {
                    $("#overlay").fadeOut(300);
                    $("#transaction-modal").html(data);
                    $('#transaction-modal').modal('show');
                },
                fail: function (jqXHR, textStatus) {
                    $("#overlay").fadeOut(300);
                    alert("Request failed: " + textStatus);
                }
            });
        })

        $('.sellStock').click(function (e) {
            e.preventDefault();
            let stockId = $(this).data('stock-id');
            let startDate = $('#startDate').val();
            let endDate = $('#endDate').val();
            $.ajax({
                url: '/stock-sell-info',
                method: 'POST',
                data: 'stockId=' + stockId + '&startDate=' + startDate + '&endDate=' + endDate,
                cache: false,
                processData: false,
                beforeSend: function () {
                    $("#overlay").fadeIn(300);
                },
                complete: function () {
                    $("#overlay").fadeOut(300);
                },
                success: function (data) {
                    $("#overlay").fadeOut(300);
                    $("#transaction-modal").html(data);
                    $('#transaction-modal').modal('show');
                },
                fail: function (jqXHR, textStatus) {
                    $("#overlay").fadeOut(300);
                    alert("Request failed: " + textStatus);
                }
            });
        })
    });


</script>