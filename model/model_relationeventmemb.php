<?php
class model_relationeventmemb extends abstract_model{
	
	protected $sClassRow='row_relationeventmemb';
	
	protected $sTable='relationeventmemb';
	protected $sConfig='benevoleOmss';
	
	protected $tId=array('idRelationEM');

	public static function getInstance(){
		return self::_getInstance(__CLASS__);
	}

        
        public function findIdMembreByIdEvent($uId){
		return $this->findMany('SELECT membre_id FROM '.$this->sTable.' WHERE event_id=?',$uId );
	}
        
        public function findIdEventByIdMembre($uId){
		return $this->findMany('SELECT event_id FROM '.$this->sTable.' WHERE membre_id=?',$uId );
	}
        
	public function findAll(){
		return $this->findMany('SELECT * FROM '.$this->sTable);
	}
	
	
	public function getSelectIdMembre($uId){
		$tab=$this->findIdMembreByIdEvent($uId);
		$tSelect=array();
		if($tab){
                    foreach($tab as $oRow){
                            $tSelect[ ]=$oRow->membre_id;
                    }
		}
		return $tSelect;
	}
        
        public function getSelectIdEvent($uId){
		$tab=$this->findIdEventByIdMembre($uId);
		$tSelect=array();
		if($tab){
                    foreach($tab as $oRow){
                            $tSelect[]=$oRow->event_id;
                    }
		}
		return $tSelect;
	}
        
        public function getListOfMembresByIdEvent($uId){
		$tab =  $this->findMany('SELECT nom, prenom, idMembre FROM omss.membres as M,'.$this->sTable.' as E WHERE E.event_id=? and M.idMembre = E.membre_id order by nom',$uId );                
                $tSelect=array();
		if($tab){
                    foreach($tab as $oRow){
                            $tSelect[]=$oRow->nom .' '. $oRow->prenom;
                    }
		}
		return $tSelect;
	}
        
        /**
         * Retourne un tableau contenant les personnes étant déclaré comme signaleur mais qui ne sont pas affecté à un évènement.
         * @return array
         */
        public function getListOfMembresDispo() {
            $tab = $this->findMany('SELECT * FROM omss.membres as M where NOT exists (select membre_id from '.$this->sTable.' where idmembre = membre_id) AND chkSignaleur = 1');
            $tSelect=array();
		if($tab){
                    foreach($tab as $oRow){
                            $tSelect[]=array('nom'=>$oRow->nom,'prenom'=>$oRow->prenom,'idMembre'=>$oRow->idMembre);
                    }
		}
		return $tSelect;
        }
        
        public function joinMemberEvent($idMembre,$idEvent){
        $this->unJoinMemberEvent($idMembre,$idEvent);
        
        $rowRelationeventmemb=new row_relationeventmemb;
        $rowRelationeventmemb->membre_id=$idMembre;
        $rowRelationeventmemb->event_id=$idEvent;
        $rowRelationeventmemb->save();
        
        }
        
        public function unJoinMemberEvent($idMembre,$idEvent){
            $this->execute('DELETE FROM '.$this->sTable.' WHERE membre_id=? AND event_id=?',$idMembre,$idEvent);
        }
        
}

class row_relationeventmemb extends abstract_row{
	
	protected $sClassModel='model_relationeventmemb';
	
	/*exemple jointure 
	public function findAuteur(){
		return model_auteur::getInstance()->findById($this->auteur_id);
	}
	*/
	/*exemple test validation*/
        
        
	private function getCheck(){
		$oPluginValid=new plugin_valid($this->getTab());
		
		
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

}
