<?php
class module_auth extends abstract_module{
	
	//longueur maximum du mot de passe
	private $maxPasswordLength=80;
        private $maxLoginEchec=5;
	
	public function before(){
		//on active l'authentification
		_root::getAuth()->enable();

		$this->oLayout=new _layout('bootstrap');
	}

	public function _login(){
		
		$sMessage=$this->checkLoginPass();
		
		$oView=new _view('auth::login');
		$oView->sError=$sMessage;

		$this->oLayout->add('main',$oView);

	}
	private function checkLoginPass(){
            
           
		//si le formulaire n'est pas envoye on s'arrete la
		if(!_root::getRequest()->isPost() ){
			return null;
		}
		
		$sLogin=strtolower(_root::getParam('login'));
		$sPassword=_root::getParam('password');
		
                
		if(strlen($sPassword) > $this->maxPasswordLength){
			return 'Mot de passe trop long';
		}
		
		//on stoque les mots de passe hashe dans la classe model_account
		$sHashPassword=model_account::getInstance()->hashPassword($sPassword);
		$tAccount=model_account::getInstance()->getListAccount();
		
		//on va verifier que l'on trouve dans le tableau retourne par notre model
		//l'entree $tAccount[ login ][ mot de passe hashe ]
		if(!_root::getAuth()->checkLoginPass($tAccount,$sLogin,$sHashPassword)){
                    
                    if(_root::getAuth()->verifLoginError($tAccount,$sLogin,$this->maxLoginEchec)){
                        return 'Compte Bloqué';                            
                    }
			
                        return 'Mauvais login/mot de passe';
		}
		
                
                if(!_root::getAuth()->verifLoginActiv($sLogin)){
                    return 'Compte Bloqué';
                }    
                
                $oAccount=_root::getAuth()->getAccount();
                //recuperation de la liste de ses permissions
                $tPermission=model_permission::getInstance()->findByGroup($oAccount->groupe_id);

                //on purge les permissions en session
                _root::getACL()->purge();

                //Au moment d'autentifier votre utilisateur, vous allez chercher sa liste de permissions
                //boucle sur les permissions
                if($tPermission){
                    foreach($tPermission as $oPermission){
                        if($oPermission->allowdeny=='ALLOW'){
                           _root::getACL()->allow($oPermission->action,$oPermission->element);
                        }else{
                           _root::getACL()->deny($oPermission->action,$oPermission->element);
                        }
                        
                    }
                }
                _root::redirect('default::index');
        }

	public function _logout(){
		_root::getAuth()->logout();
	}

	public function after(){
            // Lancement des actions automatisés en fin de session
                $autoAction = new my_BackAction();
                $autoAction->listInfoMember();
                $autoAction->listEventArchi();
		$this->oLayout->show();
	}
}
