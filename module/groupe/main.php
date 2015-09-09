<?php 
class module_groupe extends abstract_module{
	
	public function before(){
		$this->oLayout=new _layout('bootstrap');
		
		$this->oLayout->addModule('menu','menu::index');
                if(!_root::getACL()->can('ACCESS','groupe::list')){
                    _root::redirect('default::index');
                }
	}
	
	
	public function _index(){
	    //on considere que la page par defaut est la page de listage
	    $this->_list();
	}
	
	
	public function _list(){
		
		$tGroupe=model_groupe::getInstance()->findAll();
		
		$oView=new _view('groupe::list');
		$oView->tGroupe=$tGroupe;
		
		
		
		$this->oLayout->add('main',$oView);
		 
	}

	
	
	public function _new(){
		$tMessage=$this->processSave();
	
		$oGroupe=new row_groupe;
		
		$oView=new _view('groupe::new');
		$oView->oGroupe=$oGroupe;
		
		
		
		$oPluginXsrf=new plugin_xsrf();
		$oView->token=$oPluginXsrf->getToken();
		$oView->tMessage=$tMessage;
		
		$this->oLayout->add('main',$oView);
	}

	
	
	public function _edit(){
		$tMessage=$this->processSave();
		
		$oGroupe=model_groupe::getInstance()->findById( _root::getParam('id') );
		
		$oView=new _view('groupe::edit');
		$oView->oGroupe=$oGroupe;
		$oView->tId=model_groupe::getInstance()->getIdTab();
		
		
		
		$oPluginXsrf=new plugin_xsrf();
		$oView->token=$oPluginXsrf->getToken();
		$oView->tMessage=$tMessage;
		
		$this->oLayout->add('main',$oView);
	}

	
	
	public function _show(){
		$oGroupe=model_groupe::getInstance()->findById( _root::getParam('id') );
		
		$oView=new _view('groupe::show');
		$oView->oGroupe=$oGroupe;
		
		
		$this->oLayout->add('main',$oView);
	}

	
	
	public function _delete(){
		$tMessage=$this->processDelete();

		$oGroupe=model_groupe::getInstance()->findById( _root::getParam('id') );
		
		$oView=new _view('groupe::delete');
		$oView->oGroupe=$oGroupe;
		
		

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
			$oGroupe=new row_groupe;	
		}else{
			$oGroupe=model_groupe::getInstance()->findById( _root::getParam('id',null) );
		}
		
		$tColumn=array('name');
		foreach($tColumn as $sColumn){
			$oGroupe->$sColumn=_root::getParam($sColumn,null) ;
		}
		
		
		if($oGroupe->save()){
			//une fois enregistre on redirige (vers la page liste)
			_root::redirect('groupe::list');
		}else{
			return $oGroupe->getListError();
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
	
		$oGroupe=model_groupe::getInstance()->findById( _root::getParam('id',null) );
				
		$oGroupe->delete();
		//une fois enregistre on redirige (vers la page liste)
		_root::redirect('groupe::list');
		
	}


	
	public function after(){
		$this->oLayout->show();
	}
	
	
}

