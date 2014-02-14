<?php
//urlMenuAdmin.php
function urlMenuAdmin($a)
{
global $rootBase;
global $rootBaseAdmin;
global $dirADMIN;

$rootBaseAdmin=$rootBase."a/";

	if(!empty($a['url']))
	{
	$a['url']=str_replace('$rootBaseAdmin',$rootBaseAdmin,$a['url']);
	$a['url']=str_replace('$rootBase',$rootBase,$a['url']);
	$url=$a['url'];
	}
	else if(!empty($a['selettore']))
	{
	$url=$rootBaseAdmin.$a['selettore']."/".$a['id_s']."/";
	}
	else
	{
	$url="#";
	}

return $url;
}



function printTitle($a)
{
    global $lang;
//    pr($lang);
//   pr($a);

    $tab_name=ucfirst($_GET['id_s']);
	
	//modifico il nome delle tab in lang
	$tab_name_lang="TAB_NAME_".$_GET['id_s'];
	if(isset($lang[$tab_name_lang]))
	{
	$tab_name=$lang[$tab_name_lang];
	}
    if($_GET['_azione_']=="index")
    {
    $echo="List of ".$tab_name." Items";
    }
    elseif($_GET['_azione_']=="new")
    {
    $echo="Create new ".$tab_name;
    }
    elseif($_GET['_azione_']=="upd")
    {
        $nome_item=$a[0]['nome'];
        if(empty($nome_item)) $nome_item=$a[0]['name'];
        if(empty($nome_item)) $nome_item=$a[0]['titolo'];
        if(empty($nome_item)) $nome_item=$a[0]['title'];
        
    $echo="Update ".$tab_name.": ".$nome_item;
    }
    
    return $echo;
}

?>
