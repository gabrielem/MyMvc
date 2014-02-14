<?php
        if($a['STATUS']!="404")
        {
            //echo $a['SUB_MODEL'];
            if(!empty($a['BEHAVIOR']))
            {
            $controllerCassOb=New $controllerCass_TO_INIT;
            $controllerCass_SELECT=$controllerCass_TO_INIT;
            }
            elseif(empty($a['SUB_MODEL']))
            {
            $controllerCassOb=New $controllerCass;
            $controllerCass_SELECT=$controllerCass;
            }
            else
            {
                if(!empty($subControllerCass))
                {
                if($a['SUB_MODEL']==$a['ACTION']) unset($a['ACTION']);
            $controllerCassOb=New $subControllerCass;
            $controllerCass_SELECT=$subControllerCass;
                }
            }
            
                //pr($a['ACTION']);
                if(empty($a['ACTION'])){$a['ACTION']="rootModel";}
            
            if(!empty($a['ACTION']) )
            {
                //For ACTION: new add a _ before for avoid PHP error
                if($a['ACTION']=="new") {$a['ACTION']="_new";}
                
                if(method_exists($controllerCassOb,$a['ACTION']))
                {
                $a=$controllerCassOb->$a['ACTION']($a);
                }
                else
                {
                $a['ALERT'].='<p>Method <b>'.$a['ACTION'].'</b> for class: <b>'.$a['CONTROLLER_CLASS'].'</b> (sub: <b>'.$a['SUB_CONTROLLER_CLASS'].'</b>) dosent exists</p>';
                }
            }
            
            
        $a=$modelClassToInit->_afterInit($a);
        }
        
        /*
                
                Init $a['url_mod']
                
        */
        if(empty($a['url_mod']))
        {
                $a['url_mod']=rootWWW.$a['route']['model']."/";
                if($a['route']['model']=="home"){$a['url_mod']=rootWWW;}
        }