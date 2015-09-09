<script type="text/javascript" src="http://maps.google.com/maps/api/js?sensor=false"></script>
<script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/1.5.0/jquery.min.js"></script>
<script type="text/javascript">
var map;
var initialize;

  function initialize() {
    map = new google.maps.Map(document.getElementById("mapCanvas"), {
      mapTypeId: google.maps.MapTypeId.TERRAIN
    });
    
    $.ajax({
     type: "GET",
     url: "<?php echo $this->sUrl; ?>",
     dataType: "xml",
     success: function(xml) {
       var points = [];
       var bounds = new google.maps.LatLngBounds ();
       $(xml).find("trkpt").each(function() {
         var lat = $(this).attr("lat");
         var lon = $(this).attr("lon");
         var p = new google.maps.LatLng(lat, lon);
         points.push(p);
         bounds.extend(p);
       });

       var poly = new google.maps.Polyline({
         // use your own style here
         path: points,
         strokeColor: "#FF00AA",
         strokeOpacity: .7,
         strokeWeight: 4
       });
       
       poly.setMap(map);
       
       // fit bounds to track
       map.fitBounds(bounds);
     }
    });
  }
</script>
<style type="text/css">
  #mapCanvas{height:<?php echo $this->iHeight?>px;}
</style>
<div class="col-sm-offset-2 col-sm-9">
                <p class="form-control-static">
<div id="mapCanvas" >
	<p>Veuillez patienter pendant le chargement de la carte...</p>
</div>
</p>
            </div> 
<script>initialize();</script>
 
    <div class="form-group">
        <div class="col-sm-offset-2 col-sm-10">
            <a class="btn btn-danger" href="<?php echo $this->getLink('events::show',array('id'=>_root::getParam('idEvent')))?>">Retour à l'évènement</a>
        </div>
    </div>
 