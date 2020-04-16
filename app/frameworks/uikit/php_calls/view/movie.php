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
    <style>
        section{
            margin: 50px 50px 0;
        }
    </style>
</head>
<body>
<main>
    <article class="uk-position-center">
        <section>
            <table class="uk-table uk-table-small uk-table-divider">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Name</th>
                        <th>Description</th>
                    </tr>
                </thead>
                <tbody id="movies-body">
                </tbody>
            </table>
        </section>
    </article>
</main>
<script>
    //FETCH

    const tbody = document.getElementById('movies-body'); // Get the list where we will place our authors
    const url = "http://127.0.0.1:8000/api/v8";

    fetch(url + "/movie", {
        method: "GET",
        headers: {
            'Content-Type': 'application/json',
            'Authorization': "Bearer " + sessionStorage.getItem("bearer_token")
        }
        //body: //je moet id meegeven.
    })
        .then((response) => response.json())
        .then(function(data) {
            const movie = data["message"];
            sessionStorage.setItem("bearer_token", data["access_token"]);

            return movie.map(function(movie) { // Map through the results and for each run the code below
                const tr = document.createElement('tr'), //  Create the elements we need
                    td = document.createElement('td'),
                    td2 = document.createElement('td'),
                    td3 = document.createElement('td');

                td.innerHTML = movie["id"];  // Add the source of the image to be the src of the img element
                td2.innerHTML = movie["name"]; // Make the HTML of our span to be the first and last name of our movie
                td3.innerHTML = movie["description"]; // Make the HTML of our span to be the first and last name of our movie

                tr.appendChild(td);
                tr.appendChild(td2);
                tr.appendChild(td3);
                tbody.appendChild(tr);
            })
        })
        .catch(function (error) {
            console.error(error);
            window.location.href = "http://localhost/frontend_framework/uikit_project/php_calls/view/login.php";
        })
</script>
</body>
</html>



