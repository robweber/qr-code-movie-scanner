<html>
  <head>
    <title>Generated QR Codes</title>
  </head>
  <body>
    <?php
      include('config.php');
      $col = 0;
      $max_col = 3;

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
          <?php $hash = hash("sha256", $SECURITY_CODE . trim($f)); ?>
          <img src="qrcode.php?s=qr&t=<?php echo trim($f) ?>&d=<?php echo $QR_BASE_URL ?>&c=<?php echo $hash ?>" />
          <h3><?php echo trim($f) ?></h3>
          <?php if($DEBUG_MODE): ?>
          <p><a href="<?php echo $QR_BASE_URL ?>?security=<?php echo $hash ?>&title=<?php echo trim($f) ?>"><?php echo $QR_BASE_URL ?>?security=<?php echo $hash ?>&title=<?php echo trim($f) ?></a></p>
          <?php endif ?>
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
