INDEX;NOM;PRENOM;NUMERO;RUE;COMPLEMENT;VILLE;CODEPOSTAL;MAIL;FIXE;GSM;ANNEENAISSANCE;CLUB;NUMPERMIS;SIGNALEUR;VALIDE;COMMENT
<?php
$tColumn = array('idMembre','nom','prenom','numero','rue','complement','ville','codePostal','mail','fixe','gsm','anneeNaissance','club','numPermis','chkSignaleur','chkFormulaire','comment');
foreach($this->tMembres as $oMembre):
    foreach($tColumn as $sColumn){
        //On Suprime les sauts de page du commentaires            
        echo html_entity_decode(preg_replace("/(.)?\n/","\\",$oMembre->$sColumn),ENT_QUOTES).';';                
    }
    echo "\n";
endforeach;