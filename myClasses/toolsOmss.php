<?php
class my_toolsOMSS{
    
    public function reIndexMembers($oIdMembers) {
        $i=0;
        $i++;
        foreach ($oIdMembers as $iIdMembre) {
            $this->saveIndexMembre($iIdMembre->idMembre, $i);
            $i++;
        }
        return $i;
    }
    
    Private function saveIndexMembre($iIdMembre, $iIndex) {
        $oMembreEdit = model_membres::getInstance()->findById($iIdMembre);
        $oMembreEdit->indexMembre = $iIndex;
        /*On effectue une sauvegarde sans se soucier des controles de validité*/
        $oMembreEdit->saveF();           
        
    }
}
    

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

