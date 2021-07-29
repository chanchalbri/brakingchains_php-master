  <!-- Modal -->
    <div class="modal fade" id="editDate" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">

                <!-- Modal Header -->
                <div class="modal-header">
                    <h4 class="modal-title" id="editDateModalLabel">Edit Sow Date</h4>
                </div><!--modal-header-->

               <!-- Modal Body -->
                <div class="modal-body">
                    <form class="form-horizontal" data-toggle="validator" id="editDateForm" role="form">

                      <div class="form-group">
                        <label  class="sr-only" for="sowDate">Enter Sow Date</label>
                        <div class="col-sm-12" inputGroupContainer>
                            <div class="input-group">
                                <span class="input-group-addon"><i class="glyphicon glyphicon-calendar"></i></span>
                                <input type="date" class="form-control" 
                                id="sowDate" name="sowDate"  placeholder="Seed Date"/>
                            </div><!--input-group-->
                            <p class="desc">Enter Sow Date - MUST be a Sunday</p>
                        </div><!--inputGroupContainer-->
                    </div><!--form-group-->

                      <div class="form-group">
                        <div class="col-sm-12" inputGroupContainer>
                            <div class="input-group">
                                <input type="hidden" class="form-control" 
                                id="this_lotus_id" name="this_lotus_id" value="<?php echo $_SESSION['focus_id'];  ?>" placeholder="Lotus ID" readonly/>
                            </div><!--input-group-->
                        </div><!--inputGroupContainer-->
                    </div><!--form-group-->

                    </form><!--form-horizontal--> 
                </div><!--modal-body-->

                <!-- Modal Footer -->
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                    <button type="submit" id="editDateSubmit" name="submit" class="btn btn-primary">Update Sow Date</button>
                </div><!--modal-footer-->
            </div><!--modal-content-->
        </div><!--modal-dialog-->
    </div><!--modal login-->
                    