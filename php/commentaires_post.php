<!doctype html>
<html class="no-js" lang="fr">

<head>
  <meta charset="utf-8">
  <meta http-equiv="x-ua-compatible" content="ie=edge">
  <title>Commentaires</title>
  <meta name="description" content="">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

  <link rel="manifest" href="site.webmanifest">
  <link rel="apple-touch-icon" href="icon.png">
  <!-- Place favicon.ico in the root directory -->

  <link rel="stylesheet" href="css/normalize.css">
  <link rel="stylesheet" href="css/main.css">
</head>

<body>
  <!--[if lte IE 9]-->


  <?php

  // Connection to the database
  include 'co_bdd.php';

  // Check that the button has been clicked to send a comment
  if (isset($_POST['post_comment'])) {

    $pseudo = htmlspecialchars($_POST['pseudo']);
    $commentaire = htmlspecialchars($_POST['commentaire']);

    if ( isset($pseudo) && !empty($pseudo) ) {
      if ( isset($commentaire) && !empty($commentaire) ) {

        // Insert the new comment into the table "commentaires" in the database
        $req = $bdd->prepare(' INSERT INTO commentaires (id_billets, auteur, commentaire, date_commentaire)
        VALUES (:id_billets, :auteur, :commentaire, NOW()) ');

        $req->execute(array(
          'id_billets' => $_POST['id_billet'],
          'auteur' => $pseudo,
          'commentaire' => $commentaire
        ));



        // This page is not display -> we stay on the comments page
        // Get the id (of the message) to transmit it in the URL
        $req2 = $bdd->query('SELECT * FROM billets ORDER BY id DESC LIMIT 0, 5');
        $rep = $req2->fetchAll();

        foreach ($rep AS $value) {

        header('Location: commentaires.php?billet=' . $value['id'] );

        $req2->closeCursor();
        }
        
      } else {
        ?>
        <p>Il faut rentrer un commentaire !!</p>
        <?php
      }
    } else {
      ?>
      <p>Il faut rentrer un pseudo !!</p>
      <?php
    }
  }


   ?>




  <script src="js/vendor/modernizr-3.6.0.min.js"></script>
  <script src="https://code.jquery.com/jquery-3.3.1.min.js" integrity="sha256-FgpCb/KJQlLNfOu91ta32o/NMZxltwRo8QtmkMRdAu8=" crossorigin="anonymous"></script>
  <script>window.jQuery || document.write('<script src="js/vendor/jquery-3.3.1.min.js"><\/script>')</script>
  <script src="js/plugins.js"></script>
  <script src="js/main.js"></script>

  <!-- Google Analytics: change UA-XXXXX-Y to be your site's ID. -->
  <script>
    window.ga = function () { ga.q.push(arguments) }; ga.q = []; ga.l = +new Date;
    ga('create', 'UA-XXXXX-Y', 'auto'); ga('send', 'pageview')
  </script>
  <script src="https://www.google-analytics.com/analytics.js" async defer></script>
</body>

</html>
