<?php 
class module_permission extends abstract_module{
	
	public function before(){
		$this->oLayout=new _layout('bootstrap');
		
		$this->oLayout->addModule('menu','menu::index');
                
                if(!_root::getACL()->can('ACCESS','permission::list')){
                    _root::redirect('default::index');
                }
	}
	
	public function _list(){
            $oPermission=model_permission::getInstance()->findAll();
            $oPermissionDistinct=model_permission::getInstance()->findDistinctElement();
            $tJoinmodel_groupe=model_groupe::getInstance()->getSelect();
            $tPermissionDistinct=model_permission::getInstance()->getSelectDistinctElement();
            $tExclusion=array('module_pagination','module_googleMap','module_menu','module_default','module_auth');
            $tModule=  _root::getModuleList($tExclusion);
           
            
            $oView=new _view('permission::list');
            $oView->tModule=$tModule;
            $oView->oPermission=$oPermission;
            $oView->oPermissionDistinct=$oPermissionDistinct;
            $oView->tPermissionDistinct=$tPermissionDistinct;
            
            $oView->tJoinmodel_groupe=$tJoinmodel_groupe;
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

