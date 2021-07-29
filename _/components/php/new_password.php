<!-- Modal -->
<div class="modal fade" id="register" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            
            <!-- Modal Header -->
            <div class="modal-header">
                <h4 class="modal-title" id="myModalLabel">Enter New Gifter</h4>
            </div>
            
            <!-- Modal Body -->
            <div class="modal-body">
                <form class="form-horizontal" data-toggle="validator" id="registerForm" role="form">
                    
                  <div class="form-group">
                    <label  class="sr-only" for="first_name">First Name</label>
                    <div class="col-sm-12" inputGroupContainer>
                        <div class="input-group">
                            <span class="input-group-addon"><i class="glyphicon glyphicon-user"></i></span>
                            <input type="text" class="form-control" 
                            id="first_name" name="first_name" placeholder="First Name"/>
                        </div><!--input-group-->
                    </div><!--inputGroupContainer-->
                  </div><!--form-group-->
                    
                    <div class="form-group">
                        <label  class="sr-only" for="last_name">Last Name</label>
                        <div class="col-sm-12" inputGroupContainer>
                            <div class="input-group">
                                <span class="input-group-addon"><i class="glyphicon glyphicon-user"></i></span>
                                <input type="text" class="form-control" 
                                id="last_name" name="last_name" placeholder="Last Name"/>
                            </div><!--input-group-->
                        </div><!--inputGroupContainer-->
                    </div><!--form-group-->
                    
                    <div class="form-group">
                        <label  class="sr-only" for="email">Email</label>
                        <div class="col-sm-12" inputGroupContainer>
                            <div class="input-group">
                                <span class="input-group-addon"><i class="glyphicon glyphicon-envelope"></i></span>
                                <input type="email" class="form-control" 
                                id="email" name="email" placeholder="Email"/>
                            </div><!--input-group-->
                        </div><!--inputGroupContainer-->
                    </div><!--form-group-->
                    
                  <div class="form-group">
                    <label class="sr-only" for="phone" >Phone</label>
                    <div class="col-sm-12" inputGroupContainer>
                        <div class="input-group">
                            <span class="input-group-addon"><i class="glyphicon glyphicon-lock"></i></span>
                            <input type="text" class="form-control"
                            id="phone" name="phone" data-minlength="6" placeholder="Phone"/>
                        </div><!--input-group-->
                    </div><!--inputGroupContainer-->
                  </div><!--form-group-->
                    
                <div class="form-group">
                    <label  class="sr-only" for="referrer_name"><?php echo $referrer; ?></label>
                    <div class="col-sm-12" inputGroupContainer>
                        <div class="input-group">
                            <span class="input-group-addon"><i class="glyphicon glyphicon-user"></i></span>
                            <input type="text" class="form-control" 
                            id="referrer_name" name="referrer_name" value="<?php echo $referrer; ?>"/>
                        </div><!--input-group-->
                        <p class="desc">Referrer</p>
                    </div><!--inputGroupContainer-->
                </div><!--form-group-->
                    
                    <div class="form-group">
                        <label  class="sr-only" for="fireDate">Fire Date</label>
                        <div class="col-sm-12" inputGroupContainer>
                            <div class="input-group">
                                <span class="input-group-addon"><i class="glyphicon glyphicon-lock"></i></span>
                                <input type="date" class="form-control" 
                                id="fireDate" name="fireDate"  placeholder="Fire Date"/>
                            </div><!--input-group-->
                            <p class="desc">Enter Fire Date - must be a Sunday</p>
                        </div><!--inputGroupContainer-->
                    </div><!--form-group-->
                    
                    <div class="form-group">
                        <div class="col-sm-12" inputGroupContainer>
                            <div class="input-group">
                                <input type="hidden" class="form-control" 
                                id="air_id" name="air_id" value="<?php echo $fire_id; ?>" placeholder="Referrer Code" readonly/>
                            </div><!--input-group-->
                        </div><!--inputGroupContainer-->
                    </div><!--form-group-->
                    
                </form> 
            </div><!--modal-body-->
            
            <!-- Modal Footer -->
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                <button type="submit" id="regSubmit" name="submit" class="btn btn-primary">Add</button>
            </div><!--modal-footer-->
        </div><!--modal-content-->
    </div><!--modal-dialog-->
</div><!--modal register-->
