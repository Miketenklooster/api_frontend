<?php

namespace view;

require('../controller/MovieController.php');
use controller\MovieController;

$movie = new MovieController();

if(isset($_SERVER["HTTP_AUTHORIZATION"]))
{
    $movies = $movie->getAll($_SERVER["HTTP_AUTHORIZATION"]);
} else {
    $movies =
    [
        [
            "id"=> 1,
            "name"=> "Movie Title 1",
            "description"=> "Movie first Description"
        ],
        [
            "id"=> 2,
            "name"=> "Movie Title 2",
            "description"=> "Movie Description number 2"
        ],
        [
            "id"=> 3,
            "name"=> "This name",
            "description"=> "This is the third description"
        ],
        [
            "id" => 4,
            "name"=> "This is the name",
            "description" => "This is the fourth description"
        ]
    ];
}

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
                <tbody>
                <?php foreach ($movies as $movie_row): ?>
                    <tr>
                        <td><?= $movie_row["id"]; ?></td>
                        <td><?= $movie_row["name"]; ?></td>
                        <td><?= $movie_row["description"];?></td>
                    </tr>
                <?php endforeach; ?>
                </tbody>
            </table>
        </section>
    </article>
</main>
<script>

</script>
</body>
</html>



