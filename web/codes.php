<?php
include('config.php');
session_start();

$col = 0;
// get all titles
$all_titles = $_POST['selected_titles'];
sort($all_titles);
$_SESSION['prev_selected'] = $all_titles;
?>
<html>
  <head>
    <title>Generated QR Codes</title>
  </head>
  <body>
    <table width="100%" cellPadding="2" cellSpacing="5">
      <?php foreach($all_titles as $f): ?>
      <?php if($col == 0): ?>
      <tr valign="top">
      <?php endif ?>
        <?php $f_split = explode("|", trim($f)) ?>
        <td width="<?= 100/$TOTAL_COLS ?>%" align="center">
          <?php $hash = hash("sha256", $SECURITY_CODE . trim($f_split[0])); ?>
          <p><img src="qrcode.php?s=qr&t=<?= trim($f_split[0]) ?>&d=<?= $QR_BASE_URL ?>&c=<?= $hash ?>&y=<?= $f_split[1] ?>" width="<?= $QR_SIZE ?>px" height="<?= $QR_SIZE ?>px"/><br />
          <?= trim($f_split[0]) ?> (<?= $f_split[1] ?>)</p>
          <?php if($DEBUG_MODE): ?>
          <p><a href="<?= $QR_BASE_URL ?>?security=<?= $hash ?>&title=<?= trim($f_split[0]) ?>&year=<?= $f_split[1]?>">QR LINK</a></p>
          <?php endif ?>
        </td>
        <?php $col ++ ?>
      <?php if($col == $TOTAL_COLS): ?>
      </tr>
      <?php $col = 0; ?>
      <?php endif ?>
      <?php endforeach; ?>
    </table>
  </body>
</html>
