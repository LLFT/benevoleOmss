<?php
Class module_menu extends abstract_moduleembedded{
		
	public function _index(){
            
            $tLink=array(
               
                        'Liste des Membres' => 'membres::list',
// 
//			'Informations Manquantes' => array(
//                            'Adresse Postale' => 'membres::listEmptyAdress',
//                            'Mail' => 'membres::listEmptyMail',
//                            'Permis de conduire' => 'membres::listEmptyPermis',
//			),
                
                        'Activité' => array(              
                        'Liste des Evènements' =>'events::list',
                        'Liste des Parcours' =>'parcours::list',
                        ),
 
			'Outils' => array(
				'Localisation Global' => 'membres::localizeMembers',
                                'Rapprochement' => 'membres::reIndexAllMembers',    
			),
        
                        'Administration' => array(
                            'Gestion des Comptes'=>'account::list',
                            'Gestion des Groupes'=>'groupe::list',
                            'Gestion des Permissions'=>'permission::list',
                            'Gestion des Eléments' => 'element::list',
                        ),
                        
     
            
		);
            if(_root::getConfigVar('auth.enabled')===1){;
                foreach($tLink as $sLabelPrim => $sLink){                  
                    
                    if (is_array($sLink)){
                        foreach($sLink as $sLabelSec=>$sSousMenu){ 
                            if(!_root::getACL()->can('ACCESS',$sSousMenu)) {
                                unset($tLink[$sLabelPrim][$sLabelSec]);
                             }
                        }
                        if (empty($tLink[$sLabelPrim])){
                            unset($tLink[$sLabelPrim]);
                        }
                          
                    }else{
                        if(!_root::getACL()->can('ACCESS',$sLink)){
                            unset($tLink[$sLabelPrim]);                        
                        }
                    }
                    
                }
            }
                $tLink2=array();
                $tLink2['Accueil'] = 'default::index';
                $tLink2['Deconnexion'] = 'auth::logout';
                    
		$oView=new _view('menu::index');
		$oView->tLink=$tLink;
                $oView->tLink2=$tLink2;
        
		
		return $oView;
	}
}
