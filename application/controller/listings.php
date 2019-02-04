<?php

class Listings extends Controller
{

  /**
     * ACTION: showListing
     * This method handles what happens when you move to http://yourproject/listings/:id
     * @param int $listing_id Id of the to-view listing
  */
  public function showListing($listing_id)
  {
    //TODO: Error handling
    if (isset($listing_id)) {
      $listing = $this->model->getListing($listing_id);
       if(isset($_SESSION['user_id'])) {
         $listingIdsWithUserMessages = $this->model->getListingIdsWithUserMessages($_SESSION["user_id"]);
       } else {
         $listingIdsWithUserMessages = [];
       }
       
      require APP . 'view/_templates/header.php';
      if ($listing) {
      require APP . 'view/listings/show.php';
      }
      require APP . 'view/_templates/footer.php';
    } else {
      header('location: ' . URL . 'home/index');
    }

  }

  public function index()
  {
    $userListings = [];

    if(isset($_SESSION['user_id'])) {

      $userListings = $this->model->getListingsForUser($_SESSION["user_id"]);

      require APP . 'view/_templates/header.php';
      require APP . 'view/listings/index.php';
      require APP . 'view/_templates/footer.php';

    } else {
      header('location: ' . URL . 'user/login');

    }
  }

  /**
   * ACTION: createListing
   * This method creates a new listing
   */
  public function createListing()
  {
    $errorMessage = array();

    if ($_POST['place_id'] == '' || $_POST['place_id'] == "undefined") {
        array_push($errorMessage, "Please give a valid address");
    }
    if ($_POST['title'] == '') {
        array_push($errorMessage, "Please add a title for the listing");
    }
    if ($_POST['price'] == '' || !is_numeric($_POST['price'])) {
        array_push($errorMessage, "Please add a price for the listing");
    }
    if ($_POST['description'] == '') {
        array_push($errorMessage, "Please add a brief description of the listing");
    }
    if ($_POST['rooms'] == '' || !is_numeric($_POST['rooms'])) {
        array_push($errorMessage, "Please add the number of rooms");
    }
    if ($_POST['bathrooms'] == '' || !is_numeric($_POST['bathrooms'])) {
        array_push($errorMessage, "Please add the number of bathrooms");
    }
    if ($_POST['size'] == '' || !is_numeric($_POST['size'])) {
        array_push($errorMessage, "Please add the size in square footage");
    }

    if(count($errorMessage)==0) {

      $destination_place_id = $_POST['place_id'];

      if(isset($_SESSION['user_id'])) {
        $user_id = $_SESSION['user_id'];
      }

      $url_api = 'https://maps.googleapis.com/maps/api/directions/json?origin=place_id:'.ORIGIN.'&destination=place_id:'.$destination_place_id;

      $requestDriving = $url_api.'&mode=driving&key='.API_KEY;
      $requestWalking = $url_api.'&mode=walking&key='.API_KEY;
      $requestBicycling = $url_api.'&mode=bicycling&key='.API_KEY;

      $responseDriving = json_decode(file_get_contents($requestDriving));
      $responseWalking = json_decode(file_get_contents($requestWalking));
      $responseBicycling = json_decode(file_get_contents($requestBicycling));

      $address = $responseDriving->routes[0]->legs[0]->end_address;

      $distance_text = $responseDriving->routes[0]->legs[0]->distance->text;
      $distance_int = $responseDriving->routes[0]->legs[0]->distance->value;

      $time_driving = $responseDriving->routes[0]->legs[0]->duration->text;
      $time_biking = $responseBicycling->routes[0]->legs[0]->duration->text;
      $time_walking = $responseWalking->routes[0]->legs[0]->duration->text;
      $time_driving_value = $responseDriving->routes[0]->legs[0]->duration->value;
      $time_biking_value  = $responseBicycling->routes[0]->legs[0]->duration->value;
      $time_walking_value = $responseWalking->routes[0]->legs[0]->duration->value;

      $latitude = $responseDriving->routes[0]->legs[0]->end_location->lat;
      $longitude = $responseDriving->routes[0]->legs[0]->end_location->lng;

      //Adding only for userid=1 default for admin. Only for testing. Remove comment when new user functionality is ready
      if (isset($_POST["submit_listing"])) {

    	  $listing_id = $this->model->createListing($address, $_POST["title"],
                        $_POST["place_id"], $_POST["price"],
                        $_POST["description"], $_POST["rooms"],
                        $_POST["bathrooms"], $_POST["size"],
                        $distance_int, $distance_text,
                        $time_walking, $time_driving,
                        $time_biking, $time_driving_value,
                        $time_biking_value, $time_walking_value,
                        $latitude, $longitude,
                        $user_id, $_FILES);
          
          
        header('Location: ' . URL . 'listings/showListing/' . $listing_id . '?success=1&message=Successfully+created+listing');
      } else {
        header("Location: " . URL . "home/index/");
      }


    } else {

      $userListings = [];
      $userListings = $this->model->getListingsForUser($_SESSION["user_id"]);

      require APP . 'view/_templates/header.php';
      require APP . 'view/listings/index.php';
      require APP . 'view/_templates/footer.php';

    }

  }

  public function deleteListing($listing_id)
  {
    if (isset($listing_id)) {
      $listing = $this->model->deleteListing($listing_id);
    }

    header('location: ' . URL . 'listings/index' . '?success=1&message=Successfully+deleted+listing');
  }

}
