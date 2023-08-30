<?php
  include('config.php');
  require('kodi.php');
?>
<html>
  <head>
    <title>Scanner</title>
  </head>
  <body align="center">
    <?php if(hash('sha256', $SECURITY_CODE . $_GET['title']) == $_GET['security']): ?>
    <?php
      $kodi = new KodiComm($DEBUG_MODE);

      $result = $kodi->callMethod('VideoLibrary.GetMovies', array('properties'=>array('title', 'runtime', "file", "resume"),
                                  'filter'=>array('and'=>array(array('operator'=>'is','field'=>'title','value'=>$_GET['title']),
                                                               array('operator'=>'is','field'=>'year','value'=>$_GET['year'])))));

      if($result['result']['limits']['total'] == 1)
      {

        if(!$kodi->isPlaying() || $OVERRIDE_PLAYING)
        {
          if(!$DEBUG_MODE)
          {
            $kodi->callMethod('Player.Open', array('item'=>array('file'=>$result['result']['movies'][0]['file'])));
          }

        ?>
        <h2>Playing <?= htmlspecialchars($_GET["title"]) ?> (<?= $_GET['year'] ?>)</h2>
        <?php
        }
        else
        {
        ?>
        <h2>Cannot play <?= htmlspecialchars($_GET["title"]) ?> (<?= $_GET['year'] ?>), playback in progress</h2>
        <?php
        }
      }
      else
      {
    ?>
    <h2><?= htmlspecialchars($_GET["title"]) ?> (<?= $_GET['year'] ?>) cannot be found</h2>
    <?php
      }
    ?>
  <?php endif ?>
  </body>
</html>
