<?php
\Src\Services\View::includeLayoutElement('header')
?>
    <header class="masthead mb-auto">
        <div class="inner">
            <h3 class="masthead-brand">Stock Exchange Test</h3>
        </div>
    </header>

    <main role="main" class="inner cover">
        <h1 class="cover-heading">Load Stock Data</h1>
        <p class="lead">Use the CSV for loading the stocks</p>
        <div class="lead">
            <form action="/uploadCsv" method="post" enctype="multipart/form-data">
                <div class="form-label-group">
                    <input
                            type="file"
                            id="firstName"
                            placeholder="Choose Stock List CSV"
                            title="Choose Stock List CSV"
                            required
                            name="upload"
                    />
                    <div class="text-danger">
                        <?php
                            if(isset($_SESSION['msg'])){
                                echo $_SESSION['msg'];
                                unset($_SESSION['msg']);
                            }
                        ?>
                    </div>
                </div>
                <br/>
                <br/>
                <button class="btn btn-lg btn-secondary" name="submit">Upload</button>
            </form>
        </div>
    </main>
<?php
\Src\Services\View::includeLayoutElement('footer')
?>