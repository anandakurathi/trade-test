<?php
\Src\Services\View::includeLayoutElement('header')
?>
    <main role="main" class="inner cover text-center cover-mt">
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
                <button class="btn btn-lg btn-primary" name="submit">Upload</button>
            </form>
        </div>
    </main>
<?php
\Src\Services\View::includeLayoutElement('footer')
?>