<?php if (isset($_COOKIE['user']) && !isset($_SESSION['user'])) {
	$_SESSION['user'] = $_COOKIE['user'];
} 
if (isset($_COOKIE['user_id']) && !isset($_SESSION['user_id'])) {
  $_SESSION['user_id'] = $_COOKIE['user_id'];
}

if (isset($_COOKIE['is_student']) && !isset($_SESSION['is_student'])) {
  $_SESSION['is_student'] = $_COOKIE['is_student'];
}?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>CharBuff</title>
    <meta name="description" content="">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!-- JS -->
    <!-- please note: The JavaScript files are loaded in the footer to speed up page construction -->
    <!-- See more here: http://stackoverflow.com/q/2105327/1114320 -->

    <!-- CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <link href="<?php echo URL; ?>css/style.css" rel="stylesheet">
    <link href="<?php echo URL; ?>css/custom.css" rel="stylesheet">
    <link href="<?php echo URL; ?>css/listing.css" rel="stylesheet">
</head>
<body>
<nav id="top-disclaimer" class="navbar navbar-default">
  <div class="container-fluid">
    <p>SFSU/FAU/FULDA Software Engineering Project Fall 2016. For Demonstration Only.</p>
  </div><!-- /.container-fluid -->
</nav>
<div id="flash-message-danger" class="hidden alert alert-danger"></div>
<div id="flash-message" class="hidden alert alert-success">
  Successfully sent message to landlord. They will get back to you shortly.
</div>
<nav class="navbar navbar-default navbar-main">
  <div class="container-fluid">
    <!-- Brand and toggle get grouped for better mobile display -->
    <div class="navbar-header">
      <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1" aria-expanded="false">
        <span class="sr-only">Toggle navigation</span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
      </button>
      <a class="navbar-brand home-button" href="<?php echo URL . 'home/index/' ?>">CharBuff</a>
      <form id="searchbar" class="navbar-form navbar-left" action="<?php echo URL . 'home/index' ?>" method="get" role="search">
        <div class="input-group">
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
              $default_search = $_GET['search'];
            } else {
              $default_search = "";
            }
            if(isset($_GET['min_rent'])) {
              $min_rent_search = $_GET["min_rent"];
            }  else {
              $min_rent_search = "";
            }
            if(isset($_GET['max_rent'])) {
              $max_rent_search = $_GET["max_rent"];
            }  else {
              $max_rent_search = "";
            }
            if(isset($_GET['max_time_walking'])) {
              $max_time_walking_search = $_GET["max_time_walking"];
            }  else {
              $max_time_walking_search = "";
            }
            if(isset($_GET['max_time_driving'])) {
              $max_time_driving_search = $_GET["max_time_driving"];
            }  else {
              $max_time_driving_search = "";
            }
            if(isset($_GET['max_time_biking'])) {
              $max_time_biking_search = $_GET["max_time_biking"];
            }  else {
              $max_time_biking_search = "";
            }
          ?>
          <input type="text" name="search" class="form-control" placeholder="Search for listings: description, neighborhood, etc." value="<?php echo $default_search ?>">
          <input type="hidden" name="order" value="<?php echo htmlspecialchars($order, ENT_QUOTES); ?>" />
          <input type="hidden" name="sort" value="<?php echo htmlspecialchars($sort, ENT_QUOTES); ?>" />
          <input type="hidden" name="min_rent" value="<?php echo htmlspecialchars($min_rent_search, ENT_QUOTES); ?>" />
          <input type="hidden" name="max_rent" value="<?php echo htmlspecialchars($max_rent_search, ENT_QUOTES); ?>" />
          <input type="hidden" name="max_time_walking" value="<?php echo htmlspecialchars($max_time_walking_search, ENT_QUOTES); ?>" />
          <input type="hidden" name="max_time_driving" value="<?php echo htmlspecialchars($max_time_driving_search, ENT_QUOTES); ?>" />
          <input type="hidden" name="max_time_biking" value="<?php echo htmlspecialchars($max_time_biking_search, ENT_QUOTES); ?>" />
          <span class="input-group-btn">
            <button type="submit" class="btn btn-default">Search</button>
          </span>
        </div>
      </form>
    </div>

    <!-- Collect the nav links, forms, and other content for toggling -->
    <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
      <ul class="nav navbar-nav navbar-right">
        <?php preg_match('/(home\/index)|m0\/$/', $_SERVER['REQUEST_URI'], $browse); ?>
        <li><a <?php echo (0 < count($browse))?'class="active header-buttons"':'class="header-buttons"'; ?>href="<?php echo URL . 'home/index/' ?>">Browse listings</a></li>
        <?php preg_match('/listings\/index/', $_SERVER['REQUEST_URI'], $manage); ?>
        <li><a <?php echo (0 < count($manage))?'class="active header-buttons"':'class="header-buttons"'; ?> href="<?php echo URL . 'listings/index/' ?>">Manage listings</a></li>

	<?php if (isset($_SESSION['user'])) {
	?>
	      <li><a href ="#"><?php echo $_SESSION['user'];?></a></li>
        <li><a href="<?php echo URL; ?>user/logout">Logout</a></li>


	<?php
	}  else {
	?>
        <?php preg_match('/user\/register/', $_SERVER['REQUEST_URI'], $signup); ?>
        <li><a <?php echo (0 < count($signup))?'class="active header-buttons"':'class="header-buttons"'; ?> href="<?php echo URL; ?>user/register">Sign up</a></li>
        <?php preg_match('/user\/login/', $_SERVER['REQUEST_URI'], $login); ?>
        <li><a <?php echo (0 < count($login))?'class="active header-buttons"':'class="header-buttons"'; ?> href="<?php echo URL; ?>user/login">Login</a></li>
        <li></li>

	<?php
	}
	?>
      </ul>
    </div><!-- /.navbar-collapse -->
  </div><!-- /.container-fluid -->
</nav>
