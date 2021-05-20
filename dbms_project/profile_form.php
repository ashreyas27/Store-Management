<!-- Button trigger modal -->
<button type="button" class="btn btn-primary py-2" data-bs-toggle="modal" data-bs-target="#update_info">
    Update Details
</button>

<!-- Modal -->
<div class="modal fade" id="update_info" tabindex="-1" role="dialog" aria-labelledby="update_infoLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="update_infoLabel"><b>Update details</b></h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="<?php echo htmlentities($_SERVER['PHP_SELF']); ?>" method="POST">
                    <div class="row mb-3">
                        <label class="col-sm-3 col-form-label">Username</label>
                        <div class="col-sm-8">
                            <input type="text" class="form-control" name="Username" value="<?php echo $res['Username'] ?>" required>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <label class="col-sm-3 col-form-label">Password</label>
                        <div class="col-sm-8">
                            <input type="Password" class="form-control" name="Password" value="<?php echo $res['Password'] ?>" required>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <label class="col-sm-3 col-form-label">Name</label>
                        <div class="col-sm-8">
                            <input type="text" class="form-control" name="Name" value="<?php echo $res['Emp_name'] ?>" required>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <label class="col-sm-3 col-form-label">Mobile no.</label>
                        <div class="col-sm-8">
                            <input type="text" class="form-control" name="Mob" value="<?php echo $res['Mobile_no'] ?>" required>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <label class="col-sm-3 col-form-label">Account no.</label>
                        <div class="col-sm-8">
                            <input type="text" class="form-control" name="Acc" value="<?php echo $res['Acc_no'] ?>">
                        </div>
                    </div>
                    <h4 class="mb-3"><u>Address</u></h4>
                    <div class="row mb-3">
                        <label class="col-sm-3 col-form-label">House no.</label>
                        <div class="col-sm-8">
                            <input type="text" class="form-control" name="H_no" value="<?php echo $res['H_no'] ?>" required>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <label class="col-sm-3 col-form-label">Area</label>
                        <div class="col-sm-8">
                            <input type="text" class="form-control" name="Area" value="<?php echo $res['Area'] ?>" required>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <label class="col-sm-3 col-form-label">Pin code</label>
                        <div class="col-sm-8">
                            <input type="text" class="form-control" name="Pin" value="<?php echo $res['Pin_code'] ?>" required>
                        </div>
                    </div>
                    <button type="submit" class="btn btn-primary mb-4" name="Submit">Update</button>
                </form>
                <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                </div>
            </div>

        </div>
    </div>
</div>