<div class="modal fade" id="delete-modal<?php echo $listing->id ?>" tabindex="-1" role="dialog" aria-labelledby="myModal<?php echo $listing->id ?>Label">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModal<?php echo $listing->id ?>Label">Delete <?php echo $listing->title ?></h4>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        <a href="<?php echo URL . 'listings/deleteListing/' . htmlspecialchars($listing->id, ENT_QUOTES, 'UTF-8'); ?>">
          <button type="button" name="button" class="btn btn-danger">Delete</button>
        </a>
      </div>
    </div>
  </div>
</div>
