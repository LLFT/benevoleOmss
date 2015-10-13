<?php 
class module_account extends abstract_module{
	
	public function before(){
		$this->oLayout=new _layout('bootstrap');
		
		$this->oLayout->addModule('menu','menu::index');
                
                
	}
	
//	
//	public function _index(){
//	    //on considere que la page par defaut est la page de listage
//	    $this->_list();
//	}
	
	
	public function _list(){
                if(!_root::getACL()->can('ACCESS','account::list')){
                    _root::redirect('default::index');
                }
		
		$tAccount=model_account::getInstance()->findAllActive();
		
		$oView=new _view('account::list');
		$oView->tAccount=$tAccount;
		$oView->tJoinmodel_groupe=model_groupe::getInstance()->getSelect();
		
	/*	
		$oModulePagination=new module_pagination;
		$oModulePagination->setModuleAction('account::list');
		$oModulePagination->setParamPage('page');
		$oModulePagination->setLimit(5);
		$oModulePagination->setPage( _root::getParam('page') );
		$oModulePagination->setTab( $tAccount );
		
		$oView->tAccount=$oModulePagination->getPageElement();
	*/	
		$this->oLayout->add('main',$oView);
		
		
	//	$oViewPagination=$oModulePagination->build();
		
	//	$this->oLayout->add('main',$oViewPagination);
		 
	}

	
	
	public function _new(){
                if(!_root::getACL()->can('ACCESS','account::new')){
                    _root::redirect('default::index');
                }
		$tMessage=$this->processSave();
	
		$oAccount=new row_account;
		
		$oView=new _view('account::new');
		$oView->oAccount=$oAccount;
		
		$oView->tJoinmodel_groupe=model_groupe::getInstance()->getSelect();
		
		$oPluginXsrf=new plugin_xsrf();
		$oView->token=$oPluginXsrf->getToken();
		$oView->tMessage=$tMessage;
		
		$this->oLayout->add('main',$oView);
	}

	
	
	public function _edit(){
                if(!_root::getACL()->can('ACCESS','account::edit')){
                    _root::redirect('default::index');
                }
		$tMessage=$this->processSave();
		
		$oAccount=model_account::getInstance()->findById( _root::getParam('id') );
		
		$oView=new _view('account::edit');
		$oView->oAccount=$oAccount;
		$oView->tId=model_account::getInstance()->getIdTab();
		
		$oView->tJoinmodel_groupe=model_groupe::getInstance()->getSelect();
		
		$oPluginXsrf=new plugin_xsrf();
		$oView->token=$oPluginXsrf->getToken();
		$oView->tMessage=$tMessage;
		
		$this->oLayout->add('main',$oView);
	}

	
	
	public function _show(){
                if(!_root::getACL()->can('ACCESS','account::show')){
                    _root::redirect('default::index');
                }
		$oAccount=model_account::getInstance()->findById( _root::getParam('id') );
		
		$oView=new _view('account::show');
		$oView->oAccount=$oAccount;
		
		
		$this->oLayout->add('main',$oView);
	}

	
	
	public function _delete(){
                if(!_root::getACL()->can('ACCESS','account::delete')){
                    _root::redirect('default::index');
                }
		$tMessage=$this->processDelete();

		$oAccount=model_account::getInstance()->findById( _root::getParam('id') );
		
		$oView=new _view('account::delete');
		$oView->oAccount=$oAccount;
		
		

		$oPluginXsrf=new plugin_xsrf();
		$oView->token=$oPluginXsrf->getToken();
		$oView->tMessage=$tMessage;
		
		$this->oLayout->add('main',$oView);
	}

/*        
	private function processSaveEdit(){
		if(!_root::getRequest()->isPost() ){ //si ce n'est pas une requete POST on ne soumet pas
			return null;
		}
                
		$oPluginXsrf=new plugin_xsrf();
		if(!$oPluginXsrf->checkToken( _root::getParam('token') ) ){ //on verifie que le token est valide
			return array('token'=>$oPluginXsrf->getMessage() );
		}
	
		$oAccount=model_account::getInstance()->findById( _root::getParam('id',null) );                        
				
                $tColumn=array('nomUser','prenomUser','pass','emailUser');
                foreach($tColumn as $sColumn){                       
                     switch ($sColumn) {
                         case 'nomUser':
                             $oAccount->$sColumn=  strtoupper(_root::getParam($sColumn,null));
                             break;
                         case 'prenomUser':
                             $oAccount->$sColumn=  strtoupper(_root::getParam($sColumn,null))[0].substr(_root::getParam($sColumn,null),1);
                             break;
                         default :
                              $oAccount->$sColumn=_root::getParam($sColumn,null) ;
                     }                       

                 }               
                  
		if($oAccount->save()){
			//une fois enregistre on redirige (vers la page liste)
			_root::redirect('account::list');
		}else{
                    return $oAccount->getListError();
		}
		
	}
*/	
	

	private function processSave(){
		if(!_root::getRequest()->isPost() ){ //si ce n'est pas une requete POST on ne soumet pas
			return null;
		}
                
                $oPluginXsrf=new plugin_xsrf();
		if(!$oPluginXsrf->checkToken( _root::getParam('token') ) ){ //on verifie que le token est valide
			return array('token'=>$oPluginXsrf->getMessage() );
		}
                
                $iId=_root::getParam('id',null);
                
                
		if($iId==null){
                    //Nouveau compte 
                    $oAccount=new row_account;                        
                    $oAccountByLogin=model_account::getInstance()->findByLogin(_root::getParam('login'));
                    if(_root::getParam('pass')!=_root::getParam('pass2')){
                            return array('pass'=>'Les deux mots de passe doivent &ecirc;tre identiques');
                    }elseif(_root::getParam('login')==''){
                            return array('login'=>'Vous devez remplir le nom d\'utilisateur');
                    }elseif(isset($oAccountByLogin) ){
                            return array('login'=> 'Utilisateur d&eacute;j&agrave; existant');
                    }
                    $oAccount->login= strtolower(_root::getParam('login',null));
                    if (strlen(_root::getParam('pass'))<=5){
                        return array('pass'=> 'Mot de passe trop petit');
                    }
                    if (strlen(_root::getParam('pass'))>=50){
                        return array('pass'=> 'Mot de passe trop long'); 
                    }                        
                        $oAccount->pass=model_account::getInstance()->hashPassword(_root::getParam('pass'));
                        $oAccount->creer=date('Y-m-d H:i:s',time());

                        
                }  else {
                    // Compte existant
                    $oAccount=model_account::getInstance()->findById( $iId );
                    if(!empty(_root::getParam('pass'))){
                        if (strlen(_root::getParam('pass'))<=5){
                            return array('pass'=> 'Mot de passe trop petit');
                        }
                        if (strlen(_root::getParam('pass'))>=50){
                            return array('pass'=> 'Mot de passe trop long'); 
                        }                        
                        $oAccount->pass=model_account::getInstance()->hashPassword(_root::getParam('pass'));
                    }

                    if (_root::getParam('active') !='1'){
                        $oAccount->active=0;     
                    }  else {
                        
                        $oAccount->active=1;
                    }
                   
                    $oAccount->modifier=date('Y-m-d H:i:s',time());
                }
                              
                
                $tColumn=array('nomUser','prenomUser','emailUser','groupe_id');
                   foreach($tColumn as $sColumn){                       
                        switch ($sColumn) {
                            case 'nomUser':
                                $oAccount->$sColumn=  strtoupper(_root::getParam($sColumn,null));
                                break;
                            case 'prenomUser':
                                $oAccount->$sColumn=  strtoupper(_root::getParam($sColumn,null))[0].substr(strtolower(_root::getParam($sColumn,null)),1);
                                break;
                            default :
                                 $oAccount->$sColumn=_root::getParam($sColumn,null) ;
                        }                       

                    }
                
                if($oAccount->save()){
			//une fois enregistre on redirige (vers la page liste)
			_root::redirect('account::list');
		}else{
                    return $oAccount->getListError();
		}
		
	}
	
	
	public function processDelete(){
		if(!_root::getRequest()->isPost() ){ //si ce n'est pas une requete POST on ne soumet pas
			return null;
		}
		
		$oPluginXsrf=new plugin_xsrf();
		if(!$oPluginXsrf->checkToken( _root::getParam('token') ) ){ //on verifie que le token est valide
			return array('token'=>$oPluginXsrf->getMessage() );
		}
	
		$oAccount=model_account::getInstance()->findById( _root::getParam('id',null) );
				
		$oAccount->active=0;
                $oAccount->supprimer=date('Y-m-d H:i:s',time());
                $oAccount->save();
		//une fois enregistre on redirige (vers la page liste)
		_root::redirect('account::list');
		
	}


	
	public function after(){
		$this->oLayout->show();
	}
	
	
}

