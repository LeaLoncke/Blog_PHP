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

  // Get the id of the message that was clicked for display this message
  $req = $bdd->prepare('SELECT * FROM billets WHERE id = :id ');

  $req->execute(array(
    'id' => $_GET['billet']
));

  $rep = $req->fetch();

  ?>

  <div class="billets">
    <h2><?php echo $rep['titre'] . ', le ' . $rep['date_creation'];?></h2>
    <p><?php echo $rep['contenu']; ?></p>
  </div>


  <?php

  $req->closeCursor();


  // Get the id of the message that was clicked for display his comments
  $req2 = $bdd->prepare('SELECT * FROM commentaires WHERE id_billets = :id_billets');

  $req2->execute(array(
    'id_billets' => $_GET['billet']
  ));

  while ($val = $req2->fetch()) {

    ?>

    <p><?php echo $val['auteur'] . ', le ' . $val['date_commentaire']; ?></p>
    <p><?php echo $val['commentaire']; ?></p>

    <?php

  }

   ?>

   <form action="commentaires_post.php" method="post">
     <input type="text" name="pseudo" value="" placeholder="Pseudo" required>
     <input type="text" name="commentaire" value="" placeholder="Commentaire" required>
     <input type="hidden" name="id_billet" value="<?php echo $_GET['billet']; ?>">
     <input type="submit" name="post_comment" value="Poster un commentaire" >
   </form>

   <a href="../index.php">Retour à l'accueil du blog</a>

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
