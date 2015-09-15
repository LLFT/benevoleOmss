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
        protected $bTraceGPX;
        protected $sUrlTraceGPX;
        protected $sDraggable;
        protected $sDisableDefaultUI;
        protected $sMapTypeControl;
        protected $sStreetViewControl;
        protected $sPanControl;
        
        public function __construct(){
		$this->tPosition=array();
		$this->iWidth=800;
		$this->iHeight=500;
		$this->iZoom=1;
                $this->iMinZoom=1;
                $this->iMaxZoom=24;
                $this->sEnableZoomControl='false';
                $this->sEnableScrollwheel='false';
                $this->sDisableDoubleClickZoom='true';
                $this->bTraceGPX=false;
                $this->sUrlTraceGPX='';
                $this->sEnableDraggable='false';
                $this->sDisableDefaultUI='false';
                $this->sEnableMapTypeControl='false';
                $this->sEnableStreetViewControl='false';
                $this->sEnablePanControl='false';
               
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
                $oView->bTraceGPX=$this->bTraceGPX;
                $oView->sUrlTraceGPX=$this->sUrlTraceGPX;
                $oView->sEnableDraggable=$this->sEnableDraggable;
                $oView->sDisableDefaultUI=$this->sDisableDefaultUI;
                $oView->sEnableMapTypeControl=$this->sEnableMapTypeControl;
                $oView->sEnableStreetViewControl=$this->sEnableStreetViewControl;
                $oView->sEnablePanControl=$this->sEnablePanControl;
		
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
        
        public function setTraceGPX($bTraceGPX){
            $this->bTraceGPX=$bTraceGPX;            
        }
        
        public function setUrlTraceGPX($sUrlTraceGPX){
            $this->sUrlTraceGPX=$sUrlTraceGPX;            
        }
        
        public function setEnableDraggable($sEnableDraggable){
            $this->sEnableDraggable=$sEnableDraggable;        
        }
        
        public function setDisableDefaultUI($sDisableDefaultUI){
            $this->sDisableDefaultUI=$sDisableDefaultUI;            
        }
        
        public function setEnableMapTypeControl($sEnableMapTypeControl){
            $this->sEnableMapTypeControl=$sEnableMapTypeControl;            
        }
        
        public function setEnableStreetViewControl($sEnableStreetViewControl){
            $this->sEnableStreeViewControl=$sEnableStreetViewControl;            
        }
        
        public function setEnablePanControl($sEnablePanControl){
            $this->sEnablePanControl=$sEnablePanControl;            
        }
}

