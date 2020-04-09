<?php

namespace view;
//
//require('../controller/LoginController.php');
//use controller\LoginController;
//
//$api_login = new LoginController();
//
///**
// * check if the data is set and correct
// */
//if(isset($_SERVER['HTTP_AUTHORIZATION']) && 0 === stripos($_SERVER["HTTP_AUTHORIZATION"], 'bearer '))
//{
//    $credentials = stripos($_SERVER["HTTP_AUTHORIZATION"], 'Bearer ');
//    if($api_login->Login("GET", 'Bearer ', $credentials))
//    {
//        header('Location http://localhost/frontend_framework/uikit_project/php_calls/view/movie.php');
//    }
//}
//elseif(isset($_POST["email"]) || isset($_POST["password"])){
//
//    /**
//     * string var $email    stores the email of the user
//     */
//    $email = $_POST["email"];
//
//    /**
//     * string var $password    stores the password of the user
//     */
//    $password = $_POST["password"];
//
//    if(empty($email) || empty($password)) {
//        $error = "All fields have to be filled in!!";
//    }else{
//        $credentials = base64_encode($email.':'.$password);
//        var_dump($credentials);
//        var_dump($api_login->Login("POST",'Basic ', $credentials));
//        $_SERVER['HTTP_AUTHORIZATION'] = $api_login;
//
//        if(isset($_SERVER['HTTP_AUTHORIZATION']))
//        {
//            if($api_login->Login("POST", 'Basic ', $credentials))
//            {
//                header('Location http://localhost/frontend_framework/uikit_project/php_calls/view/movie.php');
//            }
//        } else {
//            $error = "Wrong credentials";
//        }
//    }
//}

?>
<!DOCTYPE html>
<html>
<head>
    <title>Title</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="../dist/css/uikit.min.css" />
    <script src="../dist/js/uikit.min.js"></script>
    <script src="../dist/js/uikit-icons.min.js"></script>
</head>
<body>
    <main uk-height-viewport class="uk-height-large uk-background-cover uk-light uk-flex " style="background-image: url(../dist/img/background_1.jpg);">
        <article class="uk-position-center">
            <section>
                    <div id="alert" class="uk-alert-danger uk-text-danger" uk-alert>
                        <a class="uk-alert-close uk-text-danger" uk-close></a>
                        <p class="uk-text-center">TEST ALERT</p>
                    </div>
                <form method="post">
                    <div class="uk-margin">
                        <div class="uk-inline">
                            <span class="uk-form-icon uk-form-icon-flip" uk-icon="icon: user"></span>
                            <input class="uk-input uk-form-large" id="email" name="email" type="email" placeholder="E-mail" required>
                        </div>
                    </div>
                    <div class="uk-margin">
                        <div class="uk-inline">
                            <span class="uk-form-icon uk-form-icon-flip" uk-icon="icon: lock"></span>
                            <input class="uk-input uk-form-large" id="password" name="password" type="password" placeholder="Password" required>
                        </div>
                    </div>
                    <div class="uk-margin">
                        <button class="uk-button uk-button-default uk-button-large uk-width-1-1">Login</button>
                    </div>
                </form>
            </section>
        </article>
    </main>
    <script>
        // FETCH
    
    </script>
</body>
</html>



