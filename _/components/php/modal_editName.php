  <!-- Modal -->
    <div class="modal fade" id="editName" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">

                <!-- Modal Header -->
                <div class="modal-header">
                    <h4 class="modal-title" id="editNameModalLabel">Edit Display Name</h4>
                </div><!--modal-header-->

               <!-- Modal Body -->
                <div class="modal-body">
                    <form class="form-horizontal" data-toggle="validator" id="editNameForm" role="form">

                      <div class="form-group">
                        <div class="col-sm-12" inputGroupContainer>
                            <div class="input-group">
                                <input type="text" class="form-control" 
                                id="display_name" name="display_name" placeholder="Display Name"/>
                            </div><!--input-group-->
                        </div><!--inputGroupContainer-->
                    </div><!--form-group-->

                      <div class="form-group">
                        <div class="col-sm-12" inputGroupContainer>
                            <div class="input-group">
                                <input type="hidden" class="form-control" 
                                id="focus_id" name="focus_id" value="<?php echo $_SESSION['focus_id'];  ?>" placeholder="Focus ID" readonly/>
                            </div><!--input-group-->
                        </div><!--inputGroupContainer-->
                    </div><!--form-group-->

                    </form><!--form-horizontal--> 
                </div><!--modal-body-->

                <!-- Modal Footer -->
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                    <button type="submit" id="editNameSubmit" name="submit" class="btn btn-primary">Update Display Name</button>
                </div><!--modal-footer-->
            </div><!--modal-content-->
        </div><!--modal-dialog-->
    </div><!--modal login-->