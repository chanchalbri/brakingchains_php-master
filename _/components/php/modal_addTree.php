

 <div class="modal fade" id="addTree" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
         <div class="modal-dialog">
            <div class="modal-content">
               <div class="modal-header">
                  <h5 class="modal-title text-center" id="exampleModalLabel">Seed or Tree?</h5>
                  </button>
               </div>
               <div class="modal-body">
                  <form class="form-horizontal" data-toggle="validator" id="registerForm" role="form">
                     <div class="form-group">
                        <label class="sr-only" for="addFromSeeds"></label>
                        <div class="col-sm-12" inputgroupcontainer="">
                           <div class="input-group">
                            <button type="button" class="btn btn-primary btn-block profile-btn"  data-toggle="modal" data-target="#addFromSeeds"  onclick="getSeeds();">Add From Seeds</button>  
                           </div>
                           <!--input-group-->
                        </div>
                        <!--inputGroupContainer-->
                     </div>
                     <!--form-group-->
                     <div class="form-group">
                        <label class="sr-only" for="addFromFlower"></label>
                        <div class="col-sm-12" inputgroupcontainer="">
                           <div class="input-group">
                             <button type="button" class="btn btn-primary btn-block profile-btn"  data-toggle="modal" data-target="#addFromTrees" onclick="getTrees();">Add From Trees</button>  
                           </div>
                           <!--input-group-->
                        </div>
                        <!--inputGroupContainer-->
                     </div>
                     <!--form-group-->
                  </form>
               </div>
               <div class="modal-footer">
                  <button type="button" class="btn profile-btn1" data-dismiss="modal">Close</button>
               </div>
            </div>
         </div>
      </div>

<!--       <script src="assets/js/_myscript.js"></script> -->