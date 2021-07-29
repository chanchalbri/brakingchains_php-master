<!-- Modal -->
<div class="modal fade" id="startBoard" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">

            <!-- Modal Header -->
            <div class="modal-header">
                <h4 class="modal-title" id="myModalLabel4">Start New Board</h4>
            </div><!--modal-header-->

           <!-- Modal Body -->
            <div class="modal-body">
                <form class="form-horizontal" data-toggle="validator" id="addFlowerForm3" role="form">

                <div class="form-group">
                    <label for="boardLevel">Select Board Level</label>
                    <select class="form-control" id="boardLevel" name="boardLevel"> 
                       <option>Gate100</option> 
                       <option>Garden500</option> 
                    </select>
                  </div>

                <div class="form-group">
                    <label for="placementMethod">Select Placement Method</label>
                    <select class="form-control" id="placementMethod" name="placementMethod" onchange="specificBoard(this.value);">
                       <option>Follow My Inviter</option> 
                       <option>Specific Tree</option>
                    </select>
                  </div>

                  <div class="form-group">
                    <div class="col-sm-12" inputGroupContainer>
                        <div class="input-group">
                            <input type="number" class="form-control" 
                            id="boardID" name="boardID" value="" style="display:none;" placeholder="Enter Tree ID"/>
                        </div><!--input-group-->
                    </div><!--inputGroupContainer-->
                </div><!--form-group-->

                </form><!--form-horizontal--> 
            </div><!--modal-body-->

            <!-- Modal Footer -->
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                <button type="submit" id="startBoardSubmit" name="submit" class="btn btn-primary">Next</button>
            </div><!--modal-footer-->
        </div><!--modal-content-->
    </div><!--modal-dialog-->
</div><!--modal login-->

<script>
    function specificBoard(val) {
        var element = document.getElementById('boardID');
        if(val == "Specific Tree") {
            element.style.display = "block";
        } else {
            element.style.display = "none";
        }
        
    }

</script>