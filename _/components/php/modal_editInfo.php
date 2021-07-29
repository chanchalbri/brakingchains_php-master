  <!-- Modal -->
    <div class="modal fade" id="editInfo" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">

                <!-- Modal Header -->
                <div class="modal-header">
                    <h4 class="modal-title" id="myModalLabel4">Edit Info</h4>
                </div><!--modal-header-->

               <!-- Modal Body -->
                <div class="modal-body">
                    <form class="form-horizontal" data-toggle="validator" id="replaceBoardform" role="form">

                    <div class="form-group">
                        <label for="editBoard">Select Person to Edit</label>
                        <select class="form-control" id="editBoard" name="editBoard">
                           <?php echo $_SESSION['optionsBoards']; ?> 
                        </select>
                      </div>

                    </form><!--form-horizontal--> 
                </div><!--modal-body-->

                    <!-- Modal Footer -->
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                    <button type="submit" id="editBoardSubmit" name="submit" class="btn btn-primary">Edit</button>
                </div><!--modal-footer-->
            </div><!--modal-content-->
        </div><!--modal-dialog-->
    </div><!--modal login-->