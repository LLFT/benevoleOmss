<?php 
class module_parcours extends abstract_module{
	
	public function before(){
		$this->oLayout=new _layout('bootstrap');
		
		$this->oLayout->addModule('menu','menu::index');
                
                //Vérifions que l'authentification est active
                if(_root::getConfigVar('auth.enabled')==='1'){;                
                    //Vérifions que le compte peut accèder à ce module
                    if(!_root::getACL()->can('ACCESS','parcours::show')){
                        _root::redirect('membres::list');
                    }
                }
	}
	
	
	public function _index(){
	    //on considere que la page par defaut est la page de listage
	    $this->_list();
	}
	
	
	public function _list(){
            if(!_root::getACL()->can('ACCESS','parcours::list')){
                        _root::redirect('membres::list');
                    }
		
		$oParcours=model_parcours::getInstance()->findAll();
                $oEvents=model_events::getInstance()->getSelect();
                
		
		$oView=new _view('parcours::list');
		$oView->oParcours=$oParcours;
                $oView->tJoinmodelEvents=$oEvents;
		
		
		
		$this->oLayout->add('main',$oView);
		 
	}

	
	
	public function _new(){
            if(!_root::getACL()->can('ACCESS','parcours::new')){
                        _root::redirect('membres::list');
                    }
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
            if(!_root::getACL()->can('ACCESS','parcours::show')){
                        _root::redirect('membres::list');
                    }
		$oParcours=model_parcours::getInstance()->findById( _root::getParam('id') );
                $tMembresCoord=model_membres::getInstance()->getCoordOfParticipantOfEvent(_root::getParam('idEvent'));
                

		$oView=new _view('parcours::show');
                $oView->oParcours=$oParcours;
                
                
                $gmap = new my_GoogleMapAPI();                
                //Charge le contenu du GPX dans la class geoPHP
                $polygon = geoPHP::load(file_get_contents($oParcours->url),'gpx');
                //Mesure l'aire couverte par la trace GPX
                $area = $polygon->getArea();
                //Calcule le centre de l'aire
                $centroid = $polygon->getCentroid();
                // Coordonées du centre
                $centLng = $centroid->getX();
                $centLat = $centroid->getY();

                
                
                $gmap->setDivId('containerMap');
                $gmap->setDirectionDivId('route');
//                $gmap->setCenterLatLng($centLat,$centLng);
                $gmap->setEnableWindowZoom(true);
                $gmap->setDefaultLat($centLat);
                $gmap->setDefaultLng($centLng);                
                $gmap->setSize('800px','600px');
                $gmap->setZoom(15);
                $gmap->setMaxZoom(20);
                $gmap->setMinZoom(12);
                $gmap->setLang('fr');
//                $gmap->setDefaultHideMarker(false);
                //$gmap->setShowImmediatParcours(true);
                $gmap->setParcours_id(_root::getParam('id'));
                $gmap->setEvent_id(_root::getParam('idEvent'));
                //$gmap->addPolyligne($tGpx);
                //$gmap->addParticipants($tMembresCoord,'volontaires');
                //$gmap->addPoints($tPointsOfChasuble);
                //$gmap->setStreetViewControl(FALSE);                
                $gmap->setClusterer(true,100,15,'./js/markerclusterer_compiled.js'); //Désactivé sinon les Markers sont réaffiché à chaque zoom
            
                $gmap->generate();
                $oView->tMembresCoord=$tMembresCoord;
                $oView->oModuleGoogleMap=$gmap;

		$this->oLayout->add('main',$oView);
	}

	
	
	public function _delete(){
            if(!_root::getACL()->can('ACCESS','parcours::delete')){
                        _root::redirect('membres::list');
                    }
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
                            
                            try{ 
                                simplexml_load_file($oPluginUpload->getTmpPath());                                
                            } catch(Exception $e){
                                return array('url' => array('Fichier n\'est pas un fichier GPX conforme aux attentes.'));                           
                            } 
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
	
//Les appels AJAX         
        /*
         * Enregistre la position du nouveau point créé
         * index.php?:nav=parcours::ajaxAjoutPoints&sLatVal=45.431542895847286&sLngVal=4.3821185628411286&iParcours_id=1&iTypeofpoint_id=1
         */        
        public function _ajaxAddPoints() {
//            if(!_root::getACL()->can('ACCESS','parcours::ajaxAddPoints')){
//                        _root::redirect('membres::list');
//                    }
            $retour=array();
           
            $oView=new _view('membres::ajaxOut');
            $this->oLayout->add('main',$oView);
            $this->oLayout->setLayout('ajax');            
            $LatVal=_root::getParam('sLatVal');
            $LngVal=_root::getParam('sLngVal');
            $Parcours_id=_root::getParam('iParcours_id');
            $Typeofpoint_id=_root::getParam('iTypeofpoint_id');            
            $oPoints=new row_points;
            $oPoints->lat=$LatVal;
            $oPoints->lng=$LngVal;
            $oPoints->parcours_id=$Parcours_id;
            $oPoints->typeofpoint_id=$Typeofpoint_id;            
            if($oPoints->save()){
                $retour['etat']='OK';
                $retour['idPoint']=$oPoints->getId();
            }else{
                $retour['etat']='NOK';
            }            
            $oView->sSortie=  json_encode($retour);            
        }
        
        
        
        
        /*
         * Récupère les points constituant le parcours.
         */
        public function _ajaxPointOfPoly() {
//            if(!_root::getACL()->can('ACCESS','parcours::ajaxDelPoints')){
//                        _root::redirect('membres::list');
//                    }
            $retour=array();
            $sortie=array();            
            $oView=new _view('membres::ajaxOut');
            $this->oLayout->add('main',$oView);
            $this->oLayout->setLayout('ajax');            
            $iParcoursId=_root::getParam('iParcoursId');
            $oParcours=model_parcours::getInstance()->findById( $iParcoursId );
                //Charge le contenu du GPX dans la class geoPHP
            $polygon = geoPHP::load(file_get_contents($oParcours->url),'gpx');
            $tGpx = $polygon->asArray(); 
            
            foreach ($tGpx as $key => $coord){
                $sortie[$key]['lat']=$coord[1];
                $sortie[$key]['lng']=$coord[0];   
            }                     
            
            if(true){
                $retour['etat']='OK';
            }else{
                $retour['etat']='NOK';
            }            
            $retour['reponse']=$sortie;
            $oView->sSortie=  json_encode($retour);            
        }
        /*
         * return Array ('idPoint','name','lat','lng','typeofpoint_id');
         */
        public function _ajaxGetMarker(){
            //            if(!_root::getACL()->can('ACCESS','parcours::ajaxDelPoints')){
//                        _root::redirect('membres::list');
//                    }
            $retour=array();
                      
            $oView=new _view('membres::ajaxOut');
            $this->oLayout->add('main',$oView);
            $this->oLayout->setLayout('ajax');            
            $iParcoursId=_root::getParam('iParcoursId');
            $typeofpointId = _root::getParam('typeofpointId');
            $sortie=  model_points::getInstance()->getSelectPoints($iParcoursId,$typeofpointId);
            if(true){
                $retour['etat']='OK';
            }else{
                $retour['etat']='NOK';
            }
            $retour['reponse']=$sortie;
            $oView->sSortie=  json_encode($retour); 
        }
        
        public function _ajaxGetPositionMembers(){
            //            if(!_root::getACL()->can('ACCESS','parcours::ajaxDelPoints')){
//                        _root::redirect('membres::list');
//                    }
            $retour=array();
                       
            $oView=new _view('membres::ajaxOut');
            $this->oLayout->add('main',$oView);
            $this->oLayout->setLayout('ajax');            
            $iParcoursId=_root::getParam('iParcoursId');            
            $sortie= model_membres::getInstance()->getCoordOfParticipantOfEvent($iParcoursId);
            if(true){
                $retour['etat']='OK';
            }else{
                $retour['etat']='NOK';
            }
            $retour['reponse']=$sortie;
            $oView->sSortie=  json_encode($retour); 
        }
        
        public function _ajaxGetInfoMember(){
            //            if(!_root::getACL()->can('ACCESS','parcours::ajaxDelPoints')){
//                        _root::redirect('membres::list');
//                    }
            $retour=array();
                       
            $oView=new _view('membres::ajaxOut');
            $this->oLayout->add('main',$oView);
            $this->oLayout->setLayout('ajax');            
            $idMember=_root::getParam('idMember');            
            $sortie= model_membres::getInstance()->getInfoMenber($idMember);
            if(true){
                $retour['etat']='OK';
            }else{
                $retour['etat']='NOK';
            }
            $retour['reponse']=$sortie;
            $oView->sSortie=  json_encode($retour); 
        }
        
   
        public function _ajaxDelPoints() {
//            if(!_root::getACL()->can('ACCESS','parcours::ajaxDelPoints')){
//                        _root::redirect('membres::list');
//                    }
            $tPoints = json_decode(stripslashes($_POST['tPoints']));
            $retour=array();
            $sortie=array();            
            $oView=new _view('membres::ajaxOut');
            $this->oLayout->add('main',$oView);
            $this->oLayout->setLayout('ajax');
            foreach($tPoints as $iIdPoint){
                $oPoints=model_points::getInstance()->findById( $iIdPoint );
                $oPoints->delete();
            }
            if(true){
                $sortie['reponse']='OK';
            }else{
                $sortie['reponse']='NOK';
            }            
            $retour['reponse']=$sortie;
            $oView->sSortie=  json_encode($retour);            
        }
        
        public function _ajaxShowMemberSpot() {
            //http://benevoleomss.lan/index.php?:nav=parcours::ajaxShowMemberSpot&idPoint=2&idEvent=1
//            if(!_root::getACL()->can('ACCESS','parcours::ajaxDelPoints')){
//                        _root::redirect('membres::list');
//                    }
            if(_root::getRequest()->isPost() ){ //si ce n'est pas une requete POST on ne soumet pas
                $oView=new _view('membres::edit');
                
                $oPoints=model_points::getInstance()->findById( _root::getParam('PointID' ));
                if($oPoints->name != _root::getParam('Label' )){
                    $oPoints->name = _root::getParam('Label' );
                    $oPoints->save();
                }
                if((strlen(_root::getParam('AjoutMembre' ))!=0)&&(is_numeric(_root::getParam('AjoutMembre' )))){
                    $oRelationpointmemb=new row_relationpointmemb;
                    $oRelationpointmemb->membre_id=_root::getParam('AjoutMembre' );
                    $oRelationpointmemb->point_id=_root::getParam('PointID' );
                    $oRelationpointmemb->parcours_id=_root::getParam('ParcoursID' );                    
                    $oRelationpointmemb->save();                    
                }
                foreach ($_POST as $key => $value) {
                    if (substr($key, 0, 4)==='chk_'){
                        $idMember= substr($key, 4);
                        
                        if($value!=1){
                            $oRelation=model_relationpointmemb::getInstance()->findByIdMembre($idMember,$oPoints->parcours_id);
                            $oRelation->delete();                           
                        }
                    }
                }
            }
                 
            $idPoint=_root::getParam('idPoint');            
            $idEvent = _root::getParam('idEvent');
            
            $oPoints=model_points::getInstance()->findById( $idPoint );
            if($oPoints){
                $idParcours = $oPoints->parcours_id;
                $tMembres=  model_relationpointmemb::getInstance()->getSelectMembersOnPoint( $idPoint, $idParcours);
                $tFreeMembres = model_relationeventmemb::getInstance()->getListMembresLibres( $idEvent, $idParcours);
                $oView=new _view('parcours::showPointFiche');
                $oView->oPoints=$oPoints;
                $oView->tMembres=$tMembres;
                $oView->tFreeMembres=$tFreeMembres;
            }else{
                $oView=new _view('parcours::showPointFicheNew');
            }
            $this->oLayout->add('main',$oView);
            $this->oLayout->setLayout('ajax');
        }
        
}

