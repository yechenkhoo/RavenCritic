
<form action="backend/processNewManager.php" method="post">
    <div class="row">
        <div class="col-md-8">
            <div class="p-3 py-5">
                <div class="d-flex justify-content-between align-items-center mb-3">
                <h4 class="text-right">Add Manager</h4>
                </div>
                <div class="row mt-2">
                    <div class="col-md-6">
                        <input type="text" id="fname" name="fname" class="form-control" placeholder="First Name" value="" maxlength="45">
                    </div>
                    <div class="col-md-6">
                        <input required type="text" id="lname" name="lname" class="form-control" value="" placeholder="Last Name" maxlength="45">
                    </div>
                </div>
                <div class="row mt-3">
                    <div class="col-md-6">
                        <input required type="password" id="pwd" name="pwd" class="form-control" value="" placeholder="Enter password ">
                    </div>
                    <div class="col-md-6">
                        <input required type="password" id="pwd_cfm" name="pwd_cfm" class="form-control" placeholder="Confirm Password" value="">
                    </div>
                </div>
                <div class="row mt-4">
                    <div class="col-md-6">
                        <input required type="text" id="email" name="email" class="form-control" value="" placeholder="Email">
                    </div>
                </div>
                <div class="mt-5 text-right">
                    <button class="btn btn-dark profile-button" type="submit">Add Manager</button>
                </div>
            </div>
        </div>
    </div>
</form>