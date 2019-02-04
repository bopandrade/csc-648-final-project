<?php

class Messages extends Controller
{

  /**
     * ACTION: createMessage
     * @param int $listing_id Id of the listing
  */
  public function createMessage($listing_id)
  {
    if (isset($listing_id)) {
      $message = $_POST['message'];
      $this->model->createMessage($listing_id, $_SESSION["user_id"], $message);
      header('location: ' . URL . 'listings/showListing/' . $listing_id . '?success=1&message=Successfully+sent+message+to+landlord.+They+will+get+back+to+you+shortly.');
    } else {
      header('location: ' . URL . 'home/index');
    }
  }
}
?>
