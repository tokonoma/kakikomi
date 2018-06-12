<!--example modal-->
<div class="modal" tabindex="-1" role="dialog" id="delete-post-modal">
	<div class="modal-dialog modal-dialog-centered" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title">Delete Post</h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<div class="modal-body">
				<p>Are you sure you want to <strong>DELETE</strong> post titled <strong><span class="print-post-title"></span></strong>?</p>
                <p>Please check the following boxes to delete this budget</p>

                <p id="must-check-to-delete" class="hidden form-hidden">Gotta check those checkboxes!!!</p>
                
                <form id="budget-delete-form" method="POST" action="<?php echo htmlentities($_SERVER['REQUEST_URI']); ?>">
                    <div class="checkbox">
                        <label>
                            <input id="delete-you-sure-1" type="checkbox" name="delete-you-sure-1" value="1" class="delete-you-sure"> I want to delete this budget!
                        </label>
                    </div>
                   <div class="checkbox">
                        <label>
                            <input id="delete-you-sure-2" type="checkbox" name="delete-you-sure-2" value="1" class="delete-you-sure"> I want to destroy all data concerning this budget!
                        </label>
                    </div>
                    <div class="checkbox">
                        <label>
                            <input id="delete-you-sure-3" type="checkbox" name="delete-you-sure-3" value="1" class="delete-you-sure"> I want to never see this budget again!
                        </label>
                    </div>
                    <input type="hidden" name="deduct-uid" value="">
                    <input type="hidden" name="budgetaction" value="delete">
                </form>
			</div>
			<div class="modal-footer">
				<button type="button" id="delete-budget-submit-btn" name="delete-budget-submit-btn" class="btn btn-danger disabled-fade">Delete Forever</button>
				<button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
			</div>
		</div>
	</div>
</div>