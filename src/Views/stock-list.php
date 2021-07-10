<?php

\Src\Services\View::includeLayoutElement('header')
?>
    <script src="https://code.jquery.com/jquery-3.3.1.min.js"></script>
    <link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet"
          integrity="sha384-wvfXpqpZZVQGK6TAh5PVlGOfQNHSoD2xbE+QkPxCAFlNEevoEH3Sl0sibVcOQVnN" crossorigin="anonymous">
    <script src="https://unpkg.com/gijgo@1.9.13/js/gijgo.min.js" type="text/javascript"></script>
    <link href="https://unpkg.com/gijgo@1.9.13/css/gijgo.min.css" rel="stylesheet" type="text/css"/>
    <header class="masthead">
        <div class="inner">
            <h3 class="masthead-brand">Stock Exchange Test</h3>
        </div>
    </header>
    <main role="main">
        <div class="container">
            <div class="text-success">
                <?php
                if(isset($_SESSION['msg'])){
                    echo $_SESSION['msg'];
                    unset($_SESSION['msg']);
                }
                ?>
            </div>
            <!-- Example row of columns -->
            <form action="" method="post">
                <div class="row">
                    <div class="col-md-3 form-label-group">
                        <label for="firstName">Stock List</label>
                        <select class="form-control" id="sel1">
                            <option value="">Choose Stock List</option>
                            <?php
                            if ($stockList) {
                                foreach ($stockList as $item) { ?>
                                    <option value="<?php
                                    echo $item->stock_name; ?>">
                                        <?php
                                        echo $item->stock_name; ?>
                                    </option>
                                    <?php
                                }
                            } ?>
                        </select>
                        <div class="invalid-feedback">
                            Choose Stock List CSV
                        </div>
                    </div>
                    <div class="col-md-3 form-label-group">
                        <label for="fromDate">From Date</label>
                        <input
                                type="text"
                                class="form-control"
                                id="startDate"
                                placeholder=""
                                value=""
                                required
                        />
                        <div class="invalid-feedback">
                            Valid first name is required.
                        </div>
                    </div>
                    <div class="col-md-3 form-label-group">
                        <label for="toDate">To Date</label>
                        <input
                                type="text"
                                class="form-control"
                                id="endDate"
                                placeholder=""
                                value=""
                                required
                        />
                        <div class="invalid-feedback">
                            Valid first name is required.
                        </div>
                    </div>
                    <div class="col-md-1">
                        <button type="submit" class="btn btn-primary submit-btn text-left">Submit</button>
                    </div>
                </div>
            </form>
            <hr>
            <div class="row">
                <div class="col-md-8" id="result">
                </div>
                <div class="col-md-4">
                </div>
            </div>
        </div> <!-- /container -->
    </main>

    <script>
        var today = new Date(new Date().getFullYear(), new Date().getMonth(), new Date().getDate());
        $('#startDate').datepicker({
            uiLibrary: 'bootstrap4',
            iconsLibrary: 'fontawesome',
            maxDate: function () {
                return $('#endDate').val();
            }
        });
        $('#endDate').datepicker({
            uiLibrary: 'bootstrap4',
            iconsLibrary: 'fontawesome',
            minDate: function () {
                return $('#startDate').val();
            }
        });
    </script>
<?php
\Src\Services\View::includeLayoutElement('footer')
?>