<?php
  require('kodi.php');
  session_start();

  $kodi = new KodiComm(false);
?>
<html>
  <head>
    <title>Generate QR Codes</title>
  </head>
  <script src="https://code.jquery.com/jquery-3.7.1.min.js" integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>
  <script type="text/javascript">
  function addTitle(){
    var selectedT = $('#all_titles').val();
    var splitT = selectedT.split('|');
    $('#selected_titles').append(new Option(splitT[0] + " - " + splitT[1],selectedT));
  }
  function removeTitle(){
    $('#selected_titles option:selected').remove();
  }
  function selectAll(){
    $('#selected_titles option').each(function () {
            $(this).attr('selected', true);
        });
  }
  </script>
  <style type="text/css">
  div {
    margin-bottom: 10px;
  }
  select option {
    width: 300px;
  }
  </style>
  <body>
    <p align="center">Select movie titles from the list below and click Generate to create QR codes for each.</p>
    <form action="codes.php" method="post" enctype="application/x-www-form-urlencoded" onSubmit="selectAll()">
      <div align="center">
        <?php $movies = $kodi->getMovies(); ?>
        <select id="all_titles" name="all_titles" size="15">
          <?php foreach($movies as $m): ?>
          <option value="<?= $m['title'] ?>|<?= $m['year'] ?>"><?= $m['title'] ?> - <?= $m['year'] ?></option>
        <?php endforeach ?>
        </select>
      </div>
      <div align="center">
        <button id="add_title" type="button" onClick="addTitle()">Add</button>
        <button id="remove_title" type="button" onClick="removeTitle()">Remove</button>
      </div>
      <div align="center">
        <select id="selected_titles" name="selected_titles[]" size="15" multiple="multiple">
          <?php foreach($_SESSION['prev_selected'] as $f): ?>
          <?php $f_split = explode("|", trim($f)) ?>
          <option value="<?= trim($f) ?>"><?= $f_split[0] ?> - <?= $f_split[1] ?></option>
          <?php endforeach ?>
        </select>
      </div>
      <div align="center">
        <button type="submit">Generate</button>
      </div>
    </form>
  </body>
</html>
