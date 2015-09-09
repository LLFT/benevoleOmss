<?php 
class module_pagination extends abstract_module{
	
	private $tElement;
	private $iLimit;
	private $iPage;
	private $iMax;
        private $sCurrentLetter;
        private $sModuleAction='';
	private $tParam=array();
        private $tDistinctLetters=array();
	private $sParamPage='page';
	
	public function setParamPage($sParamPage){
		$this->sParamPage=$sParamPage;
	}
	public function setModuleAction($sModuleAction){
		$this->sModuleAction=$sModuleAction;
	}
	public function setParam($tParam){
		$this->tParam=$tParam;
	}
	public function setTab($tElement){
		$this->tElement=$tElement;
	}
        
        public function setDistinctLetters($tDistinctLetters){
		$this->tDistinctLetters=$tDistinctLetters;
	}
        
        public function setCurrentLetter($sCurrentLetter){
            $this->sCurrentLetter=$sCurrentLetter;
        }
        
	public function setLimit($iLimit){
		$this->iLimit=$iLimit;
	}
        
       
	public function setPage($iPage){
		$this->iPage=($iPage-1);
		if($this->iPage==-1) $this->iPage=0;
	}
	
	public function getPageElement(){
		$tPartElement=array();
		
		$this->iMax=count($this->tElement);
		
		$iMin=$this->iPage*$this->iLimit;
		$iPart=$iMin+$this->iLimit;
		if($iPart > $this->iMax){
			$iPart=$this->iMax;
		}
		
		for($i=$iMin;$i<$iPart;$i++){
			$tPartElement[]=$this->tElement[$i];
		}
		return $tPartElement;
	}
	
	public function buildPage(){
		
		$oView=new _view('pagination::listPage');
		$oView->sModuleAction=$this->sModuleAction;
		$oView->tParam=$this->tParam;
		$oView->iPage=$this->iPage;
		$oView->iMax=ceil( ($this->iMax/$this->iLimit) );
		$oView->sParamPage=$this->sParamPage;
		
		return $oView;
	}
	
	public function buildAlpha(){
		
		$oView=new _view('pagination::listAlpha');
		$oView->sModuleAction=$this->sModuleAction;
                $oView->tParam=$this->tParam;
                $oView->sParamPage=$this->sParamPage;
                $oView->tDistinctLetters=$this->tDistinctLetters;
                $oView->sCurrentLetter=$this->sCurrentLetter;
                return $oView;
	}
	
}
