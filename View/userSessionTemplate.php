<!DOCTYPE html>
<html lang="fr">
  <head>
    <meta charset="utf-8">
    <title>Matcha</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css">
    <link rel="stylesheet" href="./Public/css/jquery-ui.css">
    <link rel="stylesheet" href="Public/css/jquery.Jcrop.min.css" type="text/css" />
    <link rel="stylesheet" href="./Public/css/userSession.css?v=3">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <style>
      @media screen and (max-width: 450px) { footer {margin-top: 0.5rem;} }
    </style>
  </head>
  <body>
    <div class="page_container">
      <div class="content_wrap <?php echo $_SESSION['location_status'];?>">
        <?= $this->page->nav(); ?>
        <?= $this->page->content(); ?>
      </div>
      <footer><p>© 2019 Matcha, All right reserved.</p></footer>
    </div>
  </body>
  <script src="https://code.jquery.com/jquery-3.3.1.min.js" ></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
  <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
  <script src="Public/js/jquery.Jcrop.min.js"></script>
  <script src="./Public/js/jquery-ui.js"></script>
  <script src="./Public/js/userSession.js?v=2" type="text/javascript"></script>
</html>
