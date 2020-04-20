<?php
namespace view;
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
<!--                    <div id="alert" class="uk-alert-danger uk-text-danger" uk-alert>-->
<!--                        <a class="uk-alert-close uk-text-danger" uk-close></a>-->
<!--                        <p class="uk-text-center">TEST ALERT</p>-->
<!--                    </div>-->
                <form method="post" id="login-form">
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
       //Fetch
       const url = "http://127.0.0.1:8000/api/v3";

       document.getElementById('login-form').addEventListener("submit", function (e) {
           e.preventDefault();

           fetch(url + "/login", {
               method: "POST",
               headers: {
                   'Content-Type': 'application/json',
                   'Authorization': "Basic " + btoa(document.getElementById('email').value + ":" + document.getElementById('password').value)
               },
               mode: "cors",
           })
               .then((response) => response.json())
               .then(function (json) {
                   sessionStorage.setItem("bearer_token", json["access_token"]);
                   window.location.href = "http://localhost/frontend_framework/uikit_project/php_calls/view/movie.php";
               })
               .catch(function (error) {
                   console.error(error);
               })
       })

    </script>
</body>
</html>



