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
      $all_titles = $_POST['selected_titles'];
    ?>
    <table width="100%">
      <?php foreach($all_titles as $f): ?>
      <?php if($col == 0): ?>
      <tr valign="center">
      <?php endif ?>
        <?php $f_split = explode("|", trim($f)) ?>
        <td width="33%" align="center">
          <?php $hash = hash("sha256", $SECURITY_CODE . trim($f_split[0])); ?>
          <img src="qrcode.php?s=qr&t=<?php echo trim($f_split[0]) ?>&d=<?php echo $QR_BASE_URL ?>&c=<?php echo $hash ?>&y=<?php echo $f_spli[1] ?>" />
          <h3><?php echo trim($f_split[0]) ?> (<?php echo $f_split[1] ?>)</h3>
          <?php if($DEBUG_MODE): ?>
          <p><a href="<?php echo $QR_BASE_URL ?>?security=<?php echo $hash ?>&title=<?php echo trim($f_split[0]) ?>&year=<?php echo $f_split[1]?>">QR LINK</a></p>
          <?php endif ?>
        </td>
        <?php $col ++ ?>
      <?php if($col == 3): ?>
      </tr>
      <?php $col = 0; ?>
      <?php endif ?>
      <?php endforeach; ?>
    </table>
  </body>
</html>
