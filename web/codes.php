<html>
  <head>
    <title>Generated QR Codes</title>
  </head>
  <body>
    <?php
      include('config.php');
      $col = 0;
      $max_col = 3;
      $base_url = $QR_BASE_URL . "?title=";

      // get all titles from textarea
      $all_titles = explode("\n", $_POST['selected_titles']);
    ?>
    <table width="100%">
      <?php foreach($all_titles as $f): ?>
      <?php if($col == 0): ?>
      <tr valign="center">
      <?php endif ?>
      <?php if(!empty(trim($f))): ?>
        <td width="33%" align="center">
          <img src="qrcode.php?s=qr&t=<?php echo trim($f) ?>&d=<?php echo $base_url ?>" />
          <h3><?php echo trim($f) ?></h3>
        </td>
        <?php $col ++ ?>
      <?php endif; ?>
      <?php if($col == 3): ?>
      </tr>
      <?php $col = 0; ?>
      <?php endif ?>
      <?php endforeach; ?>
    </table>
  </body>
</html>
