INDEX;NOM;PRENOM;NUMERO;RUE;COMPLEMENT;VILLE;CODEPOSTAL;MAIL;FIXE;GSM;CLUB;NUMPERMIS
<?php
foreach($this->tMembres as $oMembre):
   echo html_entity_decode($oMembre->indexMembre).';';
    echo html_entity_decode($oMembre->nom).';';
    echo html_entity_decode($oMembre->prenom).';';
    echo html_entity_decode($oMembre->numero).';';
    echo html_entity_decode($oMembre->rue).';';
    echo html_entity_decode($oMembre->complement).';';
    echo html_entity_decode($oMembre->ville).';';
    echo html_entity_decode($oMembre->codePostal).';';
    echo html_entity_decode($oMembre->mail).';';
    echo html_entity_decode($oMembre->fixe).';';
    echo html_entity_decode($oMembre->gsm).';';
    echo html_entity_decode($oMembre->club).';';
    echo html_entity_decode($oMembre->numPermis)."\n";
endforeach;