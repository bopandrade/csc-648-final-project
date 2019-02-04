<div class="modal fade rent-now-modal" id="rent-now-modal<?php echo $listing->id ?>" tabindex="-1" role="dialog" aria-labelledby="myModal<?php echo $listing->id ?>Label">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModal<?php echo $listing->id ?>Label"><?php echo $listing->title ?></h4>
      </div>
      <div class="modal-body">
        <img class="main-image" width="100%" height="auto" src="<?php echo $image_url ?>" alt="apartment listing">
        <p class="listing-description"><?php echo $listing->description ?></p>
        <label>Details</label><br/>
        <div class="">
        <p class=""><?php echo $listing->room_count ?> rooms</p>
        <p class="bathroom"><?php echo $listing->bathroom_count ?> bathrooms</p>
        <p class="squarefoot"><?php echo $listing->square_foot ?> sqft</p>
        </div>
        <label>Distance to SF State campus</label><br/>
        <div class="separator">
          <p class=""><i class="material-icons">place</i><?php echo $listing->distance_to_campus_text ?> </p>
          <p class=""><i class="material-icons">directions_walk</i> <?php echo $listing->time_walking ?></p>
          <p class=""><i class="material-icons">directions_bike</i> <?php echo $listing->time_biking ?></p>
          <p class=""><i class="material-icons">directions_car</i> <?php echo $listing->time_driving ?></p>
        </div>
        <?php if (isset($_SESSION['user'])) { ?>
          <?php if(in_array($listing->id, $listingIdsWithUserMessages)) { ?>
            <?php $messages = $this->model->getMessageByUserOnListing($listing->id, $_SESSION['user_id']) ?>
            <p>Messaged landlord on <span><?php echo date('d F Y', strtotime($messages[0]->created_at)) ?></span></p>
            <p><?php echo $messages[0]->body ?></p>
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            </div>
          <?php } else { ?>
            <form class="rent-now-form form-group required " role="rent" method="post" action="<?php echo URL . 'messages/createMessage/' . htmlspecialchars($listing->id, ENT_QUOTES, 'UTF-8'); ?>">
              <div class="form-group">
                <label class="control-label" for="message">Message to Landlord</label><br/>
                <small id="emailHelp" class="form-text text-muted">Once you send a message, we will share your email address with the landlord.</small>
                <textarea max-length="1000" class="form-control" columns="20" name="message" required="required"></textarea>
              </div>
              <button type="submit" class="btn btn-primary">Send Message</button>
            </form>
            </div>
            <div class="rent-now-modal-footer modal-footer">
              <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            </div>
          <?php } ?>
        <?php
        }  else { ?>
          <p>
            You must <a id="header-buttons" href="<?php echo URL; ?>user/register">Sign up</a> or <a id="header-buttons" href="<?php echo URL; ?>user/login">Login</a> in order to message the landlord.
          </p>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
          </div>
        <?php
        }
        ?>
    </div>
  </div>
</div>
