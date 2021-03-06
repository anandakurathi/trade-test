<div class="modal-dialog">
    <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">Transaction Status</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
        <div class="modal-body">
            <?php
            if ($response) {
                $state = ($response && array_key_exists('error', $response)) ? $response['error'] : false;
                ?>
                <p class="text-<?php
                echo (!$state) ? 'success' : 'danger'; ?>">
                    <?php
                    echo ($response && array_key_exists(
                            'msg',
                            $response
                        )) ? $response['msg'] : 'Some thing went wrong..!';
                    ?>
                </p>
                <?php
            } else {
                echo '<p class="text-danger">Some thing went wrong..!</p>';
            }
            ?>
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        </div>
    </div>
</div>