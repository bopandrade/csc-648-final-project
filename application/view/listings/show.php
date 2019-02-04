<div class="wrap">
  <div class="clear-top main-content-char-buff">
    <div class="listing-hero-container">
      <?php $image_url = $this->model->getFirstImageURLForListing($listing->id) ?>
      <img class="hero" src="<?php echo $image_url ?>" alt="apartment listing">

      <button type="button" class="btn btn-primary btn-lg bottomleft1" data-toggle="modal" data-target="#myModal">View Photos</button>

      <div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
        <div class="modal-dialog" role="document">
          <div class="modal-content">
            <div class="modal-header">
              <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
              <h4 class="modal-title" id="myModalLabel">Images</h4>
            </div>
            <div class="modal-body">
              <?php $images = $this->model->getImagesForListing($listing->id) ?>
              <div id="carousel" class="carousel slide" data-ride="carousel">
                <ol class="carousel-indicators">
                  <?php $imageCounter = 0; ?>
                  <?php foreach ($images as $image) { ?>
                    <li data-target="#carousel" data-slide-to="<?php echo $imageCounter ?>" <?php $imageCounter++; echo ($imageCounter== 1)?'class="active"':'class=""'; ?>></li>
                  <?php } ?>
                </ol>

                <div class="carousel-inner" role="listbox">
                  <?php $imageCounter = 0; ?>
                  <?php foreach ($images as $image) { ?>
                    <div <?php $imageCounter++; echo ($imageCounter== 1)?'class="active item"':'class="item"'; ?>>
                      <img src="<?php echo URL . $image->file_path ?>" alt="apartment-image">
                    </div>
                  <?php } ?>
                </div>

              <a class="left carousel-control" href="#carousel" role="button" data-slide="prev">
                <span class="glyphicon glyphicon-chevron-left" aria-hidden="true"></span>
                <span class="sr-only">Previous</span>
              </a>
              <a class="right carousel-control" href="#carousel" role="button" data-slide="next">
                <span class="glyphicon glyphicon-chevron-right" aria-hidden="true"></span>
                <span class="sr-only">Next</span>
              </a>
            </div>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
          </div>
        </div>
      </div>
    </div>

    <a class="btn btn-default btn-lg bottomleft2" href="#gmap_canvas" role="button">Map</a>
</div>
<div class="container-fluid">
  <div class="col-md-8">
    <h3 class="listing-title"><?php echo $listing->title ?></h3>
    <div class="listing-long-description">
      <p><?php echo $listing->description ?></p>
    </div>

    <div class="col-md-4">
      <h4 class="detail-header">Listing Details</h4>
      <p class=""><?php echo $listing->room_count ?> rooms</p>
      <p class=""><?php echo $listing->bathroom_count ?> bathrooms</p>
      <p class=""><?php echo $listing->square_foot ?> sqft</p>
    </div>
    <div class="col-md-4 distance-details">
      <h4 class="detail-header">Distance to SF State campus</h4>
      <p class=""><i class="material-icons">place</i><?php echo $listing->distance_to_campus_text ?> </p>
      <p class=""><i class="material-icons">directions_walk</i> <?php echo $listing->time_walking ?></p>
      <p class=""><i class="material-icons">directions_bike</i> <?php echo $listing->time_biking ?></p>
      <p class=""><i class="material-icons">directions_car</i> <?php echo $listing->time_driving ?></p>
    </div>
  </div>

<div class="listing-price col-md-4">
  <h2>$<?php echo $listing->price ?>/month</h2>
  <?php if(in_array($listing->id, $listingIdsWithUserMessages)) { ?>
    <button type="button" class="btn btn-success" data-toggle="modal" data-target="#rent-now-modal<?php echo $listing->id ?>"> Already messaged landord </button>
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
<?php
}
?>
</div>

<div id='gmap_canvas' class="img-responsive" style='height:400px;width:100%;'></div>
</div>
</div>
</div>

<?php require APP . 'view/_templates/rent_now_modal.php'; ?>
<script type="text/javascript">
var latitude = <?php echo $listing->latitude ?>;
var longitude = <?php echo $listing->longitude ?>;
</script>
<script src="<?php echo URL; ?>js/listing.js"></script>
<script async defer
src= <?php echo "https://maps.googleapis.com/maps/api/js?key=".API_KEY."&callback=initMap"?> >
</script>
