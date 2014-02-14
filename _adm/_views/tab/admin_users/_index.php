<?php //include(addView('_adm/_views/menu')); ?>


<table border="1"> 
<?php for($i=0;$i<count($dati);$i++){ ?>
<tr>
<td><?php echo $dati[$i]['id'] ?>)</td>
<td><?php echo $dati[$i]['nome'] ?></td>
<td><?php echo $dati[$i]['cognome'] ?></td>
<td><?php echo $dati[$i]['email'] ?></td>
</tr>
<?php } ?>
</table>

