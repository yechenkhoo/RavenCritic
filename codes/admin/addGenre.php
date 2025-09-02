<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

?>


<form action="backend/processNewGenre.php" method="post">
    <div class="row">
        <div class="col-md-8">
            <div class="p-3 py-5">
                <div class="d-flex justify-content-between align-items-center mb-3">
                <h4 class="text-right">Add Genre</h4>
                </div>
                <div class="row mt-2">
                    <div class="col-md-6">
                        <input required type="text" id="genre_name" name="genre_name" class="form-control" placeholder="Genre Name" value="" maxlength="45">
                    </div>
                </div>
                <div class="mt-5 text-left">
                    <button class="btn btn-dark profile-button" type="submit">Add Genre</button>
                </div>
            </div>
        </div>
    </div>
</form>


