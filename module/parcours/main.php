<?php 
class module_parcours extends abstract_module{
	
	public function before(){
		$this->oLayout=new _layout('bootstrap');
		
		$this->oLayout->addModule('menu','menu::index');
                
                if(!_root::getACL()->can('ACCESS','parcours::list')){
                    _root::redirect('default::index');
                }
                
	}
	/* #debutaction#
	public function _exampleaction(){
	
		$oView=new _view('examplemodule::exampleaction');
		
		$this->oLayout->add('main',$oView);
	}
	#finaction# */
	
	
//	public function _uploadFile(){
//	
//		$oView=new _view('parcours::uploadFile');
//		
//		$this->oLayout->add('main',$oView);
//	}
	
	public function _show(){
                
                $oParcours=  model_parcours::getInstance()->findById(_root::getParam('id'));
                
		$oView=new _view('parcours::show');
		$oView->sUrl=$oParcours->url;
		//$oView->iWidth=500;
		$oView->iHeight=500;
		$this->oLayout->add('main',$oView);
	}
	
	public function _list(){
	
           $tAllParcours=model_parcours::getInstance()->findAll();
            
		$oView=new _view('parcours::list');
                $oView->tParcours=$tAllParcours;
		
		$this->oLayout->add('main',$oView);
	}
	
	
	public function after(){
		$this->oLayout->show();
	}
	
        public function _new(){
            $tMessage=$this->processSave();
            $oParcours=new row_events;
            $oView=new _view('parcours::new');
            $oView->oParcours=$oParcours;
            $oView->tMessage=$tMessage;
     
             $this->oLayout->add('main',$oView);
        }
            
        private function processSave(){
            if(!_root::getRequest()->isPost() ){ //si ce n'est pas une requete POST on ne soumet pas
			return null;
		}
            $retour=array();


            $oFile=new row_parcours;
            if (!$oFile->isValid()){
                return $oFile->getListError();
            }
            
            $tFields=array('label');

            foreach($tFields as $sField){
                $oFile->$sField=_root::getParam($sField,null) ;
            }
            
            $sNameInputFile='fileGPX';
            $checksum=md5_file($_FILES[$sNameInputFile]['tmp_name']);
            $tNbChecksum=model_parcours::getInstance()->findByCheckSum($checksum);
            
            if ($tNbChecksum->NbCheckSum < 1){
                
                $oPluginUpload=new plugin_upload($sNameInputFile);
            
                if(strtolower($oPluginUpload->getExtension())!='gpx'){
                    $retour['message']= array('extension'=>'Fichier non conforme. *.GPX uniquement');
                    return $retour;
                }

                if($oPluginUpload->isValid()&& $oFile->isValid()){
                   $sNewFileName='../upload/'.$sNameInputFile.'_'.date('Ymdhis');
                   $oPluginUpload->saveAs($sNewFileName);
                   $sNewFullPath=$oPluginUpload->getPath();
                   $oFile->label=strtoupper($_POST['label']);
                   $oFile->url=$sNewFullPath;
                   $oFile->checksum=$checksum;
                   $oFile->save();
                   $retour['message']=array('lvlError'=>'0', 'message'=>'Fichier '.$_POST['label'].' sauvegardé avec succès');

                }else{                
                    $retour['message']=$oFile->getListError();
                }                
            }else{
                $retour['message']= array('lvlError'=>'1', 'message'=>'Ce fichier a déjà enregistré dans nos bases sous le label : '.$tNbChecksum->label.'.');
            }
             
            
            
            return $retour;

        }
	
}
