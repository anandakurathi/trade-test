<?php

\Src\Services\View::includeLayoutElement('header')
?>
    <script src="https://code.jquery.com/jquery-3.3.1.min.js"></script>
    <script src="../../assets/dist/js/bootstrap.bundle.js" type="text/javascript"></script>
    <link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet"
          integrity="sha384-wvfXpqpZZVQGK6TAh5PVlGOfQNHSoD2xbE+QkPxCAFlNEevoEH3Sl0sibVcOQVnN" crossorigin="anonymous">
    <script src="https://unpkg.com/gijgo@1.9.13/js/gijgo.min.js" type="text/javascript"></script>
    <link href="https://unpkg.com/gijgo@1.9.13/css/gijgo.min.css" rel="stylesheet" type="text/css"/>
    <link href="../../assets/css/easy-autocomplete.min.css" rel="stylesheet" type="text/css"/>
    <script src="../../assets/js/jquery.easy-autocomplete.min.js" type="text/javascript"></script>
    <script src="../../assets/js/jquery.validate.min.js" type="text/javascript"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css"
          integrity="sha512-iBBXm8fW90+nuLcSKlbmrPcLa0OT92xO1BIsZ+ywDWZCvqsWgccV3gFoRBv0z+8dLJgyAHIhR35VZc2oM/gI1w=="
          crossorigin="anonymous" referrerpolicy="no-referrer" />
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
            <form id="forecast-form" name="forecast-form" method="post">
                <div class="row">
                    <div class="col-md-3 form-label-group">
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
                    <div class="col-md-3 form-label-group">
                        <label for="fromDate">From Date</label>
                        <input
                                type="text"
                                class="form-control"
                                id="startDate"
                                name="startDate"
                                placeholder="From Date"
                                value=""
                                required
                        />
                    </div>
                    <div class="col-md-3 form-label-group">
                        <label for="toDate">To Date</label>
                        <input
                                type="text"
                                class="form-control"
                                id="endDate"
                                name="endDate"
                                placeholder="To Date"
                                value=""
                                required
                        />
                    </div>
                    <div class="col-md-1">
                        <button type="submit" id="submit-btn" class="btn btn-primary submit-btn text-left">Submit</button>
                        <div class="fa-3x" id="loading" style="display: none;">
                            <i class="fas fa-spinner fa-spin"></i>
                        </div>
                    </div>
                </div>
            </form>
        </div> <!-- /container -->
        <hr>
        <div id="result">
        </div>
    </main>

    <script>
        $(document).ready(function () {
            let today = new Date(new Date().getFullYear(), new Date().getMonth(), new Date().getDate());
            $('#startDate').datepicker({
                uiLibrary: 'bootstrap4',
                iconsLibrary: 'fontawesome',
                format: 'yyyy-mm-dd',
                maxDate: function () {
                    return $('#endDate').val();
                },
                change: function (e) {
                    $('#startDate').valid();
                }
            });
            $('#endDate').datepicker({
                uiLibrary: 'bootstrap4',
                iconsLibrary: 'fontawesome',
                format: 'yyyy-mm-dd',
                minDate: function () {
                    return $('#startDate').val();
                },
                change: function (e) {
                    $('#endDate').valid();
                }
            });

            let options = {
                url: function(phrase) {
                    return "/stock-list";
                },
                getValue: function(element) {
                    return element.stock_name;
                },
                ajaxSettings: {
                    dataType: "json",
                    method: "POST",
                    data: {
                        dataType: "json"
                    }
                },
                preparePostData: function(data) {
                    data.phrase = $("#stockSuggestion").val();
                    return data;
                },
                requestDelay: 400
            };
            $("#stockSuggestion").easyAutocomplete(options);

            $( "#forecast-form" ).validate( {
                submitHandler: function (form) {
                    let serializedData = $(form).serialize();
                    $.ajax({
                        url: '/stock-forecast',
                        type: 'POST',
                        data: serializedData,
                        cache: false,
                        processData: false,
                        beforeSend: function(){
                            $('#submit-btn').hide();
                        },
                        complete: function(){
                            $("#submit-btn").show();
                        },
                        success: function(data) {
                            $('#submit-btn').show();
                            $('#loading').hide();
                            $("#result").html(data);
                        }
                    });
                    return false;
                },
                rules: {
                    stock: {
                        required: true
                    },
                    startDate: {
                        required: true,
                        dateISO: true
                    },
                    endDate: {
                        required: true,
                        dateISO: true
                    }
                },
                messages: {
                    stock: {
                        required: "Please choose a Stock"
                    },
                    startDate: {
                        required: "Please choose start Date",
                    },
                    endDate: {
                        required: "Please choose end Date",
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
<?php
\Src\Services\View::includeLayoutElement('footer')
?>