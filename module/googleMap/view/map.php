<script type="text/javascript" src="http://maps.google.com/maps/api/js?sensor=false"></script>

<script>
    var map;
    var poly;
var initialize;
var geocoder;


function initialize(){
	geocoder=new google.maps.Geocoder();
        
        var myStyles =[
            {
                featureType: "poi",
                elementType: "labels",
                stylers: [
                      { visibility: "off" }
                ]
            }
        ];

 
	var latLng = new google.maps.LatLng(45.4333,4.4)//Correspond au coordonnées de Saint-Etienne (48.87151859999999, 2.3422328000000334); // Correspond au coordonnées de Lille
	var myOptions = {
	zoom      : <?php echo $this->iZoom?>,
	center    : latLng,
        draggable: <?php echo $this->sEnableDraggable?>, //Déplacement à la souris
	mapTypeId : google.maps.MapTypeId.TERRAIN, // Type de carte, différentes valeurs possible HYBRID, ROADMAP, SATELLITE, TERRAIN
	maxZoom   : <?php echo $this->iMaxZoom?>,
        minZoom : <?php echo $this->iMinZoom?>,
        disableDefaultUI : <?php echo $this->sDisableDefaultUI?>, //Affiche l'ensemble des controles
        mapTypeControl : <?php echo $this->sEnableMapTypeControl?>, // SATELLITE ou TERRAIN
        streetViewControl : <?php echo $this->sEnableStreetViewControl?>, //Bonhomme de StreeView
        panControl : <?php echo $this->sEnablePanControl?>, // Panneau de déplacement
        zoomControl : <?php echo $this->sEnableZoomControl?>,             // supprime l'icône de contrôle du zoom  
        scrollwheel : <?php echo $this->sEnableScrollwheel?>,             // désactive le zoom avec la molette de la souris 
        disableDoubleClickZoom : <?php echo $this->sDisableDoubleClickZoom?>,
        styles: myStyles    // désactive le zoom sur le double-clic
	};

        
	map = new google.maps.Map(document.getElementById('map'), myOptions);  

}

function setPoint(address,sTitle,sLink){

	geocoder.geocode( { 'address': address}, function(results, status) {
	  if (status == google.maps.GeocoderStatus.OK) {
		map.setCenter(results[0].geometry.location);
		var marker = new google.maps.Marker({
			map: map,
			position: results[0].geometry.location,
			title: sTitle,
		});
		google.maps.event.addListener(marker, 'click', function() {
			document.location.href=sLink;
		});
		
		
	  }
	});

}

function setPointWithContent(address,sTitle,sContent){

	var myWindowOptions = {
		content:
			sContent
	};

	var myInfoWindow = new google.maps.InfoWindow(myWindowOptions);

	geocoder.geocode( { 'address': address}, function(results, status) {
	  if (status == google.maps.GeocoderStatus.OK) {
		map.setCenter(results[0].geometry.location);		
		
		var marker = new google.maps.Marker({
			map: map,
			position: results[0].geometry.location,
			title: sTitle,
		});
		google.maps.event.addListener(marker, 'click', function() {
			myInfoWindow.open(map,marker);
		});

                    google.maps.event.addListener(map, 'zoom_changed', function () {
                        map.setCenter(results[0].geometry.location);
                    });

	  }
	});

}
function showGpxOnMap(){
    
    $.ajax({
        //Je charge le fichier GPX au format XML
     type: "GET",
     url: "<?php echo $this->sUrlTraceGPX; ?>",
     dataType: "xml",
     success: function(xml) {
         //Initialise un tableau qui va contenir les coordonnées du tracé
       var points = [];
       // On constitu le rectangle qui va représenter la vue englobant le tracé.
       var bounds = new google.maps.LatLngBounds ();
       
       //Pour chaque point référencé dans le GPX on ajoute ces coord a point[].
       $(xml).find("trkpt").each(function() {
         var lat = $(this).attr("lat");
         var lon = $(this).attr("lon");
         // Crée un point en coordonnées géographiques
        var p = new google.maps.LatLng(lat, lon);
         //Ajoute le point de coord au tableau Points
         points.push(p);
         //Ajoute le point de coord au rectangle
         bounds.extend(p);
       });
       
       //Initialise le Polygone qui va représenter la trace sur la map
       poly = new google.maps.Polyline({
         // use your own style here
         path: points,
         strokeColor: "#FF00AA",
         strokeOpacity: .7,
         strokeWeight: 4,
         clickable: false
       });
//       Rend cette forme sur la carte spécifiée.
       poly.setMap(map);
       
       // Ajuste le zoom de la map en fonction des limites définie par le rectangle bounds
       map.fitBounds(bounds);
     }
    });
}

function test(){
    
    //--> Configuration de l'icône personnalisée
    var image = {
        // Adresse de l'icône personnalisée
        url: '../css/images/chasuble-J-36x47.png',
        // Taille de l'icône personnalisée
        size: new google.maps.Size(36, 47),
        // Origine de l'image, souvent (0, 0)
        origin: new google.maps.Point(0,0),
        // L'ancre de l'image. Correspond au point de l'image que l'on raccroche à la carte. Par exemple, si votre îcone est un drapeau, cela correspond à son mâts
        anchor: new google.maps.Point(0, 20)
    };
    
    if(poly.get('clickable')){
        poly.setOptions({clickable: false});
        alert("Un clic droit supprime l’événement click de l’objet map.");
        google.maps.event.clearListeners(poly, 'click');
    }else{
        poly.setOptions({clickable: true});
        alert(poly.get('clickable'));
        google.maps.event.addListener(poly, 'click', function(event){
            var Lat=event.latLng.lat();
            var Lng=event.latLng.lng();
            $("input#Lat").val(Lat);
            $("input#Lng").val(Lng);        
            var signaleur = new google.maps.LatLng(Lat, Lng);
            var marker = new google.maps.Marker({
                position: signaleur,
                map: map,
                flat: false,
                draggable:true,
                icon: image
            });

        });
    }
    

}

    function Volontaires(idEvent){
        $.ajax({
            type: 'GET',
            url: 'index.php?:nav=membres::ajaxGetEventMembre&idEvent='+idEvent+'',
            timeout: 3000,
            success: function(data) {
              var JSONObject = $.parseJSON(data);
              console.log(JSONObject);
              for (var key in JSONObject) {
                if (JSONObject.hasOwnProperty(key)) {
                    console.log(JSONObject[key]["idMembre"] + ", " + JSONObject[key]["nom"]);
                }
              }
          },
            error: function() {
              alert('La requête n\'a pas abouti'); }
        });
    }

</script>

 <style>
 #map{width:<?php echo $this->iWidth?>px;height:<?php echo $this->iHeight?>px;}
 </style>
<div id="map" >
	<p>Veuillez patienter pendant le chargement de la carte...</p>
</div>

<script>initialize();</script>

<?php if($this->tPosition or $this->tPositionWithContent or $this->bTraceGPX):?>
<script>
<?php 
    if($this->tPosition):
        foreach($this->tPosition as $tAdresse):
            list($sAdresse,$sTitle,$sLink)=$tAdresse;
            ?>setPoint('<?php echo $sAdresse?>','<?php echo $sTitle?>','<?php echo $sLink?>');<?php
        endforeach;
    endif;

    if($this->tPositionWithContent):
        foreach($this->tPositionWithContent as $tAdresse):
            list($sAdresse,$sTitle,$tContent)=$tAdresse;
            $sContent='';
            foreach($tContent as $sLine){
                    $sContent.=str_replace("'",'\'',$sLine);
            }
            ?>setPointWithContent('<?php echo $sAdresse?>','<?php echo $sTitle?>','<?php echo $sContent?>');
            <?php
        endforeach;
    endif;

    if($this->bTraceGPX):?> 
        window.onload=showGpxOnMap; <?php
    endif; 

?>
    
</script>
<?php endif;?>

