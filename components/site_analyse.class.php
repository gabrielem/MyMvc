<?php
/******************************************************************************
*******************************************************************************

Class made on 20 dic 2012 - by the script llocated at: 3ml.it/pr/3/
AUTHOR: Gabriele Marazzi
Class is made by many other script putting all togheter
Still in develope mode!!!

IT SUPPORT ALSO PROXY REQUEST!

*******************************************************************************

USAGE: $array=SITE_ANALYSE::massPr("string with urls, can be any format!!!");

*******************************************************************************
*******************************************************************************
*******************************************************************************/

$googlehost='toolbarqueries.google.com';
$googleua='Mozilla/5.0 (Windows; U; Windows NT 5.1; en-US; rv:1.8.0.6) Gecko/20060728 Firefox/1.5';

class SITE_ANALYSE
{
	function massPr($u)
	{
	preg_match_all('/[-\w^.]*\.(com|net|org|info|co|us|vn|it|eu|biz|tv|name|me)/si',$u,$rs);
	//print_r($rs[0]);
	
	$dem=0;$list_domain=array();ob_start();
	    
	    foreach($rs[0] as $value)
	    {
		    ob_end_flush();
	    
		    ob_flush();
		    
		    flush();
		    
		    ob_start();
		    
		    echo '<script type="text/javascript">
	var t1 = document.getElementById("status");
	t1.innerHTML="Checked:'.$dem.' Domain:'.$value .'...";
	</script>
	';
		    /**/
		$dem++;
		/*
		$url='http://'.$value;
		echo '<a href="http://'.$value.'">'.$value.'</a><br/>';
		echo '<script type="text/javascript">
	    window.open("'.$url.'", "_blank");
	</script>';
	*/      ######################
		#$value la domain khong co http 
	#######################################
		$url='http://'.$value;
		$_POST['link']=$url;
		if(isset($_POST['link']))
		{
		  
		error_reporting(0);   
		$_POST['url']=$_POST['link'];
		//PageRank Script By: EziScript.com
		    $url3 = strtolower($_POST['url']);
		
		$num = strtolower($_POST['url']);
		if ($pos === false) {
		    $num1="http://".$num;
		    $url = parse_url($num1); 
		    } else {
		   $url = parse_url($num1); 
		} 
		//settings - host and user agent
		
		//convert a string to a 32-bit integer
		$dem2=$dem-1;
		$a[$dem2]['url']=$_POST['url'];
		
		
		//$IP = gethostbyname($a[$dem2]['url']);
		//$a[$dem2]['ip']=$IP;
		
		$a[$dem2]['ip']=SITE_ANALYSE::getAddrByHost("".str_replace("http://","",$a[$dem2]['url']));
	
	
	
			//ARRAY 
			//URL,PROXY_IP,PROXY_PORT,PROXY_LOGIN,PROXY_PSW
			
			$DATI['URL']=$_POST['link'];
			$DATI['PROXY_IP']="";
			$DATI['PROXY_PORT']="";
			$DATI['PROXY_LOGIN']="";
			$DATI['PROXY_PSW']="";
			
			$pagerank[$dem2]=SITE_ANALYSE::pagerank($DATI);
			
			if($pagerank[$dem2]['esito'])
			{
			$a[$dem2]['pr']=$pagerank[$dem2]['pr'];
			}
			else
			{
			$a[$dem2]['pr']="---";
			}
			
			//
			//echo $a[$dem2]['pr'];
			
			/*
			if($a[$dem2]['pr']=="err")
			{
			$err=true;
			break; 
			}
			*/
			
			
		//$a['dem'][]=$dem;
		}
	    }
	   
	//}
	//print_r($a);
	//for($i=0;$i<count($a);$i++){echo'<p>'.$a[$i]['url'].' - '.$a[$i]['pr'].'</p>';}
	
	
	SITE_ANALYSE::aasort($a,"pr","arsort");
	
	
		//if($err)
		//{
		//return false;
		//}
		//else
		//{
		return $a;
		//}
	
	}
























function getAddrByHost($host, $timeout = 3) {
   $query = `nslookup -timeout=$timeout -retry=1 $host`;
   if(preg_match('/\nAddress: (.*)\n/', $query, $matches))
      return trim($matches[1]);
   return $host;
}


function aasort (&$array,$key,$metod=sort) {
	if(empty($array)) return fasle;
    $sorter=array();
    $ret=array();
    @reset($array);
    foreach ($array as $ii => $va) {
        $sorter[$ii]=$va[$key];
    }

    $metod($sorter);
    foreach ($sorter as $ii => $va) {
        $ret[$ii]=$array[$ii];
    }
    $array=$ret;
}










        //return the pagerank figure

	function __pagerank($url){return SITE_ANALYSE::getpr($url);}


## 
## FUNZIONE CON CURL E PROXY
##
function pagerank($settings)
{
### URL,PROXY_IP,PROXY_PORT,PROXY_LOGIN,PROXY_PSW
//$settings
$url_to_check=$settings['URL'];

global $googlehost,$googleua;
$ch_url = SITE_ANALYSE::getch($url_to_check);
//echo $ch;

//$ip="174.127.67.236"; 
//$port="554";
//$login="809227581";
//$psw="273d1faa";

$ip=$settings['PROXY_IP'];
$port=$settings['PROXY_PORT']; 
## IMPOSTO PORTA DEFAULT 8080
if(empty($port)){$port="8080";}

$login=$settings['PROXY_LOGIN'];
$psw=$settings['PROXY_PSW'];



$loginpassw = $login.':'.$psw;  //your proxy login and password here
$proxy_ip = $ip; //proxy IP here
$proxy_port = $port; //proxy port from your proxy list

$url="http://".$googlehost."/tbr?client=navclient-auto&ch=".$ch_url."&features=Rank&q=info:".$url_to_check;
//$url="http://www.olo-service.com/";


$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, $url);
curl_setopt($ch, CURLOPT_HEADER, 0); // no headers in the output
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1); // output to variable
	
	//SE è settato imposto IP e porta del proxy
	if(!empty($ip))
	{
	//echo'<h1>uso proxy</h1>';
curl_setopt($ch, CURLOPT_PROXYPORT, $proxy_port);
curl_setopt($ch, CURLOPT_PROXYTYPE, 'HTTP');
curl_setopt($ch, CURLOPT_PROXY, $proxy_ip);
	}
	//else{echo'<h1>NON uso proxy</h1>';}
	
	if(!empty($login))
	{
curl_setopt($ch, CURLOPT_PROXYUSERPWD, $loginpassw);
	}
	//else{echo'<h1>NON uso AUTH proxy</h1>';}

$data = curl_exec($ch);

	if(!$data)
	{
	//echo 'Curl error: ' . curl_error($ch);
	return array('esito'=>false,'msg'=>curl_error($ch));
	}

curl_close($ch);

//echo $data;
	$pos = strpos($data, "Rank_");
	if($pos === false){} else{
	$pr=substr($data, $pos + 9);
	$pr=trim($pr);
	$pr=str_replace("\n",'',$pr);
	//return $pr;
	return array('esito'=>true,'pr'=>$pr);
	}


}





        function getpr($url) 
        {
        	global $googlehost,$googleua;
        	$ch = SITE_ANALYSE::getch($url);
            	
//

$ip="174.127.67.236"; 
$port="554";

$login="809227581";
$psw="273d1faa";

//$fp = fsockopen($ip,$port);
$fp = fsockopen($googlehost, 80, $errno, $errstr, 30);


        	if ($fp) {
		//$out = "GET $googlehost/tbr?client=navclient-auto&ch=$ch&features=Rank&q=info:$url HTTP/1.1\r\n";
		$out = "GET /tbr?client=navclient-auto&ch=$ch&features=Rank&q=info:$url HTTP/1.1\r\n";
		//echo "<pre>$out</pre>\n"; //debug only
		//$out .= "Proxy-Authorization: Basic ".base64_encode("$login:$psw") ."\r\n";

		$out .= "User-Agent: $googleua\r\n";
		$out .= "Host: $googlehost\r\n";
		$out .= "Connection: Close\r\n\r\n";

		fwrite($fp, $out);

/*
fputs($fp, "GET <a href="http://www.yahoo.com/" title="http://www.yahoo.com/">http://www.yahoo.com/</a> HTTP/1.1\r\nHost:www.yahoo.com:80\r\nProxy-Authorization: Basic ".base64_encode("$login:$passwd") ."\r\n\r\n");
*/

        	   
        	   //$pagerank = substr(fgets($fp, 128), 4); //debug only
        	   //echo $pagerank; //debug only
			//echo $fp;
        	   while (!feof($fp)) {
        			$data = fgets($fp, 128);
        			//echo $data;
        			$pos = strpos($data, "Rank_");
        			if($pos === false){} else{
        				$pr=substr($data, $pos + 9);
        				$pr=trim($pr);
        				$pr=str_replace("\n",'',$pr);
        				return $pr;
        			}
        	   }
        	   //else { echo "$errstr ($errno)<br />\n"; } //debug only
        	   fclose($fp);
        	}
        }
        
        //generate the graphical pagerank
        function pagerank_($url,$width=100,$method='image') 
        {
        	if (!preg_match('/^(http:\/\/)?([^\/]+)/i', $url)) { $url='http://'.$url; }
        	$pr=SITE_ANALYSE::getpr($url);
        	$pagerank="PageRank: $pr/10";
        
        	//The (old) image method
        	if ($method == 'image') {
        	$prpos=$width*$pr/10;
        	$prneg=$width-$prpos;
        	$html='<img src="pos.jpg" width='.$prpos.' height=15px border=0 alt="'.$pagerank.'"><img src="neg.jpg" width='.$prneg.' height=15px border=0 alt="'.$pagerank.'">';
        	}
        	//The pre-styled method
        	if ($method == 'style') {
        	$prpercent=100*$pr/10;
        	$html='<div style="position: relative; width: '.$width.'px; padding: 0; background: #D9D9D9;"><strong style="width: '.$prpercent.'%; display: block; position: relative; background: #5EAA5E; text-align: center; color: #333; height: 10px; line-height: 10px;"><span></span></strong></div>';
        	}
            
            
            if($pr=='')
            {
                $out= '<font color=red><b>Unrank</b></font>';
            }
            else
            {
        	 $out="<b>Page Rank:</b>(<font color=red><b>$pr<b></font>/10)";
        	}
        	return $pr;//$out;
        }















###########
###########
###########
###########
###########
###########
###########












    function StrToNum($Str, $Check, $Magic) {
            $Int32Unit = 4294967296;  // 2^32
        
            $length = strlen($Str);
            for ($i = 0; $i < $length; $i++) {
                $Check *= $Magic; 	
                //If the float is beyond the boundaries of integer (usually +/- 2.15e+9 = 2^31), 
                //  the result of converting to integer is undefined
                //  refer to http://www.php.net/manual/en/language.types.integer.php
                if ($Check >= $Int32Unit) {
                    $Check = ($Check - $Int32Unit * (int) ($Check / $Int32Unit));
                    //if the check less than -2^31
                    $Check = ($Check < -2147483648) ? ($Check + $Int32Unit) : $Check;
                }
                $Check += ord($Str{$i}); 
            }
            return $Check;
        }
        
        //genearate a hash for a url
        function HashURL($String) {
            $Check1 = SITE_ANALYSE::StrToNum($String, 0x1505, 0x21);
            $Check2 = SITE_ANALYSE::StrToNum($String, 0, 0x1003F);
        
            $Check1 >>= 2; 	
            $Check1 = (($Check1 >> 4) & 0x3FFFFC0 ) | ($Check1 & 0x3F);
            $Check1 = (($Check1 >> 4) & 0x3FFC00 ) | ($Check1 & 0x3FF);
            $Check1 = (($Check1 >> 4) & 0x3C000 ) | ($Check1 & 0x3FFF);	
        	
            $T1 = (((($Check1 & 0x3C0) << 4) | ($Check1 & 0x3C)) <<2 ) | ($Check2 & 0xF0F );
            $T2 = (((($Check1 & 0xFFFFC000) << 4) | ($Check1 & 0x3C00)) << 0xA) | ($Check2 & 0xF0F0000 );
        	
            return ($T1 | $T2);
        }
        
        //genearate a checksum for the hash string
        function CheckHash($Hashnum) {
            $CheckByte = 0;
            $Flag = 0;
        
            $HashStr = sprintf('%u', $Hashnum) ;
            $length = strlen($HashStr);
        	
            for ($i = $length - 1;  $i >= 0;  $i --) {
                $Re = $HashStr{$i};
                if (1 === ($Flag % 2)) {              
                    $Re += $Re;     
                    $Re = (int)($Re / 10) + ($Re % 10);
                }
                $CheckByte += $Re;
                $Flag ++;	
            }
        
            $CheckByte %= 10;
            if (0 !== $CheckByte) {
                $CheckByte = 10 - $CheckByte;
                if (1 === ($Flag % 2) ) {
                    if (1 === ($CheckByte % 2)) {
                        $CheckByte += 9;
                    }
                    $CheckByte >>= 1;
                }
            }
        
            return '7'.$CheckByte.$HashStr;
        }
        
        //return the pagerank checksum hash
        function getch($url) { return SITE_ANALYSE::CheckHash(SITE_ANALYSE::HashURL($url)); }
}
