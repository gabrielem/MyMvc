

<?php
if($_SESSION['admin_level']=="1"){$wAm="";}else{$wAm=" WHERE admin='0' ";} 
$db_SAVE=$db;
$m=_loop($TAB_admin_menu,$wAm," ORDER BY posizione, nome ");

?>


<div id="menu">
<ul>
<?php for($i=0;$i<count($m);$i++) { ?>
<li><a href="<?php echo urlMenuAdmin($m[$i]); ?>"><?php echo $m[$i]['nome']; ?></a>
	<?php $mm=_loop($TAB_admin_menu_items," WHERE id_menu='".$m[$i]['id']."' "," ORDER BY nome "); ?>
	<?php if($mm){ ?>
	<ul>
		<?php for($ii=0;$ii<count($mm);$ii++){ ?>
		<li><a href="<?php echo urlMenuAdmin($mm[$ii]); ?>"><?php echo $mm[$ii]['nome']; ?></a>
		<?php } ?>
	</ul>
	<?php } ?>
</li>
<?php } ?>
</ul>
<div style="clear:both;"></div>
</div>
<div style="clear:both;"></div>
<?php
$db=$db_SAVE;

?>