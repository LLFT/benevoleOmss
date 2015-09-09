<?php 
class module_GoogleGPX extends abstract_module{
	
    public function _getMap(){
	
        $oView=new _view('googleGPX::map');
        $this->oLayout->add('main',$oView);
    }

	

	
}
