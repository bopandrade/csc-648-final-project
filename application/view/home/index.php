<div class="wrap">
  <div class="clear-top main-content-char-buff">
    <div class="website-description jumbotron">
      <h2>Students, find a place to rent near SF State.</h2>
    </div>
    <?php
      $order = 'ASC' ;
      if(isset($_GET['order'])) {
        if (strcmp($_GET['order'],'ASC')==0) {
          $order = 'DESC';
        }
      }

      if(isset($_GET['search'])) {
        $actual_link = URL . 'home/index/' . '?search=' . $_GET['search'];
      } else {
        $actual_link = URL . 'home/index/' . '?';
      }
      if(isset($_GET['min_rent'])) {
        $actual_link = $actual_link . '&min_rent=' . $_GET['min_rent'];
      } 
      if(isset($_GET['max_rent'])) {
        $actual_link = $actual_link . '&max_rent=' . $_GET['max_rent'];
      } 
      if(isset($_GET['max_time_walking'])) {
        $actual_link = $actual_link . '&max_time_walking=' . $_GET['max_time_walking'];
      } 
      if(isset($_GET['max_time_biking'])) {
        $actual_link = $actual_link . '&max_time_biking=' . $_GET['max_time_biking'];
      } 
      if(isset($_GET['max_time_driving'])) {
        $actual_link = $actual_link . '&max_time_driving=' . $_GET['max_time_driving'];
      } 
      $sort_url = $actual_link . '&order=' . $order . '&sort=';

    ?>
    <div class="metadata pull-left">
      <p>Displaying <?php echo count($listings) ?> listing<?php echo count($listings) == 1 ? "" : "s"?></p>
    </div>
    <div class="filters pull-right">
      <a href = "<?php echo $sort_url . 'distance_to_campus'; ?>" >
        <button class="btn btn-primary">Sort by distance</button>
      </a>
      <a href = "<?php echo $sort_url . 'price'; ?>" >
        <button class="btn btn-primary">Sort by price</button>
      </a>
    </div>
    <br>
    <div class="main-listings-container"> 
			<div class="row">
        <div class="search-filters col-md-2">
          <form action="<?php URL . 'home/index' ?>" method="get" role="search">
                <?php
                  if(isset($_GET['order'])) {
                    $order = $_GET['order'];
                  } else {
                    $order = "";
                  }
                  if(isset($_GET['sort'])) {
                    $sort = $_GET['sort'];
                  } else {
                    $sort = "";
                  }
                  if(isset($_GET['search'])) {
                    $search_with_filter = $_GET['search'];
                  } else {
                    $search_with_filter = "";
                  }
                ?>
              <div class="form-group">
                <div class="row">
                  <div class="col-lg-6 left-input">
                    <label class="control-label">Min Rent</label>
                    <?php
                      if(isset($_GET['min_rent'])) {
                        $min_rent = $_GET['min_rent'];
                      } else {
                        $min_rent = "";
                      }
                    ?>
                      <input class="form-control" type="number" style="width: 100%;" name="min_rent" placeholder="800" title="whole number, no letters or symbols" value="<?php echo $min_rent ?>">
                  </div>
                  <div class="col-lg-6 right-input">
                    <?php
                      if(isset($_GET['max_rent'])) {
                        $max_rent = $_GET['max_rent'];
                      } else {
                        $max_rent = "";
                      }
                    ?>
                    <label class="control-label">Max Rent</label>
                    <input class="form-control" type="number" style="width: 100%;" name="max_rent" placeholder="1500" title="whole number, no letters or symbols" value="<?php echo $max_rent ?>">
                    <input type="hidden" name="order" value="<?php echo htmlspecialchars($order, ENT_QUOTES); ?>" />
                    <input type="hidden" name="sort" value="<?php echo htmlspecialchars($sort, ENT_QUOTES); ?>" />
                    <input type="hidden" name="search" value="<?php echo htmlspecialchars($search_with_filter, ENT_QUOTES); ?>" />
                  </div>
                </div>
              </div>
              <div class="form-group">
                <?php
                  if(isset($_GET['max_time_walking'])) {
                    $max_time_walking = $_GET['max_time_walking'];
                  } else {
                    $max_time_walking = "";
                  }
                ?>
                <div class="row">
                  <div class="col-lg-12">
                    <label class="control-label">Max <i class="material-icons">directions_walk</i> to SF state in minutes</label>
                    <input class="form-control" type="number" style="width: 100%;" name="max_time_walking" placeholder="10" title="whole number, no letters or symbols" value="<?php echo $max_time_walking ?>">
                  </div>
                </div>
              </div>
              <div class="form-group">
                <?php
                  if(isset($_GET['max_time_biking'])) {
                    $max_time_biking = $_GET['max_time_biking'];
                  } else {
                    $max_time_biking = "";
                  }
                ?>
                <div class="row">
                  <div class="col-lg-12">
                    <label class="control-label">Max <i class="material-icons">directions_bike</i> to SF state in minutes</label>
                    <input class="form-control" type="number" style="width: 100%;" name="max_time_biking" placeholder="20" title="whole number, no letters or symbols" value="<?php echo $max_time_biking ?>">
                  </div>
                </div>
              </div>
              <div class="form-group">
                <?php
                  if(isset($_GET['max_time_driving'])) {
                    $max_time_driving = $_GET['max_time_driving'];
                  } else {
                    $max_time_driving = "";
                  }
                ?>
                <div class="row">
                  <div class="col-lg-12">
                    <label class="control-label">Max <i class="material-icons">directions_car</i> to SF state in minutes</label>
                    <input class="form-control" type="number" style="width: 100%;" name="max_time_driving" placeholder="30" title="whole number, no letters or symbols" value="<?php echo $max_time_driving ?>">
                  </div>
                </div>
              </div>

              <div class="form-group">
                <div class="row">
                  <div class="col-lg-12 right-input">
                    <button type="submit" class="btn btn-primary btn-block filters-btn" name="submit">Filter</button>
                  </div>
                </div>
              </div>
          </form>
        </div>
        <div class="col-md-9">
          <div class="listings">
            <?php foreach ($listings as $listing) { ?>
              <?php $image_url = $this->model->getFirstImageURLForListing($listing->id) ?>
              <div class="listing">
                <div class="thumbnail">
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
                      <?php if (in_array($listing->id, $listingIdsWithUserMessages)) { ?>
                          <button type="button" class="btn btn-success"  data-toggle="modal" data-target="#rent-now-modal<?php echo $listing->id ?>">
                              Already messaged landlord
                          </button>
                      <?php } else if (isset($_SESSION['user']) && ($_SESSION['is_student'] == 1)) { ?>
                          <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#rent-now-modal<?php echo $listing->id ?>"> Rent now </button>
                          <?php
                      } else if (isset($_SESSION['user'])) {
                          ?>
                          <button type="button" class="invalid-renter btn btn-primary">Rent now</button>
                          <?php
                      } else {
                          ?>
                          <a href="<?php echo URL; ?>user/login/list/<?php echo $listing->id; ?>"><button type="button" class="btn btn-primary" data-toggle="modal" data-target="#rent-now-modal">Rent now</button></a>
                          <?php }
                      ?>
                  </div>
                </div>
              </div>
              <?php require APP . 'view/_templates/rent_now_modal.php'; ?>
            <?php } ?>
          </div>
        </div>
			</div>
   </div>
  </div>
</div>
