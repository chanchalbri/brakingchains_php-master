<!-- Modal -->
<div class="modal fade" id="updateInfo" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">

            <!-- Modal Header -->
            <div class="modal-header">
                <h4 class="modal-title" id="myModalLabel7">Update Info</h4>
            </div>

            <!-- Modal Body -->
            <div class="modal-body">
                <form class="form-horizontal" data-toggle="validator" id="updateInfoForm" role="form">
                    
                <div class="form-group">
                    <label for="addReferrer">Select Inviter</label>
                    <select class="form-control referrer_name" name="referrer_name">
                       <?php echo $_SESSION['optionsBoards']; ?> 
                    </select>
                  </div>

                  <div class="form-group">
                    <label  class="sr-only" for="first_name">First Name</label>
                    <div class="col-sm-12" inputGroupContainer>
                        <div class="input-group">
                            <span class="input-group-addon"><i class="glyphicon glyphicon-user"></i></span>
                            <input type="text" class="form-control first_name" 
                            name="first_name" placeholder="First Name"/>
                        </div><!--input-group-->
                    </div><!--inputGroupContainer-->
                  </div><!--form-group-->

                    <div class="form-group">
                        <label  class="sr-only" for="last_name">Last Name</label>
                        <div class="col-sm-12" inputGroupContainer>
                            <div class="input-group">
                                <span class="input-group-addon"><i class="glyphicon glyphicon-user"></i></span>
                                <input type="text" class="form-control last_name" 
                                name="last_name" placeholder="Last Name"/>
                            </div><!--input-group-->
                        </div><!--inputGroupContainer-->
                    </div><!--form-group-->

                    <div class="form-group">
                        <label  class="sr-only" for="email">Email</label>
                        <div class="col-sm-12" inputGroupContainer>
                            <div class="input-group">
                                <span class="input-group-addon"><i class="glyphicon glyphicon-envelope"></i></span>
                                <input type="email" class="form-control email" 
                                name="email" placeholder="Email"/>
                            </div><!--input-group-->
                        </div><!--inputGroupContainer-->
                    </div><!--form-group-->

                  <div class="form-group">
                    <label class="sr-only" for="phone" >Phone</label>
                    <div class="col-sm-12" inputGroupContainer>
                        <div class="input-group">
                            <span class="input-group-addon"><i class="glyphicon glyphicon-earphone"></i></span>
                            <input type="tel" class="form-control phone"
                            name="phone" data-minlength="6" placeholder="Phone"/>
                        </div><!--input-group-->
                    </div><!--inputGroupContainer-->
                  </div><!--form-group-->

                    <div class="form-group">
                        <div class="col-sm-12" inputGroupContainer>
                            <div class="input-group">
                                <input type="hidden" class="form-control tlf_id" 
                                name="tlf_id" value="" placeholder="TLF ID" readonly/>
                            </div><!--input-group-->
                        </div><!--inputGroupContainer-->
                    </div><!--form-group-->

                </form> 
            </div><!--modal-body-->

            <!-- Modal Footer -->
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                <button type="submit" id="updateSubmit" name="submit" class="btn btn-primary">Update</button>
            </div><!--modal-footer-->
        </div><!--modal-content-->
    </div><!--modal-dialog-->
</div><!--modal register-->