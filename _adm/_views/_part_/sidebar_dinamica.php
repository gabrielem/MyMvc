<?php
//sidebar_dinamica.php

    if($_GET['selettore']=="tab")
    {
        //echo'Sidebar Tab';
            
            if($_GET['_azione_']=="index")
            {
                echo '<a class="new" href="'.$selettoreUrl.'new/">'.$lang['linkNuovoRecord'].'</a>';
            }
            elseif($_GET['_azione_']=="new")
            {
                echo '<a class="new" href="'.$selettoreUrl.'">Back to the List</a>';
                
            }
            elseif($_GET['_azione_']=="upd")
            {
                echo '<a class="new" href="'.$selettoreUrl.'">Back to the List</a>';
                echo '<a class="new" href="'.$selettoreUrl.'new/">'.$lang['linkNuovoRecord'].'</a>';
                
            }
            
            
    }
    elseif($_GET['selettore']=="url")
    {
        echo 'Sidebar URL';
    }
    else
    {
        echo 'Select one Set';
        
        echo '<div>';
        
        echo '<a class="new" href="'.$rootBase.'admin/tab/sezioni/">Pages</a>';
        
        
        echo '</div>';
        
        
        //pr($mm);
        
    }
//pr($_GET);

?>