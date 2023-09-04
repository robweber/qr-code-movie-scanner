<?php
  include('config.php');
  require('kodi.php');

  // by default the first device is always selected
  $device_name = array_key_first($KODI_ADDRESS);
  if($_SERVER['REQUEST_METHOD'] == "POST")
  {
    $device_name = $_POST['select_player'];
  }

  $device_ip = $KODI_ADDRESS[$device_name];
?>
<html>
  <head>
    <title>Scanner</title>
  </head>
  <body align="center">
    <?php if(hash('sha256', $SECURITY_CODE . $_GET['title']) == $_GET['security']): ?>
    <?php if(count($KODI_ADDRESS) > 1 && $_SERVER['REQUEST_METHOD'] != "POST"): ?>
      <form method="post" enctype="application/x-www-form-urlencoded">
        <h3>Select Player: <select name="select_player">
          <?php foreach(array_keys($KODI_ADDRESS) as $key): ?>
          <option name="<?= $key ?>"><?= $key ?></option>
          <?php endforeach ?>
        </select> </h3>
        <button type="submit">Submit</button>
      </form>
    <?php else: ?>
    <?php
      $kodi = new KodiComm($device_ip, $DEBUG_MODE);

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
        <h2>Playing <?= htmlspecialchars($_GET["title"]) ?> (<?= $_GET['year'] ?>) on <?= $device_name ?></h2>
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
  <?php endif; ?>
  <?php endif ?>
  </body>
</html>
