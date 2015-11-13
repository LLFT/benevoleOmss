
Liste des personnes ne pouvant être localisé : 
<ul>
<?php
foreach ($this->tLocalizationFail as $values) {
    foreach ($values as $value) {        
            echo '<li><a href="'.$this->getLink('membres::show',array( 'id'=>$value[0])).'"> '. $value[1].' '.$value[2].'</a></li>';                  
        }        
    }    

?>
</ul>