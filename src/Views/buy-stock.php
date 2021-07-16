<div class="modal-dialog">
    <form method="post" name="buy-stock" id="buy-stock">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Buy Stock</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="container-fluid">
                    <div class="row">
                        <?php
                        $chosenStockId = ($stockInfo && array_key_exists(
                                'stock_id',
                                $stockInfo
                            )) ? $stockInfo['stock_id'] : 0;
                        $suggestedStockId = ($suggestedStockToBuy && array_key_exists(
                                'stock_id',
                                $suggestedStockToBuy
                            )) ? $suggestedStockToBuy['stock_id'] : 0;
                        if ($stockInfo) {
                            ?>
                            <div class="text-center col-md-<?php
                            echo ($chosenStockId !== $suggestedStockId) ? '6' : '12'; ?>">
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
                                        <h3 class="card-text">
                                            <?php
                                            echo ($stockInfo && array_key_exists(
                                                    'stock_price',
                                                    $stockInfo
                                                )) ? $stockInfo['stock_price'] : ''; ?>
                                        </h3>
                                    </div>
                                </div>
                            </div>
                            <?php
                        }
                        if ($suggestedStockToBuy && ($chosenStockId !== $suggestedStockId)) {
                            ?>
                            <div class="col-md-6">
                                <div class="card text-center border-warning">
                                    <div class="card-body">
                                        <h5 class="card-title">
                                            <?php
                                            echo ($suggestedStockToBuy && array_key_exists(
                                                    'stock_name',
                                                    $suggestedStockToBuy
                                                )) ? $suggestedStockToBuy['stock_name'] : ''; ?>
                                        </h5>
                                        <h6 class="card-subtitle mb-2 text-warning">Our Suggestion</h6>
                                        <h3 class="card-text">
                                            <?php
                                            echo ($suggestedStockToBuy && array_key_exists(
                                                    'stock_price',
                                                    $suggestedStockToBuy
                                                )) ? $suggestedStockToBuy['stock_price'] : ''; ?>
                                        </h3>
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
                            <input type="hidden" name="transType" value="Buy"/>
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
    $(document).ready(function (e){
        $( "#buy-stock" ).validate( {
            submitHandler: function (form) {
                let serializedData = $(form).serialize();
                $.ajax({
                    url: '/make-transaction',
                    type: 'POST',
                    data: serializedData,
                    cache: false,
                    processData: false,
                    beforeSend: function(){
                        $('#buy-btn').hide();
                        $('#loading-buy').show();
                    },
                    complete: function(){
                        $("#buy-btn").show();
                    },
                    success: function(data) {
                        $('#buy-btn').show();
                        $('#loading-buy').hide();
                        $("#transaction-modal").html(data);
                        setTimeout(function(){
                            $('#transaction-modal').modal('hide');
                            window.location.replace('/my-orders');
                        }, 3000);
                    },
                    fail: function( jqXHR, textStatus ) {
                        alert( "Request failed: " + textStatus );
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
            errorPlacement: function ( error, element ) {
                // Add the `invalid-feedback` class to the error element
                error.addClass( "invalid-feedback" );

                error.insertAfter( element.closest('div') );
            },
            highlight: function ( element, errorClass, validClass ) {
                $( element ).addClass( "is-invalid" ).removeClass( "is-valid" );
            },
            unhighlight: function (element, errorClass, validClass) {
                $( element ).addClass( "is-valid" ).removeClass( "is-invalid" );
            }
        } );
    });
</script>