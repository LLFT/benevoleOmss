

    //var idParcours = <?php echo $this->oParcours->idParcours ;?>;
    var polyLineParcours;
    var g = google.maps;
    var map;
    //var tmpPolyLine;
    var startMarker;
    var markers = [];
    var midmarkers = [];
    var polyPoints = [];
    var pointsArray = [];
    var toolID = 1;
    var mylistener;
    var bEditing = false;
    var bDelete = false;
    


    var markerdefault = {
        url: 'http://maps.gstatic.com/mapfiles/markers2/marker.png',
    };

    var markerPM = {
        url: './css/images/Markers.png',
        size: new g.Size(32,38),
        origin: new g.Point(32,0),
        anchor: new g.Point(16, 38)
    };

    var markerChasuble = {
        url: './css/images/Markers.png',
        size: new g.Size(32, 38),
        origin: new g.Point(32,32),
        anchor: new g.Point(16, 38)
    };        

    var markerHome = {
        url: './css/images/Markers.png',
        size: new g.Size(32,38),
        origin: new g.Point(32,64),
        anchor: new g.Point(16, 38)
    };

    var markerRelais = {
        url: './css/images/Markers.png',
        size: new g.Size(32, 38),
        origin: new g.Point(0,0),
        anchor: new g.Point(16, 38)
    };

    var markerAnim = {
        url: './css/images/Markers.png',
        size: new g.Size(32,38),
        origin: new g.Point(0,32),
        anchor: new g.Point(16, 38)
    };

    var markerOmss = {
        url: './css/images/Markers.png',
        size: new g.Size(32,38),
        origin: new g.Point(0,64),
        anchor: new g.Point(16, 38)
    };
    
    var imageNormal = {
        url: './css/images/square.png',
        size: new g.Size(11,11),
        origin: new g.Point(0,0),
        anchor: new g.Point(6, 6)
    };
    
    var imageHover = {
        url: './css/images/square_over.png',
        size: new g.Size(11,11),
        origin: new g.Point(0,0),
        anchor: new g.Point(6, 6)
    };
    
    var imageNormalMidpoint = {
        url: './css/images/square_transparent.png',
        size: new g.Size(11,11),
        origin: new g.Point(0,0),
        anchor: new g.Point(6, 6)
    };
    
    var btnDeleteImageUrl = {
        url: './css/images/Delete.png'      
    };

function clickRemoveBetPoint(){
        if(bDelete){
            bDelete=false;
        }else{
            bDelete=true;
        }
    }


function setmidmarkers(point) {
    var prevpoint = markers[markers.length-2].getPosition();
    var marker = new g.Marker({
    	position: new g.LatLng(
    		point.lat() - (0.5 * (point.lat() - prevpoint.lat())),
    		point.lng() - (0.5 * (point.lng() - prevpoint.lng()))
    	),
    	map: mapcontainerMap,
    	icon: imageNormalMidpoint,
        raiseOnDrag: false,
    	draggable: true
    });
    g.event.addListener(marker, "mouseover", function() {
    	marker.setIcon(imageNormal);
    });
    g.event.addListener(marker, "mouseout", function() {
    	marker.setIcon(imageNormalMidpoint);
    });
    g.event.addListener(marker, "dragend", function() {
    	for (var i = 0; i < midmarkers.length; i++) {
    		if (midmarkers[i] === marker) {
    			var newpos = marker.getPosition();
    			var startMarkerPos = markers[i].getPosition();
    			var firstVPos = new g.LatLng(
    				newpos.lat() - (0.5 * (newpos.lat() - startMarkerPos.lat())),
    				newpos.lng() - (0.5 * (newpos.lng() - startMarkerPos.lng()))
    			);
    			var endMarkerPos = markers[i+1].getPosition();
    			var secondVPos = new g.LatLng(
    				newpos.lat() - (0.5 * (newpos.lat() - endMarkerPos.lat())),
    				newpos.lng() - (0.5 * (newpos.lng() - endMarkerPos.lng()))
    			);
    			var newVMarker = setmidmarkers(secondVPos);
    			newVMarker.setPosition(secondVPos);//apply the correct position to the midmarker
    			var newMarker = setmarkers(newpos);
    			markers.splice(i+1, 0, newMarker);
    			polyLineParcours.getPath().insertAt(i+1, newpos);
    			marker.setPosition(firstVPos);
    			midmarkers.splice(i+1, 0, newVMarker);
    			break;
    		}
    	}
        polyPoints = polyLineParcours.getPath();
        var stringtobesaved = newpos.lat().toFixed(6) + ',' + newpos.lng().toFixed(6);
        pointsArray.splice(i+1,0,stringtobesaved);
        
    });
    return marker;
}

function setmarkers(point) {
    var marker = new g.Marker({
    	position: point,
    	map: mapcontainerMap,
    	icon: imageNormal,
        raiseOnDrag: false,
    	draggable: true
    });
    g.event.addListener(marker, "mouseover", function() {
    	marker.setIcon(imageHover);
    });
    g.event.addListener(marker, "mouseout", function() {
    	marker.setIcon(imageNormal);
    });
    g.event.addListener(marker, "drag", function() {
        for (var i = 0; i < markers.length; i++) {
            if (markers[i] === marker) {
                polyLineParcours.getPath().setAt(i, marker.getPosition());
                movemidmarker(i);
                break;
            }
        }
        polyPoints = polyLineParcours.getPath();
        var stringtobesaved = marker.getPosition().lat().toFixed(6) + ',' + marker.getPosition().lng().toFixed(6);
        pointsArray.splice(i,1,stringtobesaved);
        
    });
    
    return marker;
}


function stopediting(){
for(var i = 0; i < markers.length; i++) {
            markers[i].setMap(null);
        }
        polyPoints = polyLineParcours.getPath();
        markers = [];
        bEditing = false;
        $( "span.icon32ShowPoint" ).toggleClass( "icon32ShowPointAct" );
}

 function editlines(){
    if(bEditing !== false){
        stopediting();
    }else{
        
        //On s'assure qu'une trace est bien chargée
        if (typeof polyLineParcours !== 'undefined') {
            $( "span.icon32ShowPoint" ).toggleClass( "icon32ShowPointAct" );
            polyPoints = polyLineParcours.getPath();
            if(polyPoints.length > 0){
                //On s'assure que cette trace est bien affichée.
                if(!polyLineParcours.visible){
                    polyLineParcours.setMap(mapcontainerMap);
                    mapcontainerMap.fitBounds(bounds);
                    polyLineParcours.setVisible(true);
                }
                if(markers.length === 0){
                    for(var i = 0; i < polyPoints.length; i++) {
                        var marker = setmarkers(polyPoints.getAt(i));
                        markers.push(marker);
    //                    if(i > 0) {
    //                        var midmarker = setmidmarkers(polyPoints.getAt(i));
    //                        midmarkers.push(midmarker);
    //                    }
                    }
                }
                bEditing = true;            
            }
        }
    }
}       
   
        

    
// function editlines(){
//    if(bEditing !== false){
//        
//        polyLineParcours.setEditable(false);
//        bEditing = false;
//        $( "span.icon32ShowPoint" ).toggleClass( "icon32ShowPointAct" );
//        
//    }else{
//        
//        //On s'assure qu'une trace est bien chargée
//        if (typeof polyLineParcours !== 'undefined') {
//            $( "span.icon32ShowPoint" ).toggleClass( "icon32ShowPointAct" );
//            polyLineParcours.setEditable(true);
//            bEditing = true;
//            addDeleteButton(polyLineParcours, 'http://i.imgur.com/RUrKV.png');
//
//        }
//    }
//}       
//
//function addDeleteButton(poly, imageUrl) {
//  var path = poly.getPath();
//  path["btnDeleteClickHandler"] = {};
//  path["btnDeleteImageUrl"] = imageUrl;
//  
//  google.maps.event.addListener(poly.getPath(),'set_at',pointUpdated);
//  google.maps.event.addListener(poly.getPath(),'insert_at',pointUpdated);
//}
//
//function pointUpdated(index) {
//  var path = this;
//  var btnDelete = getDeleteButton(path.btnDeleteImageUrl);
//  
//  if(btnDelete.length === 0) 
//  {
//    var undoimg = $("img[src$='https://maps.gstatic.com/mapfiles/undo_poly.png']");
//    
//    undoimg.parent().css('height', '21px !important');
//    undoimg.parent().parent().append('<div style="overflow-x: hidden; overflow-y: hidden; position: absolute; width: 30px; height: 27px;top:21px;"><img src="' + path.btnDeleteImageUrl + '" class="deletePoly" style="height:auto; width:auto; position: absolute; left:0;"/></div>');
//    
//    // now get that button back again!
//    btnDelete = getDeleteButton(path.btnDeleteImageUrl);
//    btnDelete.hover(function() { $(this).css('left', '-30px'); return false;}, 
//                    function() { $(this).css('left', '0px'); return false;});
//    btnDelete.mousedown(function() { $(this).css('left', '-60px'); return false;});
//  }
//  
//  // if we've already attached a handler, remove it
//  if(path.btnDeleteClickHandler) 
//    btnDelete.unbind('click', path.btnDeleteClickHandler);
//    
//  // now add a handler for removing the passed in index
//  path.btnDeleteClickHandler = function() {
//    path.removeAt(index); 
//    return false;
//  };
//  btnDelete.click(path.btnDeleteClickHandler);
//}
//
//function getDeleteButton(imageUrl) {
//  return  $("img[src$='" + imageUrl + "']");
//}
//    
    function toggleHideShowParcours() {
        
        if (typeof polyLineParcours !== 'undefined') {
            console.log('polyLineParcours is defined');       
            if(polyLineParcours.visible){
                polyLineParcours.setMap(null);
                polyLineParcours.setVisible(false);
            }else{
                polyLineParcours.setMap(mapcontainerMap);
                mapcontainerMap.fitBounds(bounds);
                polyLineParcours.setVisible(true);
            }
        }else{
            $.ajax({
                dataType: "json",
                url: "index.php?:nav=parcours::ajaxPointOfPoly&iParcoursId="+idParcours,
                success: function(data) {
                        if(data.etat==='OK'){
                           MakePoly(data.reponse);
                        }
                    }
                });
        }
    }
    

    
    function MakePoly(tCoords ){
        var myPoints = tCoords ;
            polyLineParcours = new g.Polyline({
             // use your own style here
                path: myPoints,
                strokeColor: "#FF00AA",
                strokeOpacity: .7,
                strokeWeight: 4,
                clickable: false
                });

            bounds = new g.LatLngBounds();           
            for(var i = 1; i < myPoints.length; i++){
            bounds.extend(new g.LatLng(myPoints[i].lat,myPoints[i].lng));
        }
        polyLineParcours.setMap(mapcontainerMap);
        mapcontainerMap.fitBounds(bounds);
    }
    
    function addRelais(){
        showCategory('relaisSpot');
        if(polyLineParcours.get('clickable')){
            polyLineParcours.setOptions({clickable: false});
            $("button#ajoutRelais").text('Ajouter un relais');
            
            if ($("button#btnRelais").text()=== 'Afficher les relais'){
                $("button#btnRelais").text('Masquer les relais');
            }
            g.event.clearListeners(polyLineParcours, 'click');
        }else{
            $("button#ajoutRelais").text('Arrêter d\'ajouter des relais');
            polyLineParcours.setOptions({clickable: true});                
            g.event.addListener(polyLineParcours, 'click', function(event){
                var Lat=event.latLng.lat();
                var Lng=event.latLng.lng();
                var relaisPos = new g.LatLng(Lat, Lng);
                var address=geocodeAddress(relaisPos);
                var content = 'Latitude: ' + Lat + '<br />Longitude: ' + Lng + '<br />Adresse: '+ address;
                    content += '<br /><input type = "button" value = "Delete" onclick = "DeleteMarker(\'marker_'+gmarkers.length+'\');" />';
                addMarker(relaisPos,'Position '+gmarkers.length,content,'relaisSpot',markerRelais,mapcontainerMap)
                geocodePosition(relaisPos);                                        
            });
        }        
    }
    
    function addSpot(){
        showCategory('chasubleSpot');
        if(polyLineParcours.get('clickable')){
            polyLineParcours.setOptions({clickable: false});
            $("button#ajoutSign").text('Ajouter un signaleur');            
            if ($("button#btnSignaleur").text()=== 'Afficher les signaleurs'){
                $("button#btnSignaleur").text('Masquer les signaleurs');
            }
            g.event.clearListeners(polyLineParcours, 'click');
        }else{
                $("button#ajoutSign").text('Arrêter d\'ajouter des signaleur');
            
            polyLineParcours.setOptions({clickable: true});                
            g.event.addListener(polyLineParcours, 'click', function(event){
                var Lat=event.latLng.lat();
                var Lng=event.latLng.lng();
                var signaleurPos = new g.LatLng(Lat, Lng);
                var address=geocodeAddress(signaleurPos);
                var content = 'Latitude: ' + Lat + '<br />Longitude: ' + Lng + '<br />Adresse: '+ address;
                    content += '<br /><input type = "button" value = "Delete" onclick = "DeleteMarker(\'marker_'+gmarkers.length+'\');" />';
                addMarker(signaleurPos,'Position '+gmarkers.length,content,'chasubleSpot',markerChasuble,mapcontainerMap)
                geocodePosition(signaleurPos);                                        
            });
        }
    }
    
    
    
    
    
    
    function clickShowVolon(){
		/*var classList = $(".icon32ShowBenev").attr('class');
		console.log("hello world : "+ classList);
		var n = classList.search("icon32ShowBenevAct"); */
		$( "span.icon32ShowBenev" ).toggleClass( "icon32ShowBenevAct" );			

        //toggleHideShowMarker('volontaires');            
    }       
    function clickShowParcours(){
       $( "#clickShowParcours" ).toggleClass( "icon32ShowParcours icon32ShowParcoursAct" );
        toggleHideShowParcours();            
    }       
    function clickShowSignaleur(){
       $( "span.icon32ShowSignaleurs" ).toggleClass( "icon32ShowSignaleursAct" );
        toggleHideShowMarker('chasubleSpot');            
    }
    function clickShowRelais(){        
       $( "span.icon32ShowRelais" ).toggleClass( "icon32ShowRelaisAct" );
        toggleHideShowMarker('relaisSpot');            
    }
	function clickShowPatrouilles(){
       $( "span.icon32ShowPatrouilles" ).toggleClass( "icon32ShowPatrouillesAct" );
        toggleHideShowMarker('patrouille');            
    }
    function clickShowAnimations(){        
       $( "span.icon32ShowAnimations" ).toggleClass( "icon32ShowAnimationsAct" );
        toggleHideShowMarker('animation');            
    }	
	function clickShowStands(){        
       $( "span.icon32ShowStands" ).toggleClass( "icon32ShowStandsAct" );
        toggleHideShowMarker('stand');            
    }

	/*Les Actions Sur la Carte*/	
	
	function clickAddRelais(){        
       $( "span.icon32RelaisNew" ).toggleClass( "icon32RelaisNewAct" );
		activeLogo();
	   $( "span.icon32RelaisNew" ).addClass("activ");
    }
	function clickAddChasuble(){        
		   $( "span.icon32ChasubleNew" ).toggleClass( "icon32ChasubleNewAct" );
		   activeLogo();
		   $( "span.icon32ChasubleNew" ).addClass("activ");
		}
	function clickAddPm(){        
		$( "span.icon32PmNew" ).toggleClass( "icon32PmNewAct" );
		activeLogo();
		$( "span.icon32PmNew" ).addClass("activ");
		}
	function clickAddAnim(){        
		$( "span.icon32AnimNew" ).toggleClass( "icon32AnimNewAct" );
		activeLogo();
		$( "span.icon32AnimNew" ).addClass("activ");
		                 
		}
	function clickAddStand(){        
		$( "span.icon32OmssNew" ).toggleClass( "icon32OmssNewAct" );
		activeLogo();
		$( "span.icon32OmssNew" ).addClass("activ");
		                  
		}
	function clickRemoveRelais(){        
		$( "span.icon32RelaisDel" ).toggleClass( "icon32RelaisDelAct" );
		activeLogo();
		$( "span.icon32RelaisDel" ).addClass("activ");
		                  
		}
	function clickRemoveChasuble(){        
		$( "span.icon32ChasubleDel" ).toggleClass( "icon32ChasubleDelAct" );
		activeLogo();
		$( "span.icon32ChasubleDel" ).addClass("activ");
		                  
		}
	function clickRemovePm(){        
		$( "span.icon32PmDel" ).toggleClass( "icon32PmDelAct" );
		activeLogo();
		$( "span.icon32PmDel" ).addClass("activ");
		                  
		}
	function clickRemoveAnim(){        
		$( "span.icon32AnimDel" ).toggleClass( "icon32AnimDelAct" );
		activeLogo();
		$( "span.icon32AnimDel" ).addClass("activ");
		                  
		}
	function clickRemoveStand(){        
		$( "span.icon32OmssDel" ).toggleClass( "icon32OmssDelAct" );
		activeLogo();
		$( "span.icon32OmssDel" ).addClass("activ");
		                  
		}
	function clickShowPoints(){        
		$( "span.icon32ShowPoint" ).toggleClass( "icon32ShowPointAct" );		                  
		}
	function clickAddLastPoint(){        
		$( "span.icon32AddLastPoint" ).toggleClass( "icon32AddLastPointAct" );
		activeLogo();
		$( "span.icon32AddLastPoint" ).addClass("activ");
		
		}
	function clickRemoveLastPoint(){        
		$( "span.icon32DelLastPoint" ).toggleClass( "icon32DelLastPointAct" );
		activeLogo();
		$( "span.icon32DelLastPoint" ).addClass("activ");
		                  
		}
	function clickAddBetPoint(){        
		$( "span.icon32AddBetweenPoint" ).toggleClass( "icon32AddBetweenPointAct" );
		activeLogo();
		$( "span.icon32AddBetweenPoint" ).addClass("activ");
		                  
		}
	function clickRemoveBetPoint(){        
		$( "span.icon32DelBetweenPoint" ).toggleClass( "icon32DelBetweenPointAct" );
		activeLogo();
		$( "span.icon32DelBetweenPoint" ).addClass("activ");
		                  
		}
	function activeLogo(){
		$( "span.activ").removeClass( function() { /* Matches even table-col-row */
			 var toReturn = '',
				 classes = this.className.split(' ');
			 for(var i = 0; i < classes.length; i++ ) {
				 if( /icon32[a-zA-Z]+Act/.test( classes[i] ) ) { /* Filters */
					 toReturn += classes[i] +' ';
				 }
			 }
			 return toReturn ; /* Returns all classes to be removed */
		});
		$( "span.activ").removeClass("activ");
		
	} 
