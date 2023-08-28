<?php
  require('kodi.php');
?>
<html>
  <head>
    <title>Scanner</title>
  </head>
  <body>
    <?php
      $kodi = new KodiComm(true);

      $result = $kodi->callMethod('VideoLibrary.GetMovies', array('properties'=>array('title', 'runtime', "file"), 'filter'=>array('operator'=>'is','field'=>'title','value'=>$_GET['title'])));

      if($result['result']['limits']['total'] == 1)
      {
        //$kodi->callMethod('Player.Open', array('item'=>array('file'=>$result['result']['movies'][0]['file'])));
      ?>
      <h2>Playing <?php echo htmlspecialchars($_GET["title"]) ?></h2>
      <?php
      }
      else
      {
    ?>
    <h2><?php echo htmlspecialchars($_GET["title"]) ?> cannot be found</h2>
    <?php
      }
    ?>
  </body>
</html>
<?php



?>
