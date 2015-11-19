

    //var iParcours_id = <?php echo $this->oParcours->iParcours_id ;?>;
    var polyLineParcours;
    var g = google.maps;
    var iw = new g.InfoWindow();
    var map;
    //var tmpPolyLine;
    var startMarker;
    var markers = [];
    var midmarkers = [];
    var polyPoints = [];
    var pointsArray = [];
    var toolID = 1;
    var mylistenerTemp;
    var bEditing = false;
    var bDelete = false;
    var bRemoveChasuble = false;
    var bAddChasuble = false;
    var bVisibleChasuble = false;
    var tPointSup =[];
    
    


    var markerdefault = {
        url: 'http://maps.gstatic.com/mapfiles/markers2/marker.png',
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
        origin: new g.Point(32,0),
        anchor: new g.Point(16, 38)
    };
    
    var markerOmss = {
        url: './css/images/Markers.png',
        size: new g.Size(32,38),
        origin: new g.Point(32,0),
        anchor: new g.Point(16, 38)
    };
    
    var markerPM = {
        url: './css/images/Markers.png',
        size: new g.Size(32,38),
        origin: new g.Point(0,38),
        anchor: new g.Point(16, 38)
    };

    var markerChasuble = {
        url: './css/images/Markers.png',
        size: new g.Size(32, 38),
        origin: new g.Point(32,38),
        anchor: new g.Point(16, 38)
    };        

    var markerHome = {
        url: './css/images/Markers.png',
        size: new g.Size(32,38),
        origin: new g.Point(64,38),
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
    
    function addMarkerSub(latlng,title,content,category,icon,currentmap,id) {
        var marker = new google.maps.Marker({
        map:  currentmap,
        title : title,
        icon:  icon,
        position: latlng
        });
        if (id) marker.id = id; else marker.id = 'marker_'+gmarkers.length;
        var html = '<div style="text-align:left;" class="infoGmaps" id= '+marker.id+'>'+content+'</div>';
        arrayListner[id] = google.maps.event.addListener(marker, "click", function() {
            if (infowindow) infowindow.close();
            $.ajax({  
                url: "index.php?:nav=parcours::ajaxShowMemberSpot&idPoint="+id+"&idEvent="+iEvent_id,
                dataType : 'html',
                success: function(data) {  
                    iw.setContent('<div style="text-align:left;" class="infoGmaps">'+data+'</div>');  
                    iw.open(map, marker.id);  
                }  
            });  
        });
        marker.mycategory = category;
        
        gmarkers.push(marker);
        oms.addMarker(marker);
        
    }
    
    function clickShowVolon(){
        var arr = false;
        var catego = "markerHome";
        // On vérifie que le tableau gmarkers ne contienne pas déjà les Marker "markerHome"
        jQuery.map(gmarkers,function (marker) {
            if (marker.mycategory === catego) {
                arr = true;
            }
        });            
        //S'ils ne sont pas présent on interroge le serveur    
        if (!arr) {
            getVolon();
            
        }else{
            toggleHideShowMarker(catego);
        }
        $( "span.icon32ShowBenev" ).toggleClass( "icon32ShowBenevAct" );
    }
    
    function clickShowFreeVolon(){
        var arr = false;
        var catego = "markerHomeFree";
        // On vérifie que le tableau gmarkers ne contienne pas déjà les Marker "markerHome"
        jQuery.map(gmarkers,function (marker) {
            if (marker.mycategory === catego) {
                arr = true;
            }
        });            
        //S'ils ne sont pas présent on interroge le serveur    
        if (!arr) {
            getFreeVolon();
            
        }else{
            toggleHideShowMarker(catego);
        }
        $( "span.icon32ShowBenevFree" ).toggleClass( "icon32ShowBenevFreeAct" );
    }  
    
    function clickShowParcours(){
       if (typeof polyLineParcours !== 'undefined') {
            toggleHideShowParcours();            
        }else{
            getParcours();
        }         
       $( "#clickShowParcours" ).toggleClass( "icon32ShowParcours icon32ShowParcoursAct" );                   
    } 
    
    function clickShowRelais(){
        var arr = false;
        var catego = "markerRelais";
        // On vérifie que le tableau gmarkers ne contienne pas déjà les Marker "markerHome"
        jQuery.map(gmarkers,function (marker) {
            if (marker.mycategory === catego) {
                arr = true;
            }
        });            
        //S'ils ne sont pas présent on interroge le serveur s    
        if(!arr){
            getPoints(catego);            
        }else{
            toggleHideShowMarker(catego);
        }               
        $( "span.icon32ShowRelais" ).toggleClass( "icon32ShowRelaisAct" );
 
    }
    
    function clickShowSignaleur(){
        var arr = false;
        var catego = "markerChasuble";
        // On vérifie que le tableau gmarkers ne contienne pas déjà les Marker "markerHome"
        jQuery.map(gmarkers,function (marker) {
            if (marker.mycategory === catego) {
                arr = true;
            }
        });            
        //S'ils ne sont pas présent on interroge le serveur s    
        if(!arr){
            getPoints(catego);            
        }else{
            toggleHideShowMarker(catego);
        }  
        
        if(bVisibleChasuble){
            bVisibleChasuble=false;
            $( "span.icon32ShowSignaleurs" ).removeClass( "icon32ShowSignaleursAct" );
        }else{
            bVisibleChasuble=true;
            $( "span.icon32ShowSignaleurs" ).addClass( "icon32ShowSignaleursAct" );
        }
            
        
       
                   
    }
    
    function clickShowPatrouilles(){
        var arr = false;
        var catego = "markerPM";
        // On vérifie que le tableau gmarkers ne contienne pas déjà les Marker "markerHome"
        jQuery.map(gmarkers,function (marker) {
            if (marker.mycategory === catego) {
                arr = true;
            }
        });            
        //S'ils ne sont pas présent on interroge le serveur s    
        if(!arr){
            getPoints(catego);            
        }else{
            toggleHideShowMarker(catego);
        }
       $( "span.icon32ShowPatrouilles" ).toggleClass( "icon32ShowPatrouillesAct" );
         
    }
    function clickShowAnimations(){
        var arr = false;
        var catego = "markerAnim";
        // On vérifie que le tableau gmarkers ne contienne pas déjà les Marker "markerHome"
        jQuery.map(gmarkers,function (marker) {
            if (marker.mycategory === catego) {
                arr = true;
            }
        });            
        //S'ils ne sont pas présent on interroge le serveur s    
        if(!arr){
            getPoints(catego);            
        }else{
            toggleHideShowMarker(catego);
        }
       $( "span.icon32ShowAnimations" ).toggleClass( "icon32ShowAnimationsAct" );
         
    }	
    function clickShowStands(){
        var arr = false;
        var catego = "markerOmss";
        // On vérifie que le tableau gmarkers ne contienne pas déjà les Marker "markerHome"
        jQuery.map(gmarkers,function (marker) {
            if (marker.mycategory === catego) {
                arr = true;
            }
        });            
        //S'ils ne sont pas présent on interroge le serveur s    
        if(!arr){
            getPoints(catego);            
        }else{
            toggleHideShowMarker(catego);
        }
       $( "span.icon32ShowStands" ).toggleClass( "icon32ShowStandsAct" );
          
    }
    
    
   
    /*
     * Interroge la Base de donnée afin d'obtenir les positions de membres participant à l'évènement
     * 
     */
    function getVolon(){
        $.ajax({
            dataType: "json",
            url: "index.php?:nav=parcours::ajaxGetPositionMembers&iParcoursId="+iParcours_id,
            success: function(data) {
                    if(data.etat==='OK'){                           
                    listMembers = data.reponse;
                    for(var i = 0; i < listMembers.length; i++){
                        idMem = listMembers[i].idMembre;

                        latlng = new g.LatLng(listMembers[i].lat,listMembers[i].lng);
                        icon = markerHome;
                        category = 'markerHome';
                        currentmap = mapcontainerMap;
                        id = category +"_"+ listMembers[i].idMembre;
                        title = id;  
                        content = listMembers[i].nom +' '+ listMembers[i].prenom + '( '+idMem+' )';

                        addMarker(latlng,title,content,category,icon,currentmap,id);
                        
                    }

                    
                }
                //On affiche le panneau seulement lorsque tous les Marker on été créé
                ActiverSelect();
            }
        });
    }
  
/*
     * Interroge la Base de donnée afin d'obtenir les positions de membres participant à l'évènement
     * 
     */
    function getFreeVolon(){
        $.ajax({
            dataType: "json",
            url: "index.php?:nav=parcours::ajaxGetPositionAllMembersFree&iParcoursId="+iParcours_id,
            success: function(data) {
                    if(data.etat==='OK'){                           
                    listMembers = data.reponse;
                    for(var i = 0; i < listMembers.length; i++){
                        idMem = listMembers[i].idMembre;

                        latlng = new g.LatLng(listMembers[i].lat,listMembers[i].lng);
                        icon = markerHome;
                        category = 'markerHomeFree';
                        currentmap = mapcontainerMap;
                        id = category +"_"+ listMembers[i].idMembre;
                        title = id;  
                        content = listMembers[i].nom +' '+ listMembers[i].prenom + '( '+idMem+' )';

                        addMarker(latlng,title,content,category,icon,currentmap,id);
                        
                    }

                    
                }
                //On affiche le panneau seulement lorsque tous les Marker on été créé
                ActiverSelect();
            }
        });
    }
  
    
    function getPoints(typeofpoint){
        switch(typeofpoint){
            case 'markerChasuble' :
                typeofpointId = 1;
                icon = markerChasuble;
                category = 'markerChasuble';
            break;
            case 'markerRelais' :
                typeofpointId = 2;
                icon = markerRelais;
                category = 'markerRelais';
                break
            case 'markerPM' :
                typeofpointId = 3;
                icon = markerPM;
                category = 'markerPM';
                break;
            case 'markerOmss' :
                typeofpointId = 4;
                icon = markerOmss;
                category = 'markerOmss';
                break;
            case 'markerAnim' :
                typeofpointId = 5;
                icon = markerAnim;
                category = 'markerAnim';
                break;
            default :
                typeofpointId = 4;
                icon = markerOmss;
                category = 'markerOmss';
        }
        
        $.ajax({
        dataType: "json",
        url: "index.php?:nav=parcours::ajaxGetMarker&iParcoursId="+iParcours_id+"&typeofpointId="+typeofpointId,
        success: function(data) {
                if(data.etat==='OK'){
                    var listPoints = data.reponse
                    for(var i = 0; i < listPoints.length; i++){                        
                        title = listPoints[i].name;
                        latlng = new g.LatLng(listPoints[i].lat,listPoints[i].lng);            
                        currentmap = mapcontainerMap;
                        id = listPoints[i].idPoint;
                        content = '';
                        addMarker(latlng,title,content,category,icon,currentmap,id);                        
                    }
                    
                }
            }
        });
    }
        
    function getParcours() {
        
        $.ajax({
            dataType: "json",
            url: "index.php?:nav=parcours::ajaxPointOfPoly&iParcoursId="+iParcours_id,
            success: function(data) {
                if(data.etat==='OK'){                           
                    var myPoints = data.reponse ;
                    polyLineParcours = new g.Polyline({
                     // use your own style here
                        path: myPoints,
                        strokeColor: "#FF00AA",
                        strokeOpacity: .7,
                        strokeWeight: 4,
                        clickable: false
                        });
                    bounds = new g.LatLngBounds();           
                    for(var i = 0; i < myPoints.length; i++){
                        bounds.extend(new g.LatLng(myPoints[i].lat,myPoints[i].lng));
                    }
                    polyLineParcours.setMap(mapcontainerMap);
                    mapcontainerMap.fitBounds(bounds);
                }
            }
        });
        
    }
    
    function toggleHideShowParcours(){
        if(polyLineParcours.visible){
            polyLineParcours.setMap(null);
            polyLineParcours.setVisible(false);
        }else{
            polyLineParcours.setMap(mapcontainerMap);
            mapcontainerMap.fitBounds(bounds);
            polyLineParcours.setVisible(true);
        }
    }
    
/*Les Actions Sur la Carte*/	
	
    function clickAddRelais(){        
       $( "span.icon32RelaisNew" ).toggleClass( "icon32RelaisNewAct" );
		activeLogo();
	   $( "span.icon32RelaisNew" ).addClass("activ");
    }
    function clickAddChasuble(){
        if (typeof polyLineParcours !== 'undefined') {
            if(polyLineParcours.visible){
                if(bVisibleChasuble){
                    if(bAddChasuble){
                        bAddChasuble=false;
                        addSpot();
                        $( "span.icon32ChasubleNew" ).removeClass( "icon32ChasubleNewAct" );
                        $( "span.icon32ChasubleNew" ).removeClass("activ");
                        
                    }else{
                        bAddChasuble=true;
                        addSpot();
                        $( "span.icon32ChasubleNew" ).addClass( "icon32ChasubleNewAct" );
                        $( "span.icon32ChasubleNew" ).addClass("activ");
                        
                    }		   
                }else{
                    alert('Afficher en premier les Signaleurs');
                }	
            }else{
            alert('Afficher en premier le parcours');
        }
        }else{
            alert('Afficher en premier le parcours');
        }
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
            if(bVisibleChasuble){            
                
                if(bRemoveChasuble){
                    bRemoveChasuble=false;
                    $( "span.icon32ChasubleDel" ).removeClass( "icon32ChasubleDelAct" );
                    $( "span.icon32ChasubleDel" ).removeClass("activ");
                    RemoveChasuble();
                }else{
                    bRemoveChasuble=true;
                    $( "span.icon32ChasubleDel" ).addClass( "icon32ChasubleDelAct" );
                    $( "span.icon32ChasubleDel" ).addClass("activ");
                    RemoveChasuble();
                }	
		//activeLogo();
		
            }else{
                alert('Afficher en premier les Signaleurs');
            }
		                  
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
                
        /*
         * Désactive les Boutons qui ne peuvent/doivent pas être actifs ensemble
         * @returns {undefined}
         */
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
    /*
     * Afficher le Panneau Latéral Droit
     * Ajouter l'action de relation entre les marker et le select
     */   
    function ActiverSelect(){
      
        for (var i=0; i<gmarkers.length; i++) {            
            if (gmarkers[i].mycategory === 'markerHome') {  
                
                gmarkers[i].addListener('click', function() {
                    idMember = this.id.substring(11);                    
                    $('#ListName option[value="'+idMember+'"]').prop('selected', true);
                    showMarkerVolon();
                });
            }
        }
        $('#rightcolumn').show();
        $('#AdresseTextArea').val('');
        $('#CommentTextArea').val('');
        $("#ListName").removeAttr('disabled');
        $("#CommentTextArea").removeAttr('disabled');
        $('#ListName').change(function() {
            showMarkerVolon();
        });
        
        
    }
    
    // Affiche et centre le volontaire choisie dans le select, ainsi que sont InfoView.
   
    function showMarkerVolon() {
        var idMember = $("#ListName option:selected").val();
        $("#ListName option:selected").dblclick(function(){
            $("#ListName option:selected").removeAttr('selected');
            hideMarkerVolon(idMember);
        });
        
        $.ajax({
        dataType: "json",
        url: "index.php?:nav=parcours::ajaxGetInfoMember&idMember="+idMember,
        success: function(data) {
                if(data.etat==='OK'){
                    var detail = data.reponse[0];
                    html = detail.nom +' '+ detail.prenom + '( '+detail.idMembre+' )';
                    $('#AdresseTextArea').val(detail.adresse);
                    $('#CommentTextArea').val(detail.comment);
                    for (var i=0; i<gmarkers.length; i++) {
                        if (gmarkers[i].id == 'markerHome_'+idMember) {
                            mapcontainerMap.setCenter(gmarkers[i].position);
                            if (infowindow) infowindow.close();
                            infowindow = new google.maps.InfoWindow({content: html,disableAutoPan: false});
                            infowindow.open(currentmap,gmarkers[i]);
                        }

                    }
                }
            }
        });
    }
  
    function RemoveChasuble(){
        if(bRemoveChasuble){
                suppClick('markerChasuble'); //On supprime tout les évènements click sur les Marker de categorie markerChasuble
                for (var i=0; i<gmarkers.length; i++) {            
                    if (gmarkers[i].mycategory === 'markerChasuble') {  //Pour chaque markerChasuble on ajoute une nouvelle action Click
                        gmarkers[i].addListener('click', function() {
                            tPointSup.push(this.id.substring(15)); //On capitalise les id des points supprimés.
                            this.setMap(null);  //On masque le Marker
                            gmarkers.splice(this.id,1); //On le supprime du array des marker                            
                        });
                    }
                }
            }else{                
                suppClick('markerChasuble');//On supprime tout les évènements click sur les Marker de categorie markerChasuble
                sendRemovePoint();//On lance la purge en base.
            }        
            
    }
    
    function suppClick(category){
        for (var i=0; i<gmarkers.length; i++) {            
            if (gmarkers[i].mycategory === category) {
                g.event.clearListeners(gmarkers[i], 'click');                        
            }
        }
    }
    
    function hideMarkerVolon(idMember) {
        //hideCategory('markerHome');
        id = 'markerHome_'+idMember;
        for (var i=0; i<gmarkers.length; i++) {
            if (gmarkers[i].id == id) {
                gmarkers[i].setVisible(false);
            }
        }
        $('#AdresseTextArea').val('');
        $('#CommentTextArea').val('');
    }
    
    function centerOnMarkerHome(){        
        var idMember = $("#ListName option:selected").val();
        if ((typeof idMember !== 'undefined')){
            for (var i=0; i<gmarkers.length; i++) {
                if (gmarkers[i].id == 'markerHome_'+idMember) {
                    mapcontainerMap.setCenter(gmarkers[i].position);
                    gmarkers[i].setVisible(true);
                }

            }
        }
    }
    
    
 //   Actions d'ajout de Marker

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
            $("button#ajoutRelais").text('Arràªter d\'ajouter des relais');
            polyLineParcours.setOptions({clickable: true});                
            g.event.addListener(polyLineParcours, 'click', function(event){
                var Lat=event.latLng.lat();
                var Lng=event.latLng.lng();
                var relaisPos = new g.LatLng(Lat, Lng);
                var content = 'Latitude: ' + Lat + '<br />Longitude: ' + Lng ;
                    content += '<br /><input type = "button" value = "Delete" onclick = "DeleteMarker(\'marker_'+gmarkers.length+'\');" />';
                addMarker(relaisPos,'Position '+gmarkers.length,content,'relaisSpot',markerRelais,mapcontainerMap)
                geocodePosition(relaisPos);                                        
            });
        }        
    }
    
    function addSpot(){
        
        if(polyLineParcours.get('clickable')){
            polyLineParcours.setOptions({clickable: false});
            g.event.clearListeners(polyLineParcours, 'click');
        }else{
            polyLineParcours.setOptions({clickable: true});                
            g.event.addListener(polyLineParcours, 'click', function(event){
                var Lat=event.latLng.lat();
                var Lng=event.latLng.lng();
                var latlng = new g.LatLng(Lat, Lng);
                var title = 'Position '+gmarkers.length;                
                var category= markerChasuble + gmarkers.length;
                var icon = markerChasuble;
                var id = gmarkers.length;
                var currentmap = mapcontainerMap;
                var content = '<div id="TabOfSpot"  ><table><tr><th class="Editable" ondblclick="editNameOfSpot();">Position : 2</th></tr><tr><td>Marcel Buttner</td></tr></table></div>';
                
                $.ajax({
                    type: "POST",
                    url: "index.php?:nav=parcours::ajaxAddPoints",
                    data: {sLatVal : Lat,
                            sLngVal: Lng,
                            iParcours_id: iParcours_id,
                            iTypeofpoint_id: 1 
                            }, 
                    cache: false,
                    success: function(data){
                        id=data.idPoint;
                        addMarker(latlng,title,content,category,icon,currentmap,id);
                    }
                });
                
                                  
            });
        }
    }
    
    function sendRemovePoint(){
        var jsonString = JSON.stringify(tPointSup);
        $.ajax({
            type: "POST",
            url: "index.php?:nav=parcours::ajaxDelPoints",
            data: {tPoints : jsonString}, 
            cache: false,

            success: function(){
                tPointSup = [];
            }
        });
    }
    
    function editNameOfSpot(){
        var currentEle = $("#TabOfSpot .Editable");
		value = currentEle.text();
        $(currentEle).html('<input class="thVal" type="text" value="' + value + '" />');
		$(".thVal").focus();
		$(".thVal").keyup(function (event) {
		if (event.keyCode == 13) {
				  $(currentEle).html($(".thVal").val().trim());
			  }
		  });
        
    }