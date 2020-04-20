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

            <!-- This is the table -->
            <table class="uk-table uk-table-small uk-table-divider">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Name</th>
                        <th>Description</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody id="movies-body">
                </tbody>
            </table>

            <!-- This is the modal -->
            <div id="modal" uk-modal>
                <div class="uk-modal-dialog uk-modal-body">
                    <h2 class="uk-modal-title">Edit</h2>
                    <form id="modal-form">
                        <input id="name" class="uk-input" type="text">
                        <textarea id="description" class="uk-textarea uk-margin-top" rows="5"></textarea>
                        <p class="uk-text-right">
                            <button class="uk-button uk-button-default uk-modal-close" type="submit">Cancel</button>
                            <button class="uk-button uk-button-primary" type="submit">Save</button>
                        </p>
                    </form>
                </div>
            </div>

            <!-- This is the del modal -->
            <div id="modal-del" uk-modal>
                <div class="uk-modal-dialog uk-modal-body">
                    <h2 class="uk-modal-title">Delete</h2>
                    <form id="modal-del-form">
                            <button class="uk-button uk-button-large uk-button-default uk-modal-close" type="submit">Cancel</button>
                            <button class="uk-button uk-button-large uk-button-danger" type="submit">Delete</button>
                    </form>
                </div>
            </div>

        </section>
    </article>
</main>
<script>
    //FETCH

    const tbody = document.getElementById('movies-body'); // Get the list where we will place our authors
    const url = "http://127.0.0.1:8000/api/v3";

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
            const movies = data["message"];
            sessionStorage.setItem("bearer_token", data["access_token"]);

            return movies.map(function(movies) { // Map through the results and for each run the code below
                const tr = document.createElement('tr'), //  Create the elements we need
                    td = document.createElement('td'),
                    td2 = document.createElement('td'),
                    td3 = document.createElement('td'),
                    td4 = document.createElement('td'),
                    a = document.createElement('a'),
                    a2 = document.createElement('a');

                let a_icon  = document.createAttribute('uk-icon'),
                    a_toggle  = document.createAttribute('uk-toggle'),
                    a_class  = document.createAttribute('class'),
                    a_id  = document.createAttribute('id'),
                    a_icon2 = document.createAttribute('uk-icon'),
                    a_toggle2  = document.createAttribute('uk-toggle'),
                    a_class2  = document.createAttribute('class'),
                    a_id2  = document.createAttribute('id');

                td.innerHTML = movies["id"];
                td2.innerHTML = movies["name"];
                td3.innerHTML = movies["description"];
                a_icon.value ='pencil';
                a_toggle.value = "target: #modal";
                a_class.value = "uk-margin-right uk-text-primary pencil";
                a_id.value = movies["id"];
                a_icon2.value ='trash';
                a_toggle2.value = "target: #modal-del";
                a_class2.value = "uk-text-danger trash";
                a_id2.value = movies["id"];

                a.setAttributeNode(a_icon);
                a.setAttributeNode(a_toggle);
                a.setAttributeNode(a_class);
                a.setAttributeNode(a_id);
                a2.setAttributeNode(a_icon2);
                a2.setAttributeNode(a_toggle2);
                a2.setAttributeNode(a_class2);
                a2.setAttributeNode(a_id2);

                tr.appendChild(td);
                tr.appendChild(td2);
                tr.appendChild(td3);
                td4.appendChild(a);
                td4.appendChild(a2);
                tr.appendChild(td4);
                tbody.appendChild(tr);
            })
        })
        .then(function (data) {
            let edit = document.querySelectorAll('.pencil');

            edit.forEach(function (edit) {
                edit.addEventListener('click', function (e) {

                    let id = edit.getAttribute('id');

                    fetch(url + "/movie/" + id, {
                        method: "GET",
                        headers: {
                            'Content-Type': 'application/json',
                            'Authorization': "Bearer " + sessionStorage.getItem("bearer_token"),
                        }
                    })
                    .then((response) => response.json())
                    .then(function (data) {
                        const movie = data["message"];
                        sessionStorage.setItem("bearer_token", data["access_token"]);

                        document.getElementById('name').value = movie["name"];
                        document.getElementById('description').value = movie['description'];
                        document.getElementById('modal-form').addEventListener("submit", function (e) {

                            e.preventDefault();

                            fetch(url + "/movie/" + id, {
                                method: "PUT",
                                headers: {
                                    'Content-Type': 'application/json',
                                    'Authorization': "Bearer " + sessionStorage.getItem("bearer_token"),
                                },
                                body: JSON.stringify({
                                    name: document.getElementById('name').value,
                                    description: document.getElementById('description').value
                                })
                            })
                            .then((response) => response.json())
                            .then(function (data) {
                                sessionStorage.setItem("bearer_token", data["access_token"]);
                                window.location.href = "http://localhost/frontend_framework/uikit_project/php_calls/view/movie.php";
                            })
                            .catch(function (error) {
                                console.error(error);
                                window.location.href = "http://localhost/frontend_framework/uikit_project/php_calls/view/login.php";
                            });
                        });
                    })
                    .catch(function (error) {
                        console.error(error);
                        window.location.href = "http://localhost/frontend_framework/uikit_project/php_calls/view/login.php";
                    });
                });
            });

            let del = document.querySelectorAll('.trash');

            del.forEach(function (del) {
                del.addEventListener('click', function (e) {
                    let id = del.getAttribute('id');

                    document.getElementById('modal-del-form').addEventListener("submit", function (e) {
                        e.preventDefault();

                        fetch(url + "/movie/" + id, {
                            method: "Delete",
                            headers: {
                                'Content-Type': 'application/json',
                                'Authorization': "Bearer " + sessionStorage.getItem("bearer_token"),
                            },
                        })
                        .then((response) => response.json())
                        .then(function (data) {
                            sessionStorage.setItem("bearer_token", data["access_token"]);
                            window.location.href = "http://localhost/frontend_framework/uikit_project/php_calls/view/movie.php";
                        })
                        .catch(function (error) {
                            console.error(error);
                            window.location.href = "http://localhost/frontend_framework/uikit_project/php_calls/view/login.php";
                        });
                    });
                })
            });
        })
        .catch(function (error) {
            console.error(error);
            window.location.href = "http://localhost/frontend_framework/uikit_project/php_calls/view/login.php";
        });



</script>
</body>
</html>



