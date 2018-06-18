<!--example modal-->
<div class="modal form-modal" tabindex="-1" role="dialog" id="delete-post-modal">
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
                <p id="must-check-to-delete" class="d-none form-hidden">
                    Gotta check those checkboxes!!!
                </p>
                
                <form id="post-delete-form" method="POST" action="<?php echo htmlentities($_SERVER['REQUEST_URI']); ?>">
                    <div class="form-check">
                        <input id="delete-you-sure-1" type="checkbox" name="delete-you-sure-1" value="1" class="form-check-input delete-you-sure">
                        <label class="form-check-label" for="delete-you-sure-1">
                            I want to delete this post!
                        </label>
                    </div>
                    <div class="form-check">
                        <input id="delete-you-sure-2" type="checkbox" name="delete-you-sure-2" value="1" class="form-check-input delete-you-sure">
                        <label class="form-check-label" for="delete-you-sure-2">
                            I want to lose every word of this post!
                        </label>
                    </div>
                    <div class="form-check">
                        <input id="delete-you-sure-3" type="checkbox" name="delete-you-sure-3" value="1" class="form-check-input delete-you-sure">
                        <label class="form-check-label" for="delete-you-sure-3">
                            I never want to see this post again!
                        </label>
                    </div>

                    <input type="hidden" name="delete-uid" value="">
                    <input type="hidden" name="post-action" value="delete">
                </form>
			</div>
			<div class="modal-footer">
                <button type="button" class="btn btn-link text-secondary" data-dismiss="modal">Close</button>
                <button type="button" id="delete-budget-submit-btn" name="delete-budget-submit-btn" class="btn btn-danger disabled">Delete Forever</button>
			</div>
		</div>
	</div>
</div>