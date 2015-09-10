<?php
class model_account extends abstract_model{
	
	protected $sClassRow='row_account';
	
	protected $sTable='account';
	protected $sConfig='benevoleOmss';
	
	protected $tId=array('idAccount');

	public static function getInstance(){
		return self::_getInstance(__CLASS__);
	}

	public function findById($uId){
		return $this->findOne('SELECT * FROM '.$this->sTable.' WHERE idAccount=?',$uId );
	}
        
        public function findByLogin($sLogin){
		return $this->findOne('SELECT * FROM '.$this->sTable.' WHERE login=?',$sLogin );
	}
        
	public function findAll(){
		return $this->findMany('SELECT * FROM '.$this->sTable);
	}
        
        public function findAllActive(){
		return $this->findMany('SELECT * FROM '.$this->sTable.' WHERE supprimer IS NULL');
	}
	
        public function getListAccount(){

            $tAccount=$this->findAll();
            $tLoginPassAccount=array();
            if($tAccount){
                foreach($tAccount as $oAccount){
                //on cree ici un tableau indexe par nom d'utilisateur et mot de passe
                  $tLoginPassAccount[$oAccount->login][$oAccount->pass]=$oAccount;
                }
            }
            return $tLoginPassAccount;
        }
   
   
        public function hashPassword($sPassword){
            //utiliser ici la methode de votre choix pour hasher votre mot de passe
            $salt = _root::getConfigVar('salt.authKey');
            return md5($salt.$sPassword);
        }
}

class row_account extends abstract_row{
	
	protected $sClassModel='model_account';
	
	/*exemple jointure 
	public function findAuteur(){
		return model_auteur::getInstance()->findById($this->auteur_id);
	}
	*/
	/*exemple test validation*/
	private function getCheck(){
		$oPluginValid=new plugin_valid($this->getTab());
                
                $oPluginValid->isNotEmpty('nomUser','Le champ ne doit pas &ecirc;tre vide');
                $oPluginValid->isNotEmpty('prenomUser','Le champ ne doit pas &ecirc;tre vide');
                $oPluginValid->isNotEmpty('emailUser','Le champ ne doit pas &ecirc;tre vide');
                $oPluginValid->isNotEmpty('pass','Vous devez remplir le mot de passe');
		$oPluginValid->isEmailValid('emailUser','L\'email est invalide');
                $oPluginValid->isStrLengthLowerOrEqualThan('pass',50,'Mot de passe trop long');
		$oPluginValid->isStrLengthUpperThan('pass',5,'Mot de passe trop petit');
		
            
                
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
