<?php 
class module_membres extends abstract_module{
	
	public function before(){
		$this->oLayout=new _layout('bootstrap');
		
		$this->oLayout->addModule('menu','menu::index');
                
                //Vérifions que l'authentification est active
                if(_root::getConfigVar('auth.enabled')==='1'){;                
                    //Vérifions que le compte peut accèder à ce module
                    if(!_root::getACL()->can('ACCESS','membres::list')){
                        _root::redirect('default::index');
                    }
                }
        }	
        
        public function _index(){
	    //on considere que la page par defaut est la page de listage
	    $this->_list();
	}
        
        public function _list(){
            if(!_root::getACL()->can('ACCESS','membres::list')){
                        _root::redirect('default::index');
                    }
            
            $sAction=  _root::getParam('action');
            
            switch ($sAction) {
                case 'EmptyAdress':
                    $tAllMembres=model_membres::getInstance()->findAllEmptyAdress();
                    $tDistinctLetters=model_membres::getInstance()->findDistinctLetters($tAllMembres);
                    if (null !==_root::getParam('letter')){
                        //Une lettre à été choisie dans la pagination
                        $sCurrentLetter = _root::getParam('letter');
                    }else{
                        // Aucun lettre de choisie. Donc on prends la première.
                        $sCurrentLetter = $tDistinctLetters[0]; 
                    }
                    //Liste des Membres en focntion de la lettre choisie
                    $tMembres=model_membres::getInstance()->findAllEmptyAdress($sCurrentLetter);
                    
                    break;
                case 'EmptyMail':
                    $tAllMembres=model_membres::getInstance()->findAllEmptyMail();
                    $tDistinctLetters=model_membres::getInstance()->findDistinctLetters($tAllMembres);
                    if (null !==_root::getParam('letter')){
                       $sCurrentLetter = _root::getParam('letter');
                    }else{
                       $sCurrentLetter = $tDistinctLetters[0]; 
                    }
                    $tMembres=model_membres::getInstance()->findAllEmptyMail($sCurrentLetter);
                    
                    break;
                case 'EmptyPermis':
                    $tAllMembres=model_membres::getInstance()->findAllEmptyPermis();
                    $tDistinctLetters=model_membres::getInstance()->findDistinctLetters($tAllMembres);
                    if (null !==_root::getParam('letter')){
                       $sCurrentLetter = _root::getParam('letter');
                    }else{
                       $sCurrentLetter = $tDistinctLetters[0]; 
                    }
                    $tMembres=model_membres::getInstance()->findAllEmptyPermis($sCurrentLetter);
                    
                    break;
                case 'FullInfo':
                    $tAllMembres=model_membres::getInstance()->findAllUpdate();
                    $tDistinctLetters=model_membres::getInstance()->findDistinctLetters($tAllMembres);
                    if (null !==_root::getParam('letter')){
                       $sCurrentLetter = _root::getParam('letter');
                    }else{
                       $sCurrentLetter = $tDistinctLetters[0]; 
                    }
                    $tMembres=model_membres::getInstance()->findAllUpdate($sCurrentLetter);
                    break;
                case 'EmptyInfo':
                    $tAllMembres=model_membres::getInstance()->findAllNotUpdate();
                    $tDistinctLetters=model_membres::getInstance()->findDistinctLetters($tAllMembres);
                    if (null !==_root::getParam('letter')){
                       $sCurrentLetter = _root::getParam('letter');
                    }else{
                       $sCurrentLetter = $tDistinctLetters[0]; 
                    }
                    $tMembres=model_membres::getInstance()->findAllNotUpdate($sCurrentLetter);
                    break;
                default:
                    $tAllMembres=model_membres::getInstance()->findAll();            
                    $tDistinctLetters=model_membres::getInstance()->findDistinctLetters($tAllMembres);
                    if (null !==_root::getParam('letter')){
                        $sCurrentLetter = _root::getParam('letter');
                    }else{
                        $sCurrentLetter = $tDistinctLetters[0]; 
                    }
                    $tMembres=model_membres::getInstance()->findAll($sCurrentLetter);
                    
                    break;
            }
            //Préparation de la Pagination Alphabétique
            $oModulePagination=new module_pagination;
            $oModulePagination->setModuleAction('membres::list');
            $oModulePagination->setParamPage('letter');
            $oModulePagination->setParam(array('action'=>$sAction));
            $oModulePagination->setDistinctLetters($tDistinctLetters);            
            $oModulePagination->setCurrentLetter($sCurrentLetter);
            
            //Préparation de la vue
            $oView=new _view('membres::list');
            $oView->sAction=$sAction;
            $oView->oModulePagination=$oModulePagination->buildAlpha();
            $oView->tMembres=$tMembres; 
            $this->oLayout->add('main',$oView);
         
        }        

	public function _new(){
            if(!_root::getACL()->can('ACCESS','membres::new')){
                        _root::redirect('default::index');
                    }
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
            if(!_root::getACL()->can('ACCESS','membres::edit')){
                        _root::redirect('default::index');
                    }
		$tMessage=$this->processSave();
                //On liste les informations propres au participant
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
            if(!_root::getACL()->can('ACCESS','membres::show')){
                        _root::redirect('default::index');
                    }
            
            $oView=new _view('membres::show');
            //On liste les informations propres au participant
            $oMembre=model_membres::getInstance()->findById( _root::getParam('id') );
            //On liste tous les évènements connus et actifs 
            $tJoinEvents=model_events::getInstance()->getSelect();
            $oOwner=  model_account::getInstance()->findById($oMembre->owner);
            //On liste toutes les relations connus entre le participant et les évènements
            $tJoinIdEvents=model_relationeventmemb::getInstance()->getSelectIdEvent(_root::getParam('id'));
            $oView->tJoinEvents=$tJoinEvents;
            $oView->tJoinIdEvents=$tJoinIdEvents;            
            $oView->oMembres=$oMembre;
            $oView->oOwner=$oOwner;
            $this->oLayout->add('main',$oView);
	}
        
        public function _localizeMember() {
            if(!_root::getACL()->can('ACCESS','membres::localizeMember')){
                        _root::redirect('default::index');
                    }
            $oMembre=model_membres::getInstance()->findById( _root::getParam('id'));            
            $this->findLocalisationForOneMember($oMembre);            
            _root::redirect('membres::show',array('id'=>_root::getParam('id')));
        }
	
        public function _localizeMembers() {
            if(!_root::getACL()->can('ACCESS','membres::localizeMembers')){
                        _root::redirect('default::index');
                    }
            $oMembres=model_membres::getInstance()->findAllLocalisable();
            $nbOfLocalization = $this->findLocalisationForManyMembers($oMembres);
            _root::redirect('membres::list',array('nbFound'=>$nbOfLocalization));
        }
	
        /**
         * 
         */
        public function _reIndexAllMembers() {
            if(!_root::getACL()->can('ACCESS','membres::reIndexAllMembers')){
                        _root::redirect('default::index');
                    }
            $oMenbres=  model_membres::getInstance()->orderByName();            
            $i=1;
            foreach ($oMenbres as $oMembre) {
                $this->saveIndexMembre($oMembre->idMembre, $i);
                $i++;
            }
            _root::redirect('membres::list',array('nbFound'=>$i));            
        }
   
        
	public function _delete(){
            if(!_root::getACL()->can('ACCESS','membres::delete')){
                        _root::redirect('default::index');
                    }
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
            if(!_root::getACL()->can('ACCESS','membres::exportCSV')){
                        _root::redirect('default::index');
                    }
            $sDate=  date('dmy');
            $sFileName ="";
            
            switch (_root::getParam('action')){
                case 'EmptyPermis':
                    $tMembres=model_membres::getInstance()->findAllEmptyPermis();
                    $sFileName = 'ExportBenevoleOMSSEmptyPermis_'.$sDate.'.csv';
                    break;
                case 'EmptyMail':
                    $tMembres=model_membres::getInstance()->findAllEmptyMail();
                    $sFileName = 'ExportBenevoleOMSSEmptyMail_'.$sDate.'.csv';
                    break;
                case 'EmptyAdress':
                    $tMembres=model_membres::getInstance()->findAllEmptyAdress();
                    $sFileName = 'ExportBenevoleOMSSEmptyAdress_'.$sDate.'.csv';
                    break;
                case 'FullInfo' :
                    $tMembres=model_membres::getInstance()->findAllUpdate();
                    $sFileName = 'ExportBenevoleOMSSFullInfo_'.$sDate.'.csv';
                    break;
                case 'EmptyInfo':
                    $tMembres=model_membres::getInstance()->findAllNotUpdate();
                    $sFileName = 'ExportBenevoleOMSSEmptyInfo_'.$sDate.'.csv';
                    break;
                default :
                    $tMembres=model_membres::getInstance()->findAll();
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
		
                $tColumn=array('nom','prenom','mail','fixe','gsm','club','numPermis','numero','rue','complement','ville','codePostal','anneeNaissance','chkMail','chkPermis','chkSignaleur','chkFormulaire','comment');
                foreach($tColumn as $sColumn){
                    switch ($sColumn) {
                            case 'nom':
                                $oMembres->$sColumn= strtoupper(_root::getParam($sColumn,null));
                                break;
                            case 'prenom':
                                $oMembres->$sColumn= strtoupper(_root::getParam($sColumn,null))[0].substr(_root::getParam($sColumn,null),1);
                                break;
                            case 'rue':
                                if($oMembres->$sColumn != _root::getParam($sColumn)){
                                    $oMembres->$sColumn=_root::getParam($sColumn,null);
                                    $oMembres->coord=0;
                                }
                                break;
                            case 'ville':
                                if($oMembres->$sColumn != _root::getParam($sColumn)){
                                    $oMembres->$sColumn=_root::getParam($sColumn,null);
                                    $oMembres->coord=0;
                                }
                                break;
                            default :
                                if(substr($sColumn, 0, 3)==='chk'){ //Si ce sont des CheckBox la valeur par défaut est 0
                                    $oMembres->$sColumn=_root::getParam($sColumn,0) ;
                                }else{
                                    $oMembres->$sColumn=_root::getParam($sColumn,null) ;    
                                }
                        }
		}

		if($oMembres->save()){
                    
                    if($iId==null){
                        $iId=$oMembres->getId();    
                        //_root::redirect('membres::list');
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
        
        private function setCoordInTable($oMembreID,$tCoord=NULL){
            if(!empty($tCoord)){
                if(count($tCoord)>1){
                    $oMembreEdit = model_membres::getInstance()->findById($oMembreID);
                    $oMembreEdit->coord='1';
                    $oMembreEdit->lat=$tCoord[2];
                    $oMembreEdit->lng=$tCoord[3];
                    $oMembreEdit->modifier=date('Y-m-d H:i:s',time());
                    $oMembreEdit->saveF();
                }else{
                    echo 'Problème avec le membre dont l\'ID est '.$oMembreID."\n\r . Le géocoadage multiple est limité par Google 5 requetes/sec.(OVER_QUERY_LIMIT) \n\r Je vous invite à recommencer plus tard.";
                    var_dump($tCoord);
                    die();
                }
            }
        }

        private function findLocalisationForOneMember($oMembre){
            $sAdressPostal = $oMembre->numero.','.$oMembre->rue.','.$oMembre->ville.','.$oMembre->codePostal;
            $oGoogleGeoCode = new my_GoogleMapAPI();
            $tCoord = $oGoogleGeoCode->geocoding($sAdressPostal);
            $this->setCoordInTable($oMembre->idMembre, $tCoord);
        }

        private function findLocalisationForManyMembers($oMembres){
            ini_set('max_execution_time', 0);
            $i=0;
            foreach ($oMembres as $oMembre) {
                $this->findLocalisationForOneMember($oMembre);
                $i++;
            }
            ini_restore('max_execution_time');
            return $i;
        }
        
        private function saveIndexMembre($iIdMembre, $iIndex) {
            $oMembreEdit = model_membres::getInstance()->findById($iIdMembre);
            $oMembreEdit->indexMembre = $iIndex;
            /*On effectue une sauvegarde sans se soucier des controles de validité*/
            $oMembreEdit->saveF();           

        }
        
        
//Les appels AJAX         
        /*
         * Déclare le membre comme étant un signaleur.
         */        
        public function _ajaxSignaleur() {
            if(!_root::getACL()->can('ACCESS','membres::ajaxSignaleur')){
                        _root::redirect('default::index');
                    }
            $retour=array();
            $sortie=array();
            $oView=new _view('membres::ajaxOut');
            $this->oLayout->add('main',$oView);
            $this->oLayout->setLayout('ajax');
            $sortie['reponse']='NOK';
            
            $oMembres=model_membres::getInstance()->findById( _root::getParam('id',null) );
            $oMembres->modifier=date('Y-m-d H:i:s',time());
            $oMembres->owner=_root::getAuth()->getAccount()->idAccount;
            
            if($oMembres->chkSignaleur!=0){
                $oMembres->chkSignaleur=0;
                $sortie['reponse']='OK';
            }else{
                $oMembres->chkSignaleur=1;
                $sortie['reponse']='OK';
            }
            
            $oMembres->saveF();
            $retour['reponse']=$sortie;
            $oView->sSortie=  json_encode($retour);

        }
        /*
         * Inscrit au Désincrit un membre d'un évènement
         */
        public function _ajaxJoinEventMembre() {
            if(!_root::getACL()->can('ACCESS','membres::ajaxJoinEventMembre')){
                        _root::redirect('default::index');
                    }
            $retour=array();
            $sortie=array();
            $action = 'unjoin';
            
            if(_root::getParam('EventHidden')){
                if(_root::getParam('action')){
                   $action = 'join' ;
                }
                $idMembre = _root::getParam('idMembreHidden');
                $idEvent =_root::getParam('idEventHidden');
            }else{                
                $action=_root::getParam('action');
                $idMembre = _root::getParam('idMembre');
                $idEvent =_root::getParam('idEvent');
            }
            
            
            
            
            if($action === 'join'){
                model_relationeventmemb::getInstance()->joinMemberEvent($idMembre,$idEvent);
                $sortie['reponse']='OK';
                
                 
            }elseif($action === 'unjoin'){
                model_relationeventmemb::getInstance()->unJoinMemberEvent($idMembre,$idEvent);
                $sortie['reponse']='OK';
            }  else {
                $sortie['reponse']='NOK';
            }
            $retour['reponse']=$sortie;
            
            if(_root::getParam('EventHidden')){
                _root::redirect('membres::show',array('id'=>$idMembre));
            }
            
            
            $oView=new _view('membres::ajaxOut');
            $this->oLayout->add('main',$oView);
            $this->oLayout->setLayout('ajax');
            $oView->sSortie=  json_encode($retour);
           
        }        
	
}

