<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class My_BackAction {
    
    
    protected $bArchiveEventAuto = False;
    protected $aListEventArchi = array();




    /**
     * Class constructor
     */
    public function __construct() {
    }
    
    /*
     * Liste les évènements qui ont passé la date de réalisation.
     */
    
    public function listEventArchi() {
        $date1 = new DateTime("now");   //Date du Jour
        $oEvents=model_events::getInstance()->findAll(); // Tous les évènements de la base Events 
        foreach ($oEvents as $event) {
            if ($event->active != 0){// Vérifie si l'event n'est pas déjà archivé.
                $oDate = new plugin_date($event->date,'d/m/Y'); //Convertit la date récupéré 
                $date2 = new DateTime($oDate->toString('Y-m-d')); //Convertit la date reformaté en DateTime
                $date2->add(new DateInterval('P1D')); //Ajout d'un Jour afin de ne pas archiver l'évènement du Jour               
                if($date1 > $date2){ 
                    array_push($this->aListEventArchi, $event->idEvent); //Enregistres les Events ayant Expirés.
                    $this->bArchiveEventAuto = TRUE; // Active l'archivage Auto                    
                }       
            }
        }
        if ($this->bArchiveEventAuto){
            $this->archiveEvent(); //Exécute l'archivage Auto.
        }   
    }
    
    
    /**
     * Archive les évènements prélistés.
     */
    private function archiveEvent() {        
        foreach ($this->aListEventArchi as $idEvent) {
            $oEvents=model_events::getInstance()->findById($idEvent);
            $oEvents->active=0;
            $oEvents->save();
        }            
        $this->bArchiveEventAuto = FALSE;
    }
    
    
    public function listInfoMember() {
        $date1 = new DateTime("now");   //Date du Jour
        $date1->sub(new DateInterval('P1Y'));
        $oMembers = model_membres::getInstance()->findAll();
        foreach ($oMembers as $oMember) {
            if (!$oMember->modifier){
                $date2 = new DateTime($oMember->creer); 
            }else{
                $date2 = new DateTime($oMember->modifier); 
            }
            if($date1 > $date2){ 
                $oMember->chkSignaleur = 0;
                $oMember->chkFormulaire = 0;
                $oMember->saveF();
            }       
            
        }
        if ($this->bArchiveEventAuto){
            $this->archiveEvent(); //Exécute l'archivage Auto.
        }   
    }
    
    
    
    
    
}