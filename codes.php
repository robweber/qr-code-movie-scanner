<html>
  <head>
    <title>Generated QR Codes</title>
  </head>
  <body>
    <?php
      $col = 0;
      $max_col = 3;

      // load a list of images from the directory
      $files = array_diff(scandir("images/"), array('.', '..', 'empty'));
    ?>
    <table width="100%">
      <?php foreach($files as $f): ?>
      <?php if($col == 0): ?>
      <tr valign="center">
      <?php endif ?>
        <td width="33%" align="center">
          <img src="images/<?php echo $f ?>" width="50%" height="50%"/>
          <h3><?php echo substr($f, 0, strrpos($f, ".")) ?></h3>
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
