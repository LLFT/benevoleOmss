<?php
class model_parcours extends abstract_model{
	
	protected $sClassRow='row_parcours';
	
	protected $sTable='parcours';
	protected $sConfig='benevoleOmss';
	
	protected $tId=array('id');

	public static function getInstance(){
		return self::_getInstance(__CLASS__);
	}

	public function findById($uId){
		return $this->findOne('SELECT * FROM '.$this->sTable.' WHERE idParcours=?',$uId );
	}
	public function findAll(){
		return $this->findMany('SELECT * FROM '.$this->sTable.' WHERE event_id is not null');
	}
        
        public function findOneParcour($iIdEvent){
		return $this->findMany('SELECT * FROM '.$this->sTable.' WHERE event_id=?',$iIdEvent);
	}
	
	public function findByCheckSum($checksum){
		return $this->findOne('SELECT count(*) AS NbCheckSum, label FROM '.$this->sTable.' WHERE checksum=?',$checksum );
	}
	
}

class row_parcours extends abstract_row{
	
	protected $sClassModel='model_parcours';
	
	/*exemple jointure 
	public function findAuteur(){
		return model_auteur::getInstance()->findById($this->auteur_id);
	}
	*/
	/*exemple test validation*/
	private function getCheck(){
		$oPluginValid=new plugin_valid($this->getTab());
		$oPluginValid->isNotEmpty('label','Le champ ne doit pas &ecirc;tre vide');
		$oPluginValid->isNotEmpty('url','Un fichier GPX doit être joint');
                
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
                $this->label = strtoupper($this->label);
		parent::save();
		return true;
	}

}
