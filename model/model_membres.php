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
            $requete = 'SELECT * FROM '.$this->sTable.' where ((`rue` = "" or `rue`is NULL ) or (`ville` = "" or `ville`is NULL) or (`codePostal` = "0" or `codePostal`is NULL) )';
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
            $requete = 'SELECT * FROM '.$this->sTable.' where (`mail` = "" OR `mail` is NULL)';                
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
            $requete = 'SELECT * FROM '.$this->sTable.' where (`numPermis` = "" OR `numPermis` = 0 OR `numPermis` is NULL)';
            if (isset($sLetter)){
                $requete .= ' AND `nom` LIKE "'.$sLetter.'%"';
            $requete .= ' AND `active`=1';
            }else{
                $requete .= ' AND `active`=1';
            }
            $requete .= ' ORDER BY  `nom` ASC';
            return $this->findMany($requete);
	}
        
        public function findAllUpdate($sLetter=NULL){
            $requete = 'SELECT * FROM '.$this->sTable.' where `chkFormulaire` = "1"';
            if (isset($sLetter)){
                $requete .= ' AND `nom` LIKE "'.$sLetter.'%"';
            $requete .= ' AND `active`=1';
            }else{
                $requete .= ' AND `active`=1';
            }
            $requete .= ' ORDER BY  `nom` ASC';
            return $this->findMany($requete);
	}
        
        public function findAllNotUpdate($sLetter=NULL){
            $requete = 'SELECT * FROM '.$this->sTable.' where `chkFormulaire` = "0"';
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
            return $this->findMany('SELECT * FROM '.$this->sTable.' WHERE (`coord` IS NULL or `coord`=0) and `rue` != "" and `ville` != "" AND `active`=1');
        }
        

        public function findParticipantOfEvent($idEvent) {
            return $this->findMany('SELECT * FROM omss.membres as m, omss.relationeventmemb as r WHERE m.idMembre=r.membre_id and r.event_id=? ORDER BY `nom` ASC, `prenom` ASC',$idEvent);
        }      
//=======
//        public function findCoordParticipantOfEvent($idEvent) {
//            return $this->findMany('SELECT m.idMembre, nom, prenom, lat, lng FROM omss.membres as m, omss.relationeventmemb as r WHERE m.idMembre=r.idMembre and r.idEvent=?',$idEvent);
//        }
//>>>>>>> Stashed changes


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
        
        public function orderByName() {
            $requete =  "SELECT `idMembre` FROM `membres` WHERE `active`=1 ORDER BY `nom` ASC, `prenom` ASC";
            return $this->findMany($requete);
        }
        
       
        public function getCoordOfParticipantOfEvent($idEvent) {
            $tab=$this->findParticipantOfEvent($idEvent);
		$tSelect=array();
                
		if($tab){
                    foreach($tab as $oRow){
                            $tSelect[]=array("idMembre"=>"$oRow->idMembre" ,"nom"=>"$oRow->nom","prenom"=>"$oRow->prenom","lat"=>"$oRow->lat","lng"=>"$oRow->lng");
                    }
		}
		return $tSelect;
            
        }
        
        public function getInfoMenber($idMember){
                    
                $oRow=$this->findById($idMember);
		$tSelect=array();
                $addresse=html_entity_decode($oRow->numero.' '.$oRow->rue.' '.$oRow->complement." \n ".$oRow->ville.' '.$oRow->codePostal,ENT_QUOTES);
                $comment=html_entity_decode($oRow->comment,ENT_QUOTES);
                $tSelect[]=array(
                    "idMembre"=>"$oRow->idMembre",
                    "nom"=>"$oRow->nom",
                    "prenom"=>"$oRow->prenom",
                    "adresse"=>"$addresse",
                    "comment"=>"$comment"
                );
                    
		return $tSelect;
        }
        
//        public function getCoordOfParticipantOfEvent($idEvent) {
//            $tab=$this->findCoordParticipantOfEvent($idEvent);
//		$tSelect=array();
//                
//		if($tab){
//                    foreach($tab as $oRow){
//                            $tSelect[]=array("idMembre"=>"$oRow->idMembre" ,"nom"=>"$oRow->nom","prenom"=>"$oRow->prenom","lat"=>"$oRow->lat","lng"=>"$oRow->lng");
//                    }
//		}
//		return $tSelect;
//            
//        }
        
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
