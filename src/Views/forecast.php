<div class="container">
    <div class="row">
        <div class="col-md-8">
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
                                    <?php echo $data['stock_name']; ?>
                                </td>
                                <td>
                                    <?php echo $data['stock_price']; ?>
                                </td>
                                <td>
                                    <?php echo $data['stock_date']; ?>
                                </td>
                                <td>
                                    <?php
                                    $buyAdvice = ($suggestedStockToBuy) ? $suggestedStockToBuy['stock_id'] : null;
                                    $btnStyle = 'btn-primary';
                                    $suggestion = '';
                                    if ($buyAdvice == $data['stock_id']) {
                                        $btnStyle = 'btn-warning';
                                        $suggestion = '<i 
                                                id="tooltip"
                                                class="fa fa-info-circle" 
                                                data-bs-toggle="tooltip" 
                                                data-bs-placement="top" 
                                                title="Best Buy suggestion"></i>';
                                    }

                                    ?>
                                    <a href="/buy" class="btn <?php echo $btnStyle; ?>">
                                        <i class="fa fa-shopping-cart"></i> <?php echo $suggestion; ?>
                                    </a>
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
        <div class="col-md-4 vertical-separation">
            <h4>Your Stock Comparison</h4>
            <hr/>
        </div>
    </div>

</div>
<script>
    var exampleEl = document.getElementById('tooltip')
    var tooltip = new bootstrap.Tooltip(exampleEl)
</script>