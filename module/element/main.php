<?php 
class module_element extends abstract_module{
	
	public function before(){
		$this->oLayout=new _layout('bootstrap');
		
		$this->oLayout->addModule('menu','menu::index');
	}
	
	
	public function _index(){
	    //on considere que la page par defaut est la page de listage
	    $this->_list();
	}
	
	
	public function _list(){
		
		$tElement=model_element::getInstance()->findAll();
		
		$oView=new _view('element::list');
		$oView->tElement=$tElement;
		
		
		
		$this->oLayout->add('main',$oView);
		 
	}

	
	
	public function _new(){
		$tMessage=$this->processSave();
	
		$oElement=new row_element;
		
		$oView=new _view('element::new');
		$oView->oElement=$oElement;
		
		
		
		$oPluginXsrf=new plugin_xsrf();
		$oView->token=$oPluginXsrf->getToken();
		$oView->tMessage=$tMessage;
		
		$this->oLayout->add('main',$oView);
	}

	
	
	public function _edit(){
		$tMessage=$this->processSave();
		
		$oElement=model_element::getInstance()->findById( _root::getParam('id') );
		
		$oView=new _view('element::edit');
		$oView->oElement=$oElement;
		$oView->tId=model_element::getInstance()->getIdTab();
		
		
		
		$oPluginXsrf=new plugin_xsrf();
		$oView->token=$oPluginXsrf->getToken();
		$oView->tMessage=$tMessage;
		
		$this->oLayout->add('main',$oView);
	}

	
	
	
	
	public function _delete(){
		$tMessage=$this->processDelete();

		$oElement=model_element::getInstance()->findById( _root::getParam('id') );
		
		$oView=new _view('element::delete');
		$oView->oElement=$oElement;
		
		

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
			$oElement=new row_element;	
		}else{
			$oElement=model_element::getInstance()->findById( _root::getParam('id',null) );
		}
		
		$tColumn=array('element','descElement');
		foreach($tColumn as $sColumn){
			$oElement->$sColumn=_root::getParam($sColumn,null) ;
		}
		
		
		if($oElement->save()){
			//une fois enregistre on redirige (vers la page liste)
			_root::redirect('element::list');
		}else{
			return $oElement->getListError();
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
	
		$oElement=model_element::getInstance()->findById( _root::getParam('id',null) );
				
		$oElement->delete();
		//une fois enregistre on redirige (vers la page liste)
		_root::redirect('element::list');
		
	}


	
	public function after(){
		$this->oLayout->show();
	}
	
	
}

