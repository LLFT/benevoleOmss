<?php 
class module_membres extends abstract_module{
	
	public function before(){
		$this->oLayout=new _layout('bootstrap');
		
		$this->oLayout->addModule('menu','menu::index');
                
                if(!_root::getACL()->can('ACCESS','membres::list')){
                    _root::redirect('default::index');
                }
                
//                if(!_root::getACL()->can('ACCESS','membres::listEmptyAdress')){
//                    _root::redirect('default::index');
//                }
//                
//                if(!_root::getACL()->can('ACCESS','membres::listEmptyPermis')){
//                    _root::redirect('default::index');
//                }
                
	}
	
	
	public function _index(){
	    //on considere que la page par defaut est la page de listage
	    $this->_list();
	}
	
        
        public function _list(){
            
            
            //Liste de tous les Membres
            $tAllMembres=model_membres::getInstance()->findAll();
            
            $tDistinctLetters=model_membres::getInstance()->findDistinctLetters($tAllMembres);
            if (null !==_root::getParam('letter')){
                //Une lettre à été choisie dans la pagination
               $sCurrentLetter = _root::getParam('letter');
            }else{
                // Aucun lettre de choisie. Donc on prends la première.
               $sCurrentLetter = $tDistinctLetters[0]; 
            }
            
            //Liste des Membres en focntion de la lettre choisie
            $tMembres=model_membres::getInstance()->findAll($sCurrentLetter);
            //Préparation de la Pagination Alphabétique
            $oModulePagination=new module_pagination;
            $oModulePagination->setModuleAction('membres::list');
            $oModulePagination->setParamPage('letter');
            $oModulePagination->setDistinctLetters($tDistinctLetters);            
            $oModulePagination->setCurrentLetter($sCurrentLetter);
            
            //Préparation de la vue
           
            $oView=new _view('membres::list');
            $oView->sAction="Full";
            $oView->oModulePagination=$oModulePagination->buildAlpha();
            $oView->tMembres=$tMembres; 
            $this->oLayout->add('main',$oView);
         
        }
                
        public function _listEmptyAdress(){
		
            $tAllMembres=model_membres::getInstance()->findAllEmptyAdress();
            $tDistinctLetters=model_membres::getInstance()->findDistinctLetters($tAllMembres);
            if (null !==_root::getParam('letter')){
               $sCurrentLetter = _root::getParam('letter');
            }else{
               $sCurrentLetter = $tDistinctLetters[0]; 
            }
            //Liste des Membres en focntion de la lettre choisie
            $tMembres=model_membres::getInstance()->findAllEmptyAdress($sCurrentLetter);
            //Préparation de la Pagination Alphabétique
            $oModulePagination=new module_pagination;
            $oModulePagination->setModuleAction('membres::listEmptyAdress');
            $oModulePagination->setParamPage('letter');
            $oModulePagination->setDistinctLetters($tDistinctLetters);            
            $oModulePagination->setCurrentLetter($sCurrentLetter);
            
            //Préparation de la vue
  
            $oView=new _view('membres::list');
            $oView->sAction="EmptyAdress";
            $oView->oModulePagination=$oModulePagination->buildAlpha();
            $oView->tMembres=$tMembres;		
            $this->oLayout->add('main',$oView);
		 
	}

        public function _listEmptyMail(){
            
            $tAllMembres=model_membres::getInstance()->findAllEmptyMail();
            $tDistinctLetters=model_membres::getInstance()->findDistinctLetters($tAllMembres);
            if (null !==_root::getParam('letter')){
               $sCurrentLetter = _root::getParam('letter');
            }else{
               $sCurrentLetter = $tDistinctLetters[0]; 
            }
		
            $tMembres=model_membres::getInstance()->findAllEmptyMail($sCurrentLetter);
            //Préparation de la Pagination Alphabétique
            $oModulePagination=new module_pagination;
            $oModulePagination->setModuleAction('membres::listEmptyMail');
            $oModulePagination->setParamPage('letter');
            $oModulePagination->setDistinctLetters($tDistinctLetters);            
            $oModulePagination->setCurrentLetter($sCurrentLetter);
            
            //Préparation de la vue
  
            $oView=new _view('membres::list');
            $oView->sAction="EmptyMail";
            $oView->oModulePagination=$oModulePagination->buildAlpha();
            $oView->tMembres=$tMembres;
            $this->oLayout->add('main',$oView);
		 
	}	
        
        public function _listEmptyPermis(){
	    $tAllMembres=model_membres::getInstance()->findAllEmptyPermis();
            $tDistinctLetters=model_membres::getInstance()->findDistinctLetters($tAllMembres);
            if (null !==_root::getParam('letter')){
               $sCurrentLetter = _root::getParam('letter');
            }else{
               $sCurrentLetter = $tDistinctLetters[0]; 
            }
            $tMembres=model_membres::getInstance()->findAllEmptyPermis($sCurrentLetter);
            //Préparation de la Pagination Alphabétique
            $oModulePagination=new module_pagination;
            $oModulePagination->setModuleAction('membres::listEmptyPermis');
            $oModulePagination->setParamPage('letter');
            $oModulePagination->setDistinctLetters($tDistinctLetters);            
            $oModulePagination->setCurrentLetter($sCurrentLetter);
            
            //Préparation de la vue
  
            $oView=new _view('membres::list');
            $oView->sAction="EmptyPermis";
            $oView->oModulePagination=$oModulePagination->buildAlpha();
		$oView->tMembres=$tMembres;
		
		
		
		$this->oLayout->add('main',$oView);
		 
	}
        
//        public function _listPagination(){
//            $tDistinctLetter=model_membres::getInstance()->findDistinctAlpha();
//            
//        }
        
	public function _new(){
		$tMessage=$this->processSave();
	
		$oMembres=new row_membres;
		
		$oView=new _view('membres::new');
		$oView->oMembres=$oMembres;
		
		
		
		$oPluginXsrf=new plugin_xsrf();
		$oView->token=$oPluginXsrf->getToken();
		$oView->tMessage=$tMessage;
		
		$this->oLayout->add('main',$oView);
	}

	
	
	public function _edit(){
		$tMessage=$this->processSave();
		
		$oMembres=model_membres::getInstance()->findById( _root::getParam('id') );
		
		$oView=new _view('membres::edit');
		$oView->oMembres=$oMembres;
		$oView->tId=model_membres::getInstance()->getIdTab();
		
		
		
		$oPluginXsrf=new plugin_xsrf();
		$oView->token=$oPluginXsrf->getToken();
		$oView->tMessage=$tMessage;
		
		$this->oLayout->add('main',$oView);
	}

	
	
	public function _show(){
            
            $oView=new _view('membres::show');
            $oMembre=model_membres::getInstance()->findById( _root::getParam('id') );
            if($oMembre->coord==1){
                $oModuleGoogleMap=new module_googleMap();
                $oModuleGoogleMap->setWidth(500);
                $oModuleGoogleMap->setHeight(400);
                $oModuleGoogleMap->setZoom(15);
                $oModuleGoogleMap->setMinZoom(13); //Zoom Arriere
                $oModuleGoogleMap->setMaxZoom(18); //Zoom Avant
                //$oModuleGoogleMap->setEnableZoomControl('false');
                $oModuleGoogleMap->setEnableScrollwheel('true');
                $oModuleGoogleMap->setDisableDoubleClickZoom('true');
                $sPositionGPS=$oMembre->lat.','.$oMembre->lng;
                $sTitreGM=$oMembre->indexMembre. ' : ';
                $tContentGM= array('<b>'.$oMembre->nom.' '.$oMembre->prenom.'</b>');
                $oModuleGoogleMap->addPositionWithContent($sPositionGPS,$sTitreGM,$tContentGM);
                $oView->oModuleGoogleMap=$oModuleGoogleMap->getMap(); 	
            }	
            $oView->oMembres=$oMembre;                           
            $this->oLayout->add('main',$oView);
	}
        
        public function _localizeMember() {
            $oMembre=model_membres::getInstance()->findById( _root::getParam('id'));
            $oGoogleGeoCode = new my_googleGeocode;
            $oGoogleGeoCode->findLocalisationForOneMember($oMembre);
            _root::redirect('membres::show',array('id'=>_root::getParam('id')));
        }
	
        public function _localizeMembers() {
            $oMembres=model_membres::getInstance()->findAllLocalisable();
            $oGoogleGeoCode = new my_googleGeocode;
            $nbOfLocalization = $oGoogleGeoCode->findLocalisationForManyMembers($oMembres);
            _root::redirect('membres::list',array('nbFound'=>$nbOfLocalization));
        }
	
        
        public function _reIndexAllMembers() {
            $oMenbres=  model_membres::getInstance()->orderByName();
            $oToolsOMSS = new my_toolsOmss;
            $nbOfReindexion = $oToolsOMSS->reIndexMembers($oMenbres);
            _root::redirect('membres::list',array('nbFound'=>$nbOfReindexion));
        
            
        }
        
	public function _delete(){
		$tMessage=$this->processDelete();

		$oMembres=model_membres::getInstance()->findById( _root::getParam('id') );
		
		$oView=new _view('membres::delete');
		$oView->oMembres=$oMembres;
		
		

		$oPluginXsrf=new plugin_xsrf();
		$oView->token=$oPluginXsrf->getToken();
		$oView->tMessage=$tMessage;
		
		$this->oLayout->add('main',$oView);
	}
        
        public function _exportCSV() {            
            $sDate=  date('dmy');
            $sFileName ="";
            
            switch (_root::getParam('action')){
                case 'EmptyPermis':
                    $tMembres=model_membres::getInstance()->findExportCSVEmptyPermis();
                    $sFileName = 'ExportBenevoleOMSSEmptyPermis_'.$sDate.'.csv';
                    break;
                case 'EmptyMail':
                    $tMembres=model_membres::getInstance()->findExportCSVEmptyMail();
                    $sFileName = 'ExportBenevoleOMSSEmptyMail_'.$sDate.'.csv';
                    break;
                case 'EmptyAdress':
                    $tMembres=model_membres::getInstance()->findExportCSVEmptyAdress();
                    $sFileName = 'ExportBenevoleOMSSEmptyAdress_'.$sDate.'.csv';
                    break;
                case 'Full':
                    $tMembres=model_membres::getInstance()->findExportCSVFull();
                    $sFileName = 'ExportBenevoleOMSSFull_'.$sDate.'.csv';
                    break;
            }
            

            $oView=new _view('membres::exportCSV');
            $oView->tMembres=$tMembres;
            
            $this->oLayout->add('main',$oView);
            $this->oLayout->setLayout('export');
            $this->oLayout->sFileName=$sFileName;
            $this->oLayout->sExtension='csv';

            $this->oLayout->show();
            exit;            
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
			$oMembres=new row_membres;
                        $oLastIndex=model_membres::getInstance()->findLastIndexMembre();
                        if($oLastIndex){
                            $oMembres->indexMembre = (model_membres::getInstance()->findLastIndexMembre()->indexMembre + 1);
                        }else{
                            $oMembres->indexMembre = 1;
                        }
                        $oMembres->creer=date('Y-m-d H:i:s',time());
                        $oMembres->owner=_root::getAuth()->getAccount()->idAccount;
		}else{
			$oMembres=model_membres::getInstance()->findById( _root::getParam('id',null) );
                        $oMembres->modifier=date('Y-m-d H:i:s',time());
                        $oMembres->owner=_root::getAuth()->getAccount()->idAccount;
		}
		
		$tColumn=array('nom','prenom','mail','fixe','gsm','club','numPermis','numero','rue','complement','ville','codePostal','anneeNaissance','chkMail','chkPermis');
		foreach($tColumn as $sColumn){
                    switch ($sColumn) {
                            case 'nom':
                                $oMembres->$sColumn= strtoupper(_root::getParam($sColumn,null));
                                break;
                            case 'prenom':
                                $oMembres->$sColumn= strtoupper(_root::getParam($sColumn,null))[0].substr(_root::getParam($sColumn,null),1);
                                break;
                            default :    
                                $oMembres->$sColumn=_root::getParam($sColumn,null) ;
                        }
			
		}

		if($oMembres->save()){
                    if($iId==null){
                        _root::redirect('membres::list');
                    }
			//une fois enregistre on redirige vers la page du membre
			_root::redirect('membres::show',array('id'=>$iId));
		}else{
			return $oMembres->getListError();
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
	
		$oMembres=model_membres::getInstance()->findById( _root::getParam('id',null) );

                $oMembres->active=0;
                $oMembres->supprimer=date('Y-m-d H:i:s',time());
                $oMembres->owner=_root::getAuth()->getAccount()->idAccount;
                $oMembres->save();

		//une fois la suppression enregistrée on reindex tous les membres
		_root::redirect('membres::reIndexAllMembers');
		
	}


	
	public function after(){
		$this->oLayout->show();
	}
	
	
}

