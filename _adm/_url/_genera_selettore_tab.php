<?php $elencoTAB=elencoTAB(); ?>
<?php $generaForm=new generaForm(); ?>


<table>
<tr>
<td valign="top">
 <table width="500">
 <?php for($i=0;$i<count($elencoTAB);$i++){ ?>
 
 <tr>
 <td colspan="5">
 <div style="margin-top:15px;font-size:11px;">
 TAB: <b><?php echo $elencoTAB[$i]; ?></b> </div></td></tr>
 
 <tr bgcolor="#ffffcc">
 <?php echo _formStart("generate"); ?>
 <?php echo $generaForm->_hidden("tab",$elencoTAB[$i]); ?>
 
 <?php $SAVE_index="";@include($rootAssoluta.$dirADMIN."_views/tab/".$elencoTAB[$i]."/_index.dati"); ?>
 <td valign="top"><div<?php if(checkAzione($elencoTAB[$i],"index")){echo " style=\"background:#FFDCDC;\" title=\"".$lang['MSG_Esistente']."\"";} ?>>
 <?php echo $generaForm->_checkBox("INDEX","1",$elencoTAB[$i]."_INDEX"); ?><label for="<?php echo $elencoTAB[$i]; ?>_INDEX">index</label></div>
	<p style="font-size:10px;"><?php versioniList('index',$SAVE_index,$elencoTAB[$i]);?></p>
 </td>
 
 <?php $SAVE_new="";@include($rootAssoluta.$dirADMIN."_views/tab/".$elencoTAB[$i]."/_new.dati"); ?>
 <td valign="top"><div<?php if(checkAzione($elencoTAB[$i],"new")){echo " style=\"background:#FFDCDC;\" title=\"".$lang['MSG_Esistente']."\"";} ?>>
 <?php echo $generaForm->_checkBox("NEW","1",$elencoTAB[$i]."_NEW"); ?><label for="<?php echo $elencoTAB[$i]; ?>_NEW">NEW</label></div>
	<p style="font-size:10px;"><?php versioniList('new',$SAVE_new,$elencoTAB[$i]);?></p>
 </td>
 
 <?php $SAVE_upd="";@include($rootAssoluta.$dirADMIN."_views/tab/".$elencoTAB[$i]."/_upd.dati"); ?>
 <td valign="top"><div<?php if(checkAzione($elencoTAB[$i],"upd")){echo " style=\"background:#FFDCDC;\" title=\"".$lang['MSG_Esistente']."\"";} ?>>
 <?php echo $generaForm->_checkBox("UPD","1",$elencoTAB[$i]."_UPD"); ?><label for="<?php echo $elencoTAB[$i]; ?>_UPD">UPD</label></div>
	<p style="font-size:10px;"><?php versioniList('upd',$SAVE_upd,$elencoTAB[$i]);?></p>
 </td>
 
 <td valign="top">
	
	<?php $arrayMODE=array('NEW','DEL'); ?>
 <?php echo $htmlHelper->_select($arrayMODE,"MODE"); ?>
 <?php echo _formSubmit($lang['tasto_invia']); ?>
 
 </td>
 </form>
 </tr>
 <tr><td colspan="5" style="background:#efefef;font-size:9px;">&nbsp;</td></tr>
 




 <?php } ?>
 </table>
</td>
<td valign="top" width="100%">

	<?php if(!empty($_POST)){ ?>
		<?php if( isset($_POST['INDEX']) || isset($_POST['NEW']) || isset($_POST['UPD']) ){ ?>
	<?php echo _formStart("write"); ?>
	<?php foreach($_POST as $k=>$v){echo $generaForm->_hidden($k,$v)."\n";} ?>

		<?php if($_POST['MODE']=="DEL"){ ?>
	<div style="margin:0 auto;padding:21px;background:#FFDCDC;text-align:center;width:280px;font-size:12px;">
		<?php echo $lang['QST_CancViewsPerTab']; ?> <b><?php echo $_POST['tab']; ?></b>?<br/>
		<?php echo _formSubmit($lang['ANS_siCancellaLeViews']);?>
		<?php } else { ?>
	<div style="margin:0 auto;padding:21px;background:#ffffcc;text-align:center;width:280px;font-size:12px;">
		<?php echo $lang['QST_CreoViewsPerTab']; ?> <b><?php echo $_POST['tab']; ?></b>?<br/>
		<?php echo $lang['MSG_SeEsistentiVerrannoSovrascritte']; ?><br/>		
		<?php echo _formSubmit($lang['ANS_siCreaLeViews']);?>
		<?php } ?>

	</form>
	</div>
		<?php } else { ?>
	<?php echo $lang['MSG_SelezionaAlmenoUnaView']; ?>
		<?php } ?>
	<?php } ?>
	

	<?php if($index_data['display']!=""){echo "INDEX<br/>";
	echo '<textarea style="font-size:10px;width:100%;height:90px;padding:9px;">'.$index_data['display'].'</textarea><br/><br/>';} ?>
	
	<?php if($new_data['display']!=""){echo "NEW<br/>";
	echo '<textarea style="font-size:10px;width:100%;height:90px;padding:9px;">'.$new_data['display'].'</textarea><br/><br/>';} ?>
	
	<?php if($upd_data['display']!=""){echo "UPD<br/>";
echo '<textarea style="font-size:10px;width:100%;height:90px;padding:9px;">'.$upd_data['display'].'</textarea><br/><br/>';} ?>
	
</td>
</tr>
</table>
