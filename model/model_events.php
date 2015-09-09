<?php
class model_events extends abstract_model{
	
	protected $sClassRow='row_events';
	
	protected $sTable='events';
	protected $sConfig='benevoleOmss';
	
	protected $tId=array('idEvent');

	public static function getInstance(){
		return self::_getInstance(__CLASS__);
	}

	public function findById($uId){
		return $this->findOne('SELECT * FROM '.$this->sTable.' WHERE idEvent=?',$uId );
	}
	public function findAll(){
		return $this->findMany('SELECT * FROM '.$this->sTable);
	}
	
	
	public function getSelect(){
		$tab=$this->findAll();
		$tSelect=array();
		if($tab){
		foreach($tab as $oRow){
			$tSelect[ $oRow->idEvent ]=$oRow->nomEvent;
		}
		}
		return $tSelect;
	}
	

	
}

class row_events extends abstract_row{
	
	protected $sClassModel='model_events';
	
	/*exemple jointure 
	public function findAuteur(){
		return model_auteur::getInstance()->findById($this->auteur_id);
	}
	*/
	/*exemple test validation*/
        
        public function __construct($tRow=null){
            
            parent::__construct($tRow);
            
            //on modifie le champ date avant d'initialiser l'objet
            
            if (is_null($tRow['date'])){
                $tRow['date'] = date('Y-m-d',  time ());
            }
            $oDate = new plugin_date($tRow['date'],'Y-m-d');
            $tRow['date'] = $oDate->toString('d/m/Y');           
        }
        
        
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
                
                //on formate à la volée la date
                
                $oDate = new plugin_date($this->date,'d/m/Y');
                $this->date = $oDate->toString('Y-m-d');
               
		parent::save();
		return true;
	}

}
