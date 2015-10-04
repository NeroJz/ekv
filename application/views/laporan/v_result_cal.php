<table class="table">
<tr>
    <td>Bil</td>
<td>NAMA</td>
<td>MATRIC</td>
<td>SEMSTER</td>
<td>PNGKK</td>
</tr>
<?php
$bil=0;
foreach ($result as $value) {
    $bil++;
    ?>
  <tr>  
  <td><?= $bil ?></td>
<td><?= $value['nama']  ?></td>
<td><?= $value['no_matrix']  ?></td>
<td><?= $value['sem']  ?></td>
<td><?= $value['pngkk']  ?></td>
</tr>
  <?php  
}

?>
</table> 