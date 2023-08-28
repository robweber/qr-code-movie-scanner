<?php
  require('kodi.php');

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
    $('#selected_titles').val($('#selected_titles').val() + selectedT + "\n");
  }
  function removeTitle(){
    var selectedT = $('#all_titles').val();
    var currentText = $('#selected_titles').val();

    $('#selected_titles').val(currentText.replace(selectedT + "\n",""));
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
    <form action="codes.php" method="post" enctype="application/x-www-form-urlencoded">
      <div align="center">
        <?php $movies = $kodi->getMovies(); ?>
        <select id="all_titles" name="all_titles" size="15">
          <?php foreach($movies as $m): ?>
          <option value="<?php echo $m['title'] ?>"><?php echo $m['title'] ?></option>
        <?php endforeach ?>
        </select>
      </div>
      <div align="center">
        <button id="add_title" type="button" onClick="addTitle()">Add</button>
        <button id="remove_title" type="button" onClick="removeTitle()">Remove</button>
      </div>
      <div align="center">
        <textarea id="selected_titles" name="selected_titles" rows="15" cols="40" readonly></textarea>
      </div>
      <div align="center">
        <button type="submit">Generate</button>
      </div>
    </form>
  </body>
</html>
