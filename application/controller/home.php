<?php


/**
 * Class Home
 *
 * Please note:
 * Don't use the same name for class and method, as this might trigger an (unintended) __construct of the class.
 * This is really weird behaviour, but documented here: http://php.net/manual/en/language.oop5.decon.php
 *
 */
class Home extends Controller
{
    /**
     * PAGE: index
     * This method handles what happens when you move to http://yourproject/home/index (which is the default page btw)
     */
    public function index()
    {
      $sort = "ORDER BY CREATED_AT DESC";
      if(isset($_GET['sort']) && !empty($_GET['sort'])) {
        $sort = "ORDER BY " . $_GET['sort'] . " " . $_GET['order'] ;
      }
      if(isset($_GET["min_rent"])) {
        $min_rent = $_GET["min_rent"];
      } else {
        $min_rent = "";
      }
      if(isset($_GET["max_rent"])) {
        $max_rent = $_GET["max_rent"];
      } else {
        $max_rent = "";
      }
      if(isset($_GET["max_time_walking"])) {
        $max_time_walking = $_GET["max_time_walking"];
      } else {
        $max_time_walking = "";
      }
      if(isset($_GET["max_time_driving"])) {
        $max_time_driving = $_GET["max_time_driving"];
      } else {
        $max_time_driving = "";
      }
      if(isset($_GET["max_time_biking"])) {
        $max_time_biking = $_GET["max_time_biking"];
      } else {
        $max_time_biking = "";
      }
       if(isset($_GET['search'])) {
         $listings = $this->model->getListings($_GET["search"], $sort, $min_rent, $max_rent, $max_time_walking, $max_time_driving, $max_time_biking);
       } else {
         $listings = $this->model->getListings("", $sort, $min_rent, $max_rent, $max_time_walking, $max_time_driving, $max_time_biking);
       }
       if(isset($_SESSION['user_id'])) {
         $listingIdsWithUserMessages = $this->model->getListingIdsWithUserMessages($_SESSION["user_id"]);
       } else {
         $listingIdsWithUserMessages = [];
       }
        // load views
        require APP . 'view/_templates/header.php';
        require APP . 'view/home/index.php';
        require APP . 'view/_templates/footer.php';
    }

    public function login()
    {


	if (isset($_COOKIE['user'])) {
		header("Location: ".URL);
	} else if(isset($_POST['email'])) {
        $email = $_POST['email'];
	$password = $_POST['password'];

	$login = $this->model->login($email, $password);
	if (count($login) == 1) {
	$_SESSION['user'] = $email;
	setcookie("user", $email, time() + (86400 * 30), "/");
	header("Location: ".URL);
	//header above should check session for page before login then redirect accordingly
	} else {
	//error message
	}

       }

        require APP . 'view/_templates/header.php';
        require APP . 'view/home/login.php';
        require APP . 'view/_templates/footer.php';
    }

    public function logout()
    {
	unset($_SESSION['user']);
	unset($_COOKIE['user']);


	session_destroy();

	setcookie("user", "", time() - 3600);
	setcookie("user", "", time() - 3600,"/");

        require APP . 'view/_templates/header.php';
        require APP . 'view/home/logout.php';
        require APP . 'view/_templates/footer.php';

    }

    public function signup()
    {
	if (isset($_COOKIE['user'])) {
		header("Location: ".URL);
	} else 	if(isset($_POST['email'])) {
	        $email = $_POST['email'];
		$password = $_POST['password'];
		$first_name = $_POST['first_name'];
		$last_name = $_POST['last_name'];



		if (!filter_var($email, FILTER_VALIDATE_EMAIL))
		{
			$errorMessage = "Invalid email format";
		}
		 else if (null != $this->model->check_username($email))
		{

			$errorMessage = "Email already registered";
		}
		else if (!isset($_POST['student']))  {
			$errorMessage = "Please select if you are a SFSU student or not";
		}
		else if (strlen($password) < 4)  {
			$errorMessage = "Password must contain at least 4 characters";
		}
		 else
		{
			$student = (int)$_POST['student'];
			$this->model->register($email,$password,$first_name,$last_name,$student);
			$_SESSION['user'] = $email;
			setcookie("user", $email, time() + (86400 * 30), "/");
			header("Location: ".URL);
			//redirect, fix
		}


	}


        require APP . 'view/_templates/header.php';
        require APP . 'view/home/register.php';
        require APP . 'view/_templates/footer.php';
    }

   public function about(){
	   require APP . 'view/_templates/header.php';
	   require APP . 'view/home/about.php';
	   require APP . 'view/_templates/footer.php';
   }
   public function privacy_policy(){
	   require APP . 'view/_templates/header.php';
	   require APP . 'view/home/privacy_policy.php';
	   require APP . 'view/_templates/footer.php';
   }



    /**
     * PAGE: exampletwo
     * This method handles what happens when you move to http://yourproject/home/exampletwo
     * The camelCase writing is just for better readability. The method name is case-insensitive.
     */
    public function exampleTwo()
    {
        // load views
        require APP . 'view/_templates/header.php';
        require APP . 'view/home/example_two.php';
        require APP . 'view/_templates/footer.php';
    }

    public function jharriot(){
	require APP . 'view/_templates/header.php';
	require APP . 'view/home/jharriot.php';
	require APP . 'view/_templates/footer.php';
    }

    public function rajat()
    {
	require APP . 'view/_templates/header.php';
        require APP . 'view/home/rajat.php';
        require APP . 'view/_templates/footer.php';
    }

    public function boliveir()
   {
     // load views
        require APP . 'view/_templates/header.php';
        require APP . 'view/home/boliveir.php';
        require APP . 'view/_templates/footer.php';
   }

   public function shivamd()
   {
        // load views
        require APP . 'view/_templates/header.php';
        require APP . 'view/home/shivamd.php';
        require APP . 'view/_templates/footer.php';
   }

   public function listing(){
	   require APP . 'view/_templates/header.php';
	   require APP . 'view/home/listing.php';
	   require APP . 'view/_templates/footer.php';
   }

}
