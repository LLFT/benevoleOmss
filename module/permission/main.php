<?php 
class module_permission extends abstract_module{
	
	public function before(){
		$this->oLayout=new _layout('bootstrap');
		
		$this->oLayout->addModule('menu','menu::index');
                
                if(!_root::getACL()->can('ACCESS','permission::list')){
                    _root::redirect('default::index');
                }
	}
	
	
	public function _index(){
	    //on considere que la page par defaut est la page de listage
	    $this->_list();
	}
	
        public function _test(){
            
            
            $tPermission=model_permission::getInstance()->findAll();
            $tPermissionDistinct=model_permission::getInstance()->findDistinctElement();
            $tJoinmodel_groupe=model_groupe::getInstance()->getSelect();
            $tModule=array();
            
            $oDir=new _dir('../module');
            //recuperation liste objet repertoires
            $tDir=$oDir->getListDir();
            foreach($tDir as $oDirModule){
                    $tMethodes=array();
                    //on deduit le nom du module
                    $sModuleName= 'module_'.$oDirModule->getName();

                    //on exclue le/les modules que l'on veut ignorer
                    if(in_array($sModuleName,array('module_pagination'))){
                            continue;
                    }                    
                    if(in_array($sModuleName,array('module_googleMap'))){
                            continue;
                    }                    
                    if(in_array($sModuleName,array('module_menu'))){
                            continue;
                    }
                    if(in_array($sModuleName,array('module_default'))){
                            continue;
                    }
                    if(in_array($sModuleName,array('module_auth'))){
                            continue;
                    }
                    $sNameModule = substr($sModuleName,7);
                    //on instancie
                    $oModule=new $sModuleName();
                    //on demande la liste des methodes public			
                    $tMethods=get_class_methods($oModule);                    
                    foreach($tMethods as $sMethod){
                            //on exclue les methodes __get, __set
                            if(substr($sMethod,0,2)=='__'){ continue ; }

                            //on garde que les methodes commencant par _ (signe des actions) 
                            if(substr($sMethod,0,1)!='_'){ continue ; }
                        
                            $tMethodes[]=$sNameModule.'::'.substr($sMethod,1);
                    }
                    $tModule[$sModuleName]=$tMethodes;                    
            }


            
            
            $oView=new _view('permission::test');
            $oView->tModule=$tModule;
            $oView->tPermission=$tPermission;
            $oView->tPermissionDistinct=$tPermissionDistinct;
            $oView->tJoinmodel_groupe=$tJoinmodel_groupe;
                        plugin_debug::addSpy('list', $tPermission);
            $this->oLayout->add('main',$oView);
            
        }
	
	public function _list(){
            
            
		$tPermission=model_permission::getInstance()->findAll();
		
		$oView=new _view('permission::list');
		$oView->tPermission=$tPermission;
		
		$oView->tJoinmodel_groupe=model_groupe::getInstance()->getSelect();
                
		
		$this->oLayout->add('main',$oView);
                
                
                
                
		 
	}

	
	
	public function _new(){
		$tMessage=$this->processSave();
	
		$oPermission=new row_permission;
		
		$oView=new _view('permission::new');
		$oView->oPermission=$oPermission;
		$oView->tJoinmodel_groupe=model_groupe::getInstance()->getSelect();
                $oView->tJoinmodel_element=model_element::getInstance()->getSelect();
                $oView->tAllowDeny= array('DENY'=>'Interdire','ALLOW'=>'Authoriser');
		
		
		$oPluginXsrf=new plugin_xsrf();
		$oView->token=$oPluginXsrf->getToken();
		$oView->tMessage=$tMessage;
		
		$this->oLayout->add('main',$oView);
	}

	
	
	public function _edit(){
		$tMessage=$this->processSave();
		
		$oPermission=model_permission::getInstance()->findById( _root::getParam('id') );
		
		$oView=new _view('permission::edit');
		$oView->oPermission=$oPermission;
		$oView->tId=model_permission::getInstance()->getIdTab();
		$oView->tJoinmodel_groupe=model_groupe::getInstance()->getSelect();
                $oView->tJoinmodel_element=model_element::getInstance()->getSelect();
                $oView->tAllowDeny=  array('DENY'=>'Interdire','ALLOW'=>'Authoriser');
		
		
		$oPluginXsrf=new plugin_xsrf();
		$oView->token=$oPluginXsrf->getToken();
		$oView->tMessage=$tMessage;
		
		$this->oLayout->add('main',$oView);
	}

	
	
	public function _show(){
		$oPermission=model_permission::getInstance()->findById( _root::getParam('id') );
		
		$oView=new _view('permission::show');
		$oView->oPermission=$oPermission;
		
		
		$this->oLayout->add('main',$oView);
	}

	
	
	public function _delete(){
		$tMessage=$this->processDelete();

		$oPermission=model_permission::getInstance()->findById( _root::getParam('id') );
		
		$oView=new _view('permission::delete');
		$oView->oPermission=$oPermission;
		
		

		$oPluginXsrf=new plugin_xsrf();
		$oView->token=$oPluginXsrf->getToken();
		$oView->tMessage=$tMessage;
		
		$this->oLayout->add('main',$oView);
	}


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
			$oPermission=new row_permission;	
		}else{
			$oPermission=model_permission::getInstance()->findById( _root::getParam('id',null) );
		}
		
		$tColumn=array('action','element','allowdeny','groupe_id');
		foreach($tColumn as $sColumn){
                    switch ($sColumn){ 
                        case 'action':
                            $oPermission->$sColumn= strtoupper(_root::getParam($sColumn,null));
                            break;
                        case 'allowdeny':
                            $oPermission->$sColumn= strtoupper(_root::getParam($sColumn,null));
                            break;
                        default :    
                            $oPermission->$sColumn=_root::getParam($sColumn,null) ;
                        }
                }
		
		
		if($oPermission->save()){
			//une fois enregistre on redirige (vers la page liste)
			_root::redirect('permission::list');
		}else{
			return $oPermission->getListError();
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
	
		$oPermission=model_permission::getInstance()->findById( _root::getParam('id',null) );
				
		$oPermission->delete();
		//une fois enregistre on redirige (vers la page liste)
		_root::redirect('permission::list');
		
	}


	
	public function after(){
		$this->oLayout->show();
	}
	
	
}

