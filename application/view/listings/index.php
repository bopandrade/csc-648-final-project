<div class="wrap">
  <div class="clear-top main-content-char-buff">
    <div id="my-listings" class="char-buff-container">
      <div class="create-listing modal fade" id="create-listing-modal" >
        <div class="modal-dialog" role="document">
          <div class="modal-content">
            <div class="modal-header">
              <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
              <h4 class="modal-title" id="myModal Label">Create Listing</h4>
            </div>
            <form class="create-listing form-group required" action="<?php echo URL; ?>listings/createListing" method="post" enctype="multipart/form-data">
              <div class="modal-body">
                <?php
                if(isset($errorMessage)){
                  if (count($errorMessage) > 0) {

                      foreach ($errorMessage as $error) {
                          print "<div class=\"error\"> " . $error . "</div>";
                      }
                      print "<br>";
                  }
                }
                ?>
                <div class="form-group">
                  <label for "autocomplete" class="control-label">Address</label><br>
                  <small id="addressHelp" class="form-text text-muted">We'll never share your exact address with anyone else.</small>
                  <input class="form-control" id="autocomplete" onFocus="geolocate()" type="text" size="50" required/><br>
                </div>
                <div class="form-group">
                  <label for "title" class="control-label">Title</label><br>
                  <textarea class="no-resize form-control" maxlength="100" name="title" placeholder="A short description of the listing. Max 100 chars." rows="2" cols="10" id="title" required></textarea>
                </div>
                <div class="form-group">
                  <label for "price" class="control-label">Price (per month in USD $)</label><br>
                  <input max="99999" class="form-control" type="number" name="price" id="price" placeholder="1500" value="" required/><br>
                </div>
                <div class="form-group">
                  <label for "description" class="control-label">Description</label><br>
                  <textarea class="form-control" maxlength="1000" name="description" placeholder="Describe the setting of the apartment, and any other details you think might be helpful." rows="8" cols="50" id="description" required></textarea>
                </div>
                <div class="form-group">
                  <label for "rooms" class="control-label">Rooms</label><br>
                  <input max="99" class="form-control" type="number" name="rooms" placeholder="No. of rooms for rent" id="rooms" value="" required/><br>
                </div>
                <div class="form-group">
                  <label for "bathrooms" class="control-label">Bathrooms</label><br>
                  <input max="99" class="form-control" type="number" name="bathrooms" placeholder="No. of bathrooms" id="bathrooms" value="" required/><br>
                </div>
                <div class="form-group">
                  <label for "size" class="control-label">Size (in square foot)</label><br>
                  <input max="50000" class="form-control" type="number" name="size" placeholder="1000" id="size" value="" required/><br>
                </div>
              <div class="form-group">
                <label for="file">Select a file to upload</label>
                <input type="file" id="files" name="files[]" multiple="multiple" accept="image/*" /><br>
                <small class="form-text text-muted">Only jpg,jpeg,png and gif files are allowed. You are only allowed to upload 5 images.</small>
              </div>
              <input type="hidden" name="place_id" id="place_id" />
              <input type="hidden" name="destination" id="destination" />
            </div>

            <div class="modal-footer">
              <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
              <button type="submit" class="btn btn-primary" name="submit_listing">Create Listing</button>
            </div>

          </form>
        </div>
      </div>
    </div>

    <div class="header">
      <div class="my-listings-title col-md-9">
        <h3>My Listings</h3>
      </div>
      <div class="add-listing-container">
        <button type="button" class="add-listing btn btn-primary right" data-toggle="modal" data-target="#create-listing-modal">
          Create Listing
        </button>
      </div>
    </div>
    <div class="listings">
      <?php foreach ($userListings as $listing) { ?>
        <?php $messages = $this->model->getMessagesForListing($listing->id) ?>
        <?php $image_url = $this->model->getFirstImageURLForListing($listing->id) ?>
        <div class="listing">
          <div class="thumbnail col-md-4">
            <a target="_blank" href="<?php echo URL . 'listings/showListing/' . htmlspecialchars($listing->id, ENT_QUOTES, 'UTF-8'); ?>">
              <p class="listing-title"><?php echo $listing->title ?></p>
            </a>
            <div class="thumbnail-image">
              <a target="_blank" href="<?php echo URL . 'listings/showListing/' . htmlspecialchars($listing->id, ENT_QUOTES, 'UTF-8'); ?>">
                <img width="300px" height="auto" src="<?php echo $image_url ?>" alt="apartment listing">
              </a>
                <div class="row listing-description">
                  <div class="attribute"><span><?php echo $listing->room_count ?></span>rooms</div>
                  <div class="attribute bathroom"><span><?php echo $listing->bathroom_count ?></span>bathrooms</div>
                  <div class="attribute squarefoot"><span><?php echo $listing->square_foot ?></span>sqft</div>
                </div>
                <div class="listing-thumbnail-price">
                  <span>$</span>
                  <?php echo $listing->price ?>
                </div>
              </div>
            <div class="caption">
              <div class="distance-overview">
                <div class="distance-item walking">
                  <i class="material-icons">directions_walk</i>
                  <div class="short-distance-text">
                    <?php echo $listing->time_walking ?>
                  </div>
                </div>
                <div class="distance-item biking">
                  <i class="material-icons">directions_bike</i>
                  <div class="short-distance-text">
                    <?php echo $listing->time_biking ?>
                  </div>
                </div>
                <div class="distance-item driving">
                  <i class="material-icons">directions_car</i>
                  <div class="short-distance-text">
                    <?php echo $listing->time_driving ?>
                  </div>
                </div>
              </div>
            </div>
            <button type="button" class="delete-listing btn btn-danger" data-toggle="modal" data-target="#delete-modal<?php echo $listing->id ?>">Delete</button>
          </div>
          <div class="messages col-md-7">
            <h3>Messages</h3>
            <?php $messageCounter = 0; ?>
            <?php foreach ($messages as $message) { ?>
              <?php $message_from = $this->model->getUser($message->user_id) ?>
              <div <?php $messageCounter++; echo ($messageCounter==count($messages))?'class="message last"':'class="message"'; ?>>
                <div class="message-header">
                  <p><?php echo $message_from->first_name . " " . $message_from->last_name ?></p>
                  <span><?php echo date('d F Y', strtotime($message->created_at)) ?></span>
                </div>
                <p><?php echo $message->body ?></p>
                <div class="contact-container">
                <a href="mailto:<?php echo $message_from->email ?>?subject=Thanks for getting in touch about my listing: <?php echo $listing->title ?>"><button class="btn btn-primary">Message student</button></a>
                </div>
              </div>
            <?php } ?>
            <?php require APP . 'view/_templates/delete_modal.php'; ?>
          </div>
        </div>
      <?php } ?>
    </div>
  </div>
</div>
</div>

  <?php if(isset($errorMessage)) { ?>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
    <script src="<?php echo URL; ?>js/modalPopUp.js"></script>
  <?php } ?>

  <script src="<?php echo URL; ?>js/googleAPI.js"></script>

  <script src="https://maps.googleapis.com/maps/api/js?key=INSER_GOOGLE_API_KEY&libraries=places&callback=initAutocomplete"
  async defer></script>

