<?php 
class module_events extends abstract_module{
	
	public function before(){
		$this->oLayout=new _layout('bootstrap');
		
		$this->oLayout->addModule('menu','menu::index');
	}
	
	
//	public function _index(){
//	    //on considere que la page par defaut est la page de listage
//	    $this->_list();
//	}
//	
	
	public function _list(){
            
            if(!_root::getACL()->can('ACCESS','events::list')){
                    _root::redirect('default::index');
                }
		
            switch (_root::getParam('action')){
                case 'archiv':
                    $oEvents=model_events::getInstance()->findAllArchive();
                    break;
                default :
                    $oEvents=model_events::getInstance()->findAllActif();
            }
		
		
		$oView=new _view('events::list');
		$oView->oEvents=$oEvents;
		
		
		
		$this->oLayout->add('main',$oView);
		 
	}

	
	
	public function _new(){
            if(!_root::getACL()->can('ACCESS','events::new')){
                    _root::redirect('default::index');
                }
		$tMessage=$this->processSave();
	
		$oEvents=new row_events;
		
		$oView=new _view('events::new');
		$oView->oEvents=$oEvents;
		
		
		
		$oPluginXsrf=new plugin_xsrf();
		$oView->token=$oPluginXsrf->getToken();
		$oView->tMessage=$tMessage;
		
		$this->oLayout->add('main',$oView);
	}

	
	
	public function _edit(){
            if(!_root::getACL()->can('ACCESS','events::edit')){
                    _root::redirect('default::index');
                }
		$tMessage=$this->processSave();
		
		$oEvents=model_events::getInstance()->findById( _root::getParam('id') );

		$oView=new _view('events::edit');
		$oView->oEvents=$oEvents;
		$oView->tId=model_events::getInstance()->getIdTab();
					
		$oPluginXsrf=new plugin_xsrf();
		$oView->token=$oPluginXsrf->getToken();
		$oView->tMessage=$tMessage;
		
		$this->oLayout->add('main',$oView);
	}

	
	
	public function _show(){
            if(!_root::getACL()->can('ACCESS','events::show')){
                    _root::redirect('default::index');
                }
		$oEvents=model_events::getInstance()->findById( _root::getParam('id') );
                $oParcours=model_parcours::getInstance()->findOneParcour(_root::getParam('id'));
                $tListDesParticipants=  model_relationeventmemb::getInstance()->getListOfMembresByIdEvent(_root::getParam('id'));
                $oListBenevolesDispo= model_relationeventmemb::getInstance()->getListOfMembresDispo();
                
		$oView=new _view('events::show');
		$oView->oEvents=$oEvents;
		$oView->oParcours=$oParcours;
                $oView->tListeDesParticipants=$tListDesParticipants;
		$oView->oListBenevolesDispo = $oListBenevolesDispo;
		$this->oLayout->add('main',$oView);
	}

	public function _exportCSV() {
            if(!_root::getACL()->can('ACCESS','events::exportCSV')){
                    _root::redirect('default::index');
                }
            $sDate=  date('dmy');
            $sFileName ="";
            $idEvent = _root::getParam('idEvent');
            $nomEvent = _root::getParam('nomEvent');
            $tMembres=model_membres::getInstance()->findParticipantOfEvent($idEvent);
            $sFileName = 'ExportSignaleurs_'.$nomEvent.'_'.$sDate.'.csv';
            
            $oView=new _view('membres::exportCSV');
            $oView->tMembres=$tMembres;
            
            $this->oLayout->add('main',$oView);
            $this->oLayout->setLayout('export');
            $this->oLayout->sFileName=$sFileName;
            $this->oLayout->sExtension='csv';

            $this->oLayout->show();
            exit;
        }
        
        
	public function _archiver(){
            if(!_root::getACL()->can('ACCESS','events::archiver')){
                    _root::redirect('default::index');
                }
		$tMessage=$this->processArchivage();

		$oEvents=model_events::getInstance()->findById( _root::getParam('id') );
		
		$oView=new _view('events::archiver');
		$oView->oEvents=$oEvents;
		
		

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
			$oEvents=new row_events;
                        $oEvents->creer=date('Y-m-d H:i:s',time());
                        $oEvents->owner=_root::getAuth()->getAccount()->idAccount;
                        $oEvents->active=1;
		}else{
			$oEvents=model_events::getInstance()->findById( _root::getParam('id',null) );
                        $oEvents->modifier=date('Y-m-d H:i:s',time());
                        $oEvents->owner=_root::getAuth()->getAccount()->idAccount;
		}
		
		$tColumn=array('nomEvent','date','lieux','description');
                
		foreach($tColumn as $sColumn){
			$oEvents->$sColumn=_root::getParam($sColumn,null) ;
		}
		
		
		if($oEvents->save()){
			//une fois enregistre on redirige (vers la page liste)
			_root::redirect('events::list');
		}else{
			return $oEvents->getListError();
		}
		
	}
	
	
	public function processArchivage(){
		if(!_root::getRequest()->isPost() ){ //si ce n'est pas une requete POST on ne soumet pas
			return null;
		}
		
		$oPluginXsrf=new plugin_xsrf();
		if(!$oPluginXsrf->checkToken( _root::getParam('token') ) ){ //on verifie que le token est valide
			return array('token'=>$oPluginXsrf->getMessage() );
		}
	
		$oEvents=model_events::getInstance()->findById( _root::getParam('id',null) );
                $oEvents->active=0;
                $oEvents->supprimer=date('Y-m-d H:i:s',time());
                $oEvents->owner=_root::getAuth()->getAccount()->idAccount;
		$oEvents->save();
		//une fois enregistre on redirige (vers la page liste)
		_root::redirect('events::list');
		
	}


	
	public function after(){
		$this->oLayout->show();
	}
	
	
}

