<?php

$SALT = "buia7d88hdgs87dbdaujdasoi8728hsabdiue92"; //passwords are hashed with this random salt to avoid the use of rainbow table attacks

class Model {

  /**
   * @param object $db A PDO database connection
   */
  function __construct($db) {

    try {
          $this->db = $db;
        } catch (PDOException $e) {
            exit('Database connection could not be established.');
        }
    }

    public function deleteListing($listing_id) {
      $sql = "DELETE FROM listings WHERE id = :listing_id";
      $query = $this->db->prepare($sql);
      $parameters = array(':listing_id' => $listing_id);

      $query->execute($parameters);
    }

    public function createMessage($listing_id, $user_id, $body) {
      $sql = "INSERT INTO messages (listing_id, user_id, body, updated_at, created_at) VALUES (:listing_id, :user_id, :body, now(), now());";
      $query = $this->db->prepare($sql);
      $parameters = array(':listing_id' => $listing_id, ':user_id' => $user_id, ':body' => $body);

      return $query->execute($parameters);
    }

    public function sanitize_input($value) {
        if (get_magic_quotes_gpc()) {
            $value = stripslashes($value);
        }

        if (!is_numeric($value)) {
            $value = $this->db->quote($value);
        }

        $value = $uname = htmlspecialchars($value);

        return $value;
    }

    public function login($email, $password) {
        global $SALT;
        $email = $this->sanitize_input($email);
        $password = $this->sanitize_input($password);
        $password = md5($SALT . $password . $SALT);


        $sql = "select id, is_student from users where email= $email and password = '$password'";

        $query = $this->db->prepare($sql);
        $query->execute();
        return $query->fetchAll();
    }

    public function check_email($email) {
        $email = $this->sanitize_input($email);

        $sql = "SELECT id From users where email = $email";

        $query = $this->db->prepare($sql);
        $query->execute();
        return $query->fetchAll();
    }

    public function register($email, $password, $first_name, $last_name, $student) {
        global $SALT;
        $email = $this->sanitize_input($email);
        $password = $this->sanitize_input($password);
        $password = md5($SALT . $password . $SALT);
        $first_name = $this->sanitize_input($first_name);
        $last_name = $this->sanitize_input($last_name);
        $student = $this->sanitize_input($student);



        $sql = "INSERT INTO users (email, password, first_name, last_name, is_student, created_at, updated_at) VALUES ($email, '$password', $first_name, $last_name, $student, now(), now());SELECT LAST_INSERT_ID()";

        $query = $this->db->prepare($sql);
        $query->execute();

        $sql = "select * from users where email = $email and password = '$password' ";
        $query = $this->db->prepare($sql);
        $query->execute();

        return $query->fetch();
    }

    public function getListings($searchParameter, $sort, $min_rent, $max_rent, $max_time_walking, $max_time_driving, $max_time_biking) {
        $has_where = false;
        if (empty($searchParameter)) {
          $sql = "SELECT * From listings";
        } else {
          $has_where = true;
          $sql = "SELECT * From listings where title LIKE '%$searchParameter%' or description LIKE '%$searchParameter%' or address LIKE '%$searchParameter%' ";
        }
        if (!empty($min_rent)) {
          if($has_where) {
            $sql = $sql." AND price >= $min_rent ";
          } else {
            $sql = $sql." where price >= $min_rent ";
            $has_where = true;
          }
        }
        if (!empty($max_rent)) {
          if($has_where) {
            $sql = $sql." AND price <= $max_rent ";
          } else {
            $sql = $sql." where price <= $max_rent ";
            $has_where = true;
          }
        }
        if (!empty($max_time_walking)) {
          $max_time_walking = 60 * $max_time_walking + ($max_time_walking >= 60 ? 60*29 : 29);
          if($has_where) {
            $sql = $sql." AND time_walking_value <= $max_time_walking ";
          } else {
            $sql = $sql." where time_walking_value <= $max_time_walking ";
            $has_where = true;
          }
        }
        if (!empty($max_time_biking)) {
          $max_time_biking = 60 * $max_time_biking + ($max_time_biking >= 60 ? 60*29 : 29);
          if($has_where) {
            $sql = $sql." AND time_biking_value <= $max_time_biking ";
          } else {
            $sql = $sql." where time_biking_value <= $max_time_biking ";
            $has_where = true;
          }
        }
        if (!empty($max_time_driving)) {
          $max_time_driving = 60 * $max_time_driving + ($max_time_driving >= 60 ? 60*29 : 29);
          if($has_where) {
            $sql = $sql." AND time_driving_value <= $max_time_driving ";
          } else {
            $sql = $sql." where time_driving_value <= $max_time_driving ";
            $has_where = true;
          }
        }

        $sql = $sql . ' ' . $sort;


        //echo '[ PDO DEBUG ]: ' . $sql;  exit();
        $query = $this->db->prepare($sql);
        $query->execute();
        return $query->fetchAll();
    }
    /**
     * Get listings that the user has created.
     */
    public function getListingsForUser($user_id) {
      $sql = "SELECT * FROM listings where user_id = '$user_id'";
      $query = $this->db->prepare($sql);
      $query->execute();
      return $query->fetchAll();
    }
    /**
     * Get listing ids for which the user
     * has sent a message to the landlord
     */
    public function getListingIdsWithUserMessages($user_id) {
      $sql = "SELECT listing_id FROM messages where user_id = '$user_id'";
      $query = $this->db->prepare($sql);
      $query->execute();
      $records = $query->fetchAll();
      return array_map(function ($message) { return $message->listing_id; }, $records);

    }

    public function getMessagesForListing($listing_id) {
      $sql = "SELECT * FROM messages where listing_id = $listing_id";
      $query = $this->db->prepare($sql);
      $query->execute();
      return $query->fetchAll();
    }

    public function getMessageByUserOnListing($listing_id, $user_id) {
      $sql = "SELECT * FROM messages where listing_id = $listing_id and user_id = $user_id";
      $query = $this->db->prepare($sql);
      $query->execute();
      return $query->fetchAll();
    }
    
    
    
    public function createListing($address, $title, $place_id, $price, $description,
    		$rooms, $bathrooms, $size , $distance_int, $distance_text,
       	$time_walking, $time_driving, $time_biking, $time_driving_value, $time_biking_value, $time_walking_value, $latitude, $longitude, $userId, $files)
    {
      $sql = "INSERT INTO listings (
      		address, title, place_id, price, description,
      		room_count, bathroom_count, square_foot, distance_to_campus,
          distance_to_campus_text, time_walking, time_driving, time_biking, time_driving_value,
          time_biking_value, time_walking_value, latitude, longitude,
          user_id, active, created_at)

      		VALUES (
      		:address, :title, :place_id, :price, :description,
      		:room_count, :bathroom_count, :square_foot, :distance_to_campus,
          :distance_to_campus_text, :time_walking, :time_driving, :time_biking, :time_driving_value,
          :time_biking_value, :time_walking_value, :latitude, :longitude,
          :user_id, 1, now()
      		)";
      $query = $this->db->prepare($sql);

      $parameters = array(':address' => $address, ':title' => $title, ':place_id' => $place_id, ':price' => $price, ':description' => $description,
      		':room_count' => $rooms, ':bathroom_count' => $bathrooms, ':square_foot' => $size, ':distance_to_campus' => $distance_int,
      		':distance_to_campus_text' => $distance_text, ':time_walking' => $time_walking, ':time_driving' => $time_driving,
          ':time_biking' => $time_biking, ':time_driving_value' => $time_driving_value,
          ':time_biking_value' => $time_biking_value, ':time_walking_value' => $time_walking_value,
          ':latitude' => $latitude, ':longitude' => $longitude, ':user_id' => $userId
      );


      $query->execute($parameters);
      
      $listing_id = $this->db->lastInsertId();

      $this->createImagesForListing($listing_id, $files);

      return $listing_id;
    }

    /**
     * Creates images for a listing
     */
    public function createImagesForListing($listing_id, $files) {
      $loc= "/var/www/charbuff.net/public/uploads/"; // server path
      $database_location = "uploads/"; //database path
      $i=sizeof($files);
      $max_number_of_files = min($i, 5); // max number of files is 5

      for($j=0;$j<$max_number_of_files;$j++) {
        $filename = time() . "_" . $files['files']['name'][$j];
        $filename =preg_replace('/\s+/', '', $filename);
        if(move_uploaded_file($files['files']['tmp_name'][$j],$loc.$filename)) {
          $filepath = $database_location.$filename;
          $sql = "INSERT INTO media (listing_id, media_type, file_path, created_at, updated_at) VALUES (:listing_id, 'image', :file_path, now(), now());";
          $parameters = array(':listing_id' => $listing_id, ':file_path' => $filepath);
          $query = $this->db->prepare($sql);
          $query->execute($parameters);
        }
      }
    }

    /**
     * Get a listing from database
     */
    public function getListing($listing_id) {
        $sql = "SELECT * FROM listings WHERE id = :listing_id LIMIT 1";
        $query = $this->db->prepare($sql);
        $parameters = array(':listing_id' => $listing_id);

        $query->execute($parameters);

        // fetch() is the PDO method that get exactly one result
        return $query->fetch();
    }

    /**
     * Get a user from database
     */
    public function getuser($user_id) {
        $sql = "SELECT * FROM users WHERE id = :user_id LIMIT 1";
        $query = $this->db->prepare($sql);
        $parameters = array(':user_id' => $user_id);

        $query->execute($parameters);

        // fetch() is the PDO method that get exactly one result
        return $query->fetch();
    }

    /**
     * Get first attachment URL for listing
     */
    public function getFirstImageURLForListing($listing_id) {
        $sql = "SELECT file_path FROM media WHERE listing_id = :listing_id LIMIT 1";
        $query = $this->db->prepare($sql);
        $parameters = array(':listing_id' => $listing_id);
        $query->execute($parameters);
        $results = $query->fetchAll();

        if (count($results) > 0) {
          return URL . $results[0]->file_path;
        } else {
          return "http://placehold.it/300x200"; //placeholder
        }
    }

    /**
     * Get all attachments for listing
     */
    public function getImagesForListing($listing_id) {
        $sql = "SELECT file_path FROM media WHERE listing_id = :listing_id";
        $query = $this->db->prepare($sql);
        $parameters = array(':listing_id' => $listing_id);
        $query->execute($parameters);
        return $query->fetchAll();
    }
}
