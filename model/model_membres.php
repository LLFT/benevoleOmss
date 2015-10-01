<?php
class model_membres extends abstract_model{
	
	protected $sClassRow='row_membres';
	
	protected $sTable='membres';
	protected $sConfig='benevoleOmss';
	
	protected $tId=array('idMembre');

	public static function getInstance(){
		return self::_getInstance(__CLASS__);
	}

	public function findById($uId){
		return $this->findOne('SELECT * FROM '.$this->sTable.' WHERE idMembre=?',$uId );
	}
	public function findAll($sLetter=NULL){
            $requete = 'SELECT * FROM '.$this->sTable;            
            if (isset($sLetter)){
                $requete .= ' WHERE `nom` LIKE "'.$sLetter.'%"';
                $requete .= ' AND `active`=1';
            }
            else{
                $requete .= ' WHERE `active`=1';
            }
            $requete .= ' ORDER BY  `nom` ASC';
            return $this->findMany($requete);
	}
        
        public function findAllDelete($sLetter=NULL){
            $requete = 'SELECT * FROM '.$this->sTable;            
            if (isset($sLetter)){
                $requete .= ' WHERE `nom` LIKE "'.$sLetter.'%"';
                $requete .= ' AND `active`=0';
            }
            else{
                $requete .= ' WHERE `active`=0';
            }
            $requete .= ' ORDER BY  `nom` ASC';
            return $this->findMany($requete);
	}
        
        public function findAllEmptyAdress($sLetter=NULL){
            $requete = 'SELECT * FROM '.$this->sTable.' where (`rue` = "" or `ville` = "" or `codePostal` = "0" )';
            if (isset($sLetter)){
                $requete .= ' AND `nom` LIKE "'.$sLetter.'%"';
                $requete .= ' AND `active`=1';
            }
            else{
                $requete .= ' AND `active`=1';
            }
            $requete .= ' ORDER BY  `nom` ASC';
            return $this->findMany($requete);
	}
	
        public function findAllEmptyMail($sLetter=NULL){
            $requete = 'SELECT * FROM '.$this->sTable.' where `mail` = ""';                
            if (isset($sLetter)){
                $requete .= ' AND `nom` LIKE "'.$sLetter.'%"';
                $requete .= ' AND `active`=1';
            }else{
                $requete .= ' AND `active`=1';
            }
            $requete .= ' ORDER BY  `nom` ASC';
            return $this->findMany($requete);
	}
        
        public function findAllEmptyPermis($sLetter=NULL){
            $requete = 'SELECT * FROM '.$this->sTable.' where `numPermis` = ""';
            if (isset($sLetter)){
                $requete .= ' AND `nom` LIKE "'.$sLetter.'%"';
            $requete .= ' AND `active`=1';
            }else{
                $requete .= ' AND `active`=1';
            }
            $requete .= ' ORDER BY  `nom` ASC';
            return $this->findMany($requete);
	}
	
        
        public function findAllNotLocalized(){
            $requete = 'SELECT * FROM '.$this->sTable.' where `coord` IS NULL';
            return $this->findMany($requete);
        }
        
        public function findAllLocalisable(){
            return $this->findMany('SELECT `idMembre`,`rue`,`ville`,`codePostal` FROM '.$this->sTable.' WHERE `coord` IS NULL or `coord`=0 and `rue` != "" and `ville` != "" ');
        }
        
        public function findCoordParticipantOfEvent($idEvent) {
            return $this->findMany('SELECT m.idMembre, nom, prenom, lat, lng FROM omss.membres as m, omss.relationeventmemb as r WHERE m.idMembre=r.membre_id and r.event_id=?',$idEvent);
        }


//        public function findDistinctAlpha() {
//                return $this->findMany('SELECT DISTINCT left(nom,1) AS letter FROM '.$this->sTable.' ORDER BY letter ASC ');
//        }
        

        
        public function findDistinctLetters($oMembres) {
            $tName=array();
            if (!empty($oMembres)){
            foreach ($oMembres as $oMenbre) {                
                $tName[]=$oMenbre->nom[0];
            }
            //On elimine le doublons.
            $retour = array_unique($tName);
            //On retourne un Array réindexé proprement.
            }else{
                $retour=array("0"=>"#");
            }
            
            return array_values($retour);
        }     
        
        public function findExportCSVFull() {
            $requete =  "SELECT `indexMembre`, `nom`, `prenom`, `mail`, `fixe`, `gsm`, `numero`, `rue`, `complement`, `ville`, `codePostal`, `club`, `numPermis` FROM `membres` WHERE `active`=1";
            return $this->findMany($requete);
        }
        
        public function findExportCSVEmptyAdress() {
            $requete =  "SELECT `indexMembre`, `nom`, `prenom`, `mail`, `fixe`, `gsm`, `numero`, `rue`, `complement`, `ville`, `codePostal`, `club`, `numPermis` FROM `membres` where (`rue` = '' or `ville` = '' or `codePostal` = '0' ) AND `active`=1";
            return $this->findMany($requete);
        }
        
        public function findExportCSVEmptyMail() {
            $requete =  "SELECT `indexMembre`, `nom`, `prenom`, `mail`, `fixe`, `gsm`, `numero`, `rue`, `complement`, `ville`, `codePostal`, `club`, `numPermis` FROM `membres` where `mail` = '' AND `active`=1";
            return $this->findMany($requete);
        }
        
        public function findExportCSVEmptyPermis() {
            $requete =  "SELECT `indexMembre`, `nom`, `prenom`, `mail`, `fixe`, `gsm`, `numero`, `rue`, `complement`, `ville`, `codePostal`, `club`, `numPermis` FROM `membres` where `numPermis` = '' AND `active`=1";
            return $this->findMany($requete);
        }
        
        
        public function orderByName() {
            $requete =  "SELECT `idMembre` FROM `membres` WHERE `active`=1 ORDER BY `nom` ASC, `prenom` ASC";
            return $this->findMany($requete);
        }
        
        public function findLastIndexMembre() {
            $requete =  "SELECT `indexMembre` From omss.membres Where `indexMembre` IS NOT NULL ORDER BY `indexMembre` DESC LIMIT 1";
            return $this->findOne($requete);
        }
        
        public function getCoordOfParticipantOfEvent($idEvent) {
            $tab=$this->findCoordParticipantOfEvent($idEvent);
		$tSelect=array();
                
		if($tab){
                    foreach($tab as $oRow){
                            $tSelect[]=array("idMembre"=>"$oRow->idMembre" ,"nom"=>"$oRow->nom","prenom"=>"$oRow->prenom","lat"=>"$oRow->lat","lng"=>"$oRow->lng");
                    }
		}
		return $tSelect;
            
        }
        
}

class row_membres extends abstract_row{
	
	protected $sClassModel='model_membres';
	
	/*exemple jointure 
	public function findAuteur(){
		return model_auteur::getInstance()->findById($this->auteur_id);
	}
	*/
	/*exemple test validation*/
	private function getCheck(){
                $oCheck=new plugin_check();
		$oPluginValid=new plugin_valid($this->getTab());
                $oPluginValid->isNotEmpty('nom','Ce champ doit &ecirc;tre saisi');
                $oPluginValid->isNotEmpty('prenom','Ce champ doit &ecirc;tre saisi');
                $oPluginValid->isNotEmpty('rue','Ce champ doit &ecirc;tre saisi');
                $oPluginValid->isNotEmpty('ville','Ce champ doit &ecirc;tre saisi');
		//$oPluginValid->isEmailValid('mail','L\'email est invalide');
                
//                if($oCheck->isEmpty($this->gsm) && $oCheck->isNotEmpty($this->fixe) ){
//                    $oPluginValid->matchExpression('fixe','/^(0|\+[1-9]{1,3})[0-9]{5,14}$/','Le champ n\'est pas au bon format');
//                }
//                if($oCheck->isNotEmpty($this->gsm) && $oCheck->isEmpty($this->fixe) ){
//                    $oPluginValid->matchExpression('gsm','/^(0|\+[1-9]{1,3})[0-9]{5,14}$/','Le champ n\'est pas au bon format');
//                }
//                
//                if($oCheck->isNotEmpty($this->gsm) && $oCheck->isNotEmpty($this->fixe) ){
//                    $oPluginValid->matchExpression('fixe','/^(0|\+[1-9]{1,3})[0-9]{5,14}$/','Le champ n\'est pas au bon format');
//                    $oPluginValid->matchExpression('gsm','/^(0|\+[1-9]{1,3})[0-9]{5,14}$/','Le champ n\'est pas au bon format');
//                }
                
                
                if($oCheck->isEmpty($this->gsm) && $oCheck->isEmpty($this->fixe) ){
                    $oPluginValid->isNotEmpty('fixe','Au moins l\'un de ces champs doit &ecirc;tre saisi');                    
                }
                
                if($oCheck->isEqual($this->chkMail,1)){
                    $oPluginValid->isEmailValid('mail','L\'email est invalide');
                }
                
                if($oCheck->isEqual($this->chkPermis,1)){
                    $oPluginValid->isNotEmpty('numPermis','Ce champ doit &ecirc;tre si le membre poss&egrave;de un permis.');
                }
                
		/* renseigner vos check ici
		$oPluginValid->isEqual('champ','valeurB','Le champ n\est pas &eacute;gal &agrave; '.$valeurB);
		$oPluginValid->isNotEqual('champ','valeurB','Le champ est &eacute;gal &agrave; '.$valeurB);
		$oPluginValid->isUpperThan('champ','valeurB','Le champ n\est pas sup&eacute; &agrave; '.$valeurB);
		$oPluginValid->isUpperOrEqualThan('champ','valeurB','Le champ n\est pas sup&eacute; ou &eacute;gal &agrave; '.$valeurB);
		$oPluginValid->isLowerThan('champ','valeurB','Le champ n\est pas inf&eacute;rieur &agrave; '.$valeurB);
		$oPluginValid->isLowerOrEqualThan('champ','valeurB','Le champ n\est pas inf&eacute;rieur ou &eacute;gal &agrave; '.$valeurB);
		$oPluginValid->isEmpty('champ','Le champ n\'est pas vide');
		$oPluginValid->isNotEmpty('champ','Le champ ne doit pas &ecirc;tre vide');
		$oPluginValid->isEmailValid('champ','L\email est invalide');
		$oPluginValid->matchExpression('champ','/[0-9]/','Le champ n\'est pas au bon format');
		$oPluginValid->notMatchExpression('champ','/[a-zA-Z]/','Le champ ne doit pas &ecirc;tre a ce format');
		*/

		return $oPluginValid;
	}

	public function isValid(){
		return $this->getCheck()->isValid();
	}
	public function getListError(){
		return $this->getCheck()->getListError();
	}
	public function save(){
		if(!$this->isValid()){
			return false;
		}
		parent::save();
		return true;
	}
        
        
        // Save Forcé sans contrôle afin de faire le rapprochement.
        public function saveF(){
		parent::save();
		return true;
	}

}
