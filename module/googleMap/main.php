<?php
class module_googleMap extends abstract_moduleembedded{
	
	protected $tPosition;
	protected $tPositionWithContent;
	protected $iWidth;
	protected $iHeight;
	protected $iZoom;
        protected $iMaxZoom;
        protected $iMinZoom;
        protected $sEnableZoomControl;
        protected $sEnableScrollwheel;
        protected $sDisableDoubleClickZoom;
        
                
	
	public function __construct(){
		$this->tPosition=array();
		$this->iWidth=500;
		$this->iHeight=500;
		$this->iZoom=1;
                $this->iMinZoom=1;
                $this->iMaxZoom=24;
                $this->sEnableZoomControl='false';
                $this->sEnableScrollwheel='false';
                $this->sDisableDoubleClickZoom='false';
                
	}
	
	public function getMap(){
		
		$oView=new _view('googleMap::map');
		$oView->tPosition=$this->tPosition;
		$oView->tPositionWithContent=$this->tPositionWithContent;
		
		$oView->iWidth=$this->iWidth;
		$oView->iHeight=$this->iHeight;
		$oView->iZoom=$this->iZoom;
                $oView->iMinZoom=$this->iMinZoom;
                $oView->iMaxZoom=$this->iMaxZoom;
                $oView->sEnableZoomControl=$this->sEnableZoomControl;
                $oView->sEnableScrollwheel=$this->sEnableScrollwheel;
                $oView->sDisableDoubleClickZoom=$this->sDisableDoubleClickZoom;
		
		return $oView;
		
	}
	
	public function addPosition($sAdresse,$sTitle=null,$sLink=null){
		$this->tPosition[]=array($sAdresse,$sTitle,$sLink);
	}
	public function addPositionWithContent($sAdresse,$sTitle=null,$tContent=null){
		$this->tPositionWithContent[]=array($sAdresse,$sTitle,$tContent);
	}
	
	public function setWidth($iWidth){
		$this->iWidth=$iWidth;
	}
	public function setHeight($iHeight){
		$this->iHeight=$iHeight;
	}
	public function setZoom($iZoom){
		$this->iZoom=$iZoom;
	}
        
        public function setMaxZoom($iMaxZoom){
		$this->iMaxZoom=$iMaxZoom;
	}
        
        public function setMinZoom($iMinZoom){
		$this->iMinZoom=$iMinZoom;
	}
        
        public function setEnableZoomControl($sEnableZoomControl){
		$this->sEnableZoomControl=$sEnableZoomControl;
	}
        
        public function setEnableScrollwheel($sEnableScrollwheel){
		$this->sEnableScrollwheel=$sEnableScrollwheel;
	}
        
        public function setDisableDoubleClickZoom($sDisableDoubleClickZoom){
		$this->sDisableDoubleClickZoom=$sDisableDoubleClickZoom;
	}
}

