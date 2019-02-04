<?php


/**
 * Class Home
 *
 * Please note:
 * Don't use the same name for class and method, as this might trigger an (unintended) __construct of the class.
 * This is really weird behaviour, but documented here: http://php.net/manual/en/language.oop5.decon.php
 *
 */
class User extends Controller {

    public function login() {
        
        $errorMessage = array();

        if (isset($_COOKIE['user'])) {
            header("Location: " . URL);
        } else if (isset($_POST['email'])) {
            $email = $_POST['email'];
            $password = $_POST['password'];

            $login = $this->model->login($email, $password);
            if (count($login) == 1) {
                $this->initialize($email, $login[0]->id,$login[0]->is_student);
            } else {
                 array_push($errorMessage,"Login failed. Invalid email/password combination");
            }
        }

        require APP . 'view/_templates/header.php';
        require APP . 'view/user/login.php';
        require APP . 'view/_templates/footer.php';
    }

    public function logout() {
        unset($_SESSION['user']);
        unset($_COOKIE['user']);
        unset($_SESSION['is_student']);
        unset($_COOKIE['is_student']);
        unset($_SESSION['user_id']);
        unset($_COOKIE['user_id']);


        session_destroy();

        setcookie("user", "", time() - 3600);
        setcookie("user", "", time() - 3600, "/");
        setcookie("is_student", "", time() - 3600);
        setcookie("is_student", "", time() - 3600, "/");
        setcookie("user_id", "", time() - 3600);
        setcookie("user_id", "", time() - 3600, "/");

        header("Location: " . URL);
    }

    public function register() {
        
        $errorMessage = array();
        
        
        if (isset($_COOKIE['user'])) {
            header("Location: " . URL);
        } else if (isset($_POST['email'])) {
            $email = $_POST['email'];
            $password = $_POST['password'];
            $first_name = $_POST['first_name'];
            $last_name = $_POST['last_name'];


            if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                array_push($errorMessage, "Invalid email format");
            } else if (null != $this->model->check_email($email)) {
                array_push($errorMessage, "Email already registered");
            }
            if (!isset($_POST['student'])) {
                array_push($errorMessage, "Please select if you are a SFSU student or not");
            }
            if (strlen($password) < 4) {
                array_push($errorMessage, "Password must contain at least 4 characters");
            }
            if (count($errorMessage) == 0) {
                $student = (int) $_POST['student'];


              
                $user = $this->model->register($email, $password, $first_name, $last_name, $student);
                $this->initialize($email, $user->id, $student);
            }
        }


        require APP . 'view/_templates/header.php';
        require APP . 'view/user/register.php';
        require APP . 'view/_templates/footer.php';
    }
    

    private function initialize($email, $user_id, $is_student) {
        $_SESSION['user'] = $email;
        $_SESSION['user_id'] = $user_id;
        $_SESSION['is_student'] = $is_student;
        setcookie("user", $email, time() + (86400 * 30), "/");//86400 = 1 day
        setcookie("user_id", $email, time() + (86400 * 30), "/");//86400 = 1 day
        setcookie("is_student", $is_student, time() + (86400 * 30), "/");//86400 = 1 day
        if (isset($_SESSION['redirect'])) {
            header("Location: " . $_SESSION['redirect']);
            //need to set $_SESSION['redirect'] before redirecting to login page
        } else {
            header("Location: " . URL);
        }
        
    }

}
