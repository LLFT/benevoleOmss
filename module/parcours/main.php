<?php 
class module_parcours extends abstract_module{
	
	public function before(){
		$this->oLayout=new _layout('bootstrap');
		
		$this->oLayout->addModule('menu','menu::index');
	}
	
	
	public function _index(){
	    //on considere que la page par defaut est la page de listage
	    $this->_list();
	}
	
	
	public function _list(){
		
		$tParcours=model_parcours::getInstance()->findAll();
                $oEvents=model_events::getInstance()->getSelect();
                
		
		$oView=new _view('parcours::list');
		$oView->tParcours=$tParcours;
                $oView->tJoinmodelEvents=$oEvents;
		
		
		
		$this->oLayout->add('main',$oView);
		 
	}

	
	
	public function _new(){
		$tMessage=$this->processSave();
	
		$oParcours=new row_parcours;
		
		$oView=new _view('parcours::new');
		$oView->oParcours=$oParcours;
		
		
		
		$oPluginXsrf=new plugin_xsrf();
		$oView->token=$oPluginXsrf->getToken();
		$oView->tMessage=$tMessage;
		
		$this->oLayout->add('main',$oView);
	}

	
	
	
	
	public function _show(){
		$oParcours=model_parcours::getInstance()->findById( _root::getParam('id') );
		
		$oView=new _view('parcours::show');
		$oView->oParcours=$oParcours;
                
                $oModuleGoogleMap=new module_googleMap();
                $oModuleGoogleMap->setWidth(800);
                $oModuleGoogleMap->setHeight(500);
                $oModuleGoogleMap->setZoom(15);
                $oModuleGoogleMap->setMinZoom(12); //Zoom Arriere
                $oModuleGoogleMap->setEnableZoomControl('true');
                $oModuleGoogleMap->setEnableScrollwheel('true');
                $oModuleGoogleMap->setDisableDoubleClickZoom('false');
                $oModuleGoogleMap->setTraceGPX(true);
                $oModuleGoogleMap->setUrlTraceGPX($oParcours->url);
                $oView->oModuleGoogleMap=$oModuleGoogleMap->getMap(); 	          
		
		
		$this->oLayout->add('main',$oView);
	}

	
	
	public function _delete(){
		$tMessage=$this->processDelete();

		$oParcours=model_parcours::getInstance()->findById( _root::getParam('id') );
		$oEvents=model_events::getInstance()->findById( _root::getParam('idEvent') );
                
		$oView=new _view('parcours::delete');
		$oView->oParcours=$oParcours;
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
			$oParcours=new row_parcours;	
		}else{
			$oParcours=model_parcours::getInstance()->findById( _root::getParam('id',null) );
		}
		
		$tColumn=array('label');
		foreach($tColumn as $sColumn){
			$oParcours->$sColumn=_root::getParam($sColumn,null) ;
		}
		//On déclare le name des champs d'upload
		$tColumnUpload=array('url');
                
		if($tColumnUpload){
                    
                    foreach($tColumnUpload as $sColumnUpload){
                        $oPluginUpload=new plugin_upload($sColumnUpload);
                        //On vérifier que l'upload est bien réel
                        if($oPluginUpload->isValid()){
                            //calculer le checksum du fichier
                            $checksum=md5_file($oPluginUpload->getTmpPath());
                            //Comparer le checksum avec ceux déjà connu. retour une somme 
                            $tNbChecksum=model_parcours::getInstance()->findByCheckSum($checksum);
                            //Fichier GPX sauvegardé si inconnu.
                            if ($tNbChecksum->NbCheckSum < 1){
                                $sNewFileName=_root::getConfigVar('path.uploadGPX').$sColumnUpload.'_'.date('Ymdhis');
                                $oPluginUpload->saveAs($sNewFileName);
                                $oParcours->checksum=$checksum;  
                                $oParcours->event_id=_root::getParam('idEvent');
                                $oParcours->$sColumnUpload=$oPluginUpload->getPath();
                            }else{
                                return array('url' => array('Ce fichier a déjà enregistré dans nos bases sous le label : '.$tNbChecksum->label.'.'));
                            }
                        }
                        else {
                            return array('url' => array('Fichier non conforme aux attentes.'));
                        }
                    }
		}

		
		if($oParcours->save()){
			//une fois enregistre on redirige vers la page de l'évènement associé.
			_root::redirect('events::show',array("id"=>_root::getParam('idEvent')));
		}else{
			return $oParcours->getListError();
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
	
		$oParcours=model_parcours::getInstance()->findById( _root::getParam('id',null) );
                //On Supprime le Fichier GPX du dossier Upload si il est encore présent.
                if (file_exists($oParcours->url)){
                        unlink($oParcours->url);                   
                }
                                    
		$oParcours->delete();
		//une fois enregistre on redirige (vers la page liste)
		_root::redirect('events::show',array('id'=>_root::getParam('idEvent')));
		
	}


	
	public function after(){
		$this->oLayout->show();
	}
	
	
}

