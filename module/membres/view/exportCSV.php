INDEX;NOM;PRENOM;NUMERO;RUE;COMPLEMENT;VILLE;CODEPOSTAL;MAIL;FIXE;GSM;ANNEENAISSANCE;CLUB;NUMPERMIS;SIGNALEUR;VALIDE;COMMENT
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
    echo html_entity_decode($oMembre->anneeNaissance).';';
    echo html_entity_decode($oMembre->club).';';
    echo html_entity_decode($oMembre->numPermis).';';
    echo html_entity_decode($oMembre->chkSignaleur).';';
    echo html_entity_decode($oMembre->chkFormulaire).';';    
    echo html_entity_decode($oMembre->comment)."\n";
endforeach;