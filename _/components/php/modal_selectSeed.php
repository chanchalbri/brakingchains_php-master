  <!-- Modal -->
    <div class="modal fade" id="addFromSeeds" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">

                <!-- Modal Header -->
                <div class="modal-header">
                    <h4 class="modal-title" id="myModalLabel2">Add Tree</h4>
                </div><!--modal-header-->

               <!-- Modal Body -->
                <div class="modal-body">
                    <form class="form-horizontal" data-toggle="validator" id="addFlowerForm" role="form">

                    <div class="form-group">
                        <label for="addSeed">Select Seed to Add</label>
                        <select class="form-control addSeed" id="addSeed">
                        </select>
                      </div>

                      <div class="form-group">
                        <label  class="sr-only" for="fireDate2">Enter Fire Date</label>
                        <div class="col-sm-12" inputGroupContainer>
                            <div class="input-group">
                                <span class="input-group-addon"><i class="glyphicon glyphicon-calendar"></i></span>
                                <input type="date" class="form-control" 
                                id="fireDate2" name="fireDate2"  placeholder="Fire Date"/>
                            </div><!--input-group-->
                            <p class="desc" id="seedDesc">Enter Fire Date (MUST BE A SUNDAY!)</p>
                        </div><!--inputGroupContainer-->
                    </div><!--form-group-->

                      <div class="form-group">
                        <div class="col-sm-12" inputGroupContainer>
                            <div class="input-group">
                                <input type="hidden" class="form-control" 
                                id="lotus_id2" name="lotus_id2" value="<?php echo $_SESSION['focus_flower_id'];  ?>" placeholder="Lotus ID" readonly/>
                            </div><!--input-group-->
                        </div><!--inputGroupContainer-->
                    </div><!--form-group-->

                    </form><!--form-horizontal--> 
                </div><!--modal-body-->

                <!-- Modal Footer -->
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                    <button type="submit" id="addSeedSubmit" name="submit" class="btn btn-primary">Create Tree</button>
                </div><!--modal-footer-->
            </div><!--modal-content-->
        </div><!--modal-dialog-->
    </div><!--modal login-->