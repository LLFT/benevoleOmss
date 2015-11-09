<?php

/***************************************************************
 * Copyright notice
 *
 * (c) 2013 Yohann CERDAN <cerdanyohann@yahoo.fr>
 * All rights reserved
 *
 * This script is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
 * GNU General Public License for more details.
 *
 * This copyright notice MUST APPEAR in all copies of the script!
 ***************************************************************/

/**
 * Class to use the Google Maps v3 API
 *
 * @author Yohann CERDAN <cerdanyohann@yahoo.fr>
 */
class My_GoogleMapAPI {
    /** GoogleMap ID for the HTML DIV and identifier for all the methods (to have several gmaps) **/
    protected $googleMapId = 'googlemapapi';

    /** GoogleMap  Direction ID for the HTML DIV **/
    protected $googleMapDirectionId = 'route';

    /** Width of the gmap **/
    protected $width = '';

    /** Height of the gmap **/
    protected $height = '';

//    /** Icon width of the gmarker **/
//    protected $iconWidth = 20;
//
//    /** Icon height of the gmarker **/
//    protected $iconHeight = 34;

//    /** Icon width of the gmarker **/
//    protected $iconAnchorWidth = 0;
//
//    /** Icon height of the gmarker **/
//    protected $iconAnchorHeight = 0;

    /** Infowindow width of the gmarker **/
    protected $infoWindowWidth = 250;

    /** Default zoom of the gmap **/
    protected $zoom = 9;
    
    /** Default maximum zoom of the gmap **/
    protected $iMaxZoom = 24;
    
    /** Default minimum zoom of the gmap **/
    protected $iMinZoom = 0;

    /** Enable the zoom of the Infowindow **/
    protected $enableWindowZoom = FALSE;

    /** Default zoom of the Infowindow **/
    protected $infoWindowZoom = 6;

    /** Lang of the gmap **/
    protected $lang = 'fr';

    /**Center of the gmap **/
    protected $center = 'Paris France';

    /** Content of the HTML generated **/
    protected $content = '';

    /** Hide the marker by default **/
    protected $defaultHideMarker = FALSE;

    /** Extra content (marker, etc...) **/
    protected $contentMarker = '';

    /** Use clusterer to display a lot of markers on the gmap **/
    protected $useClusterer = FALSE;
    protected $gridSize = 100;
    protected $maxZoom = 9;
    protected $clustererLibrarypath = 'http://google-maps-utility-library-v3.googlecode.com/svn/tags/markerclusterer/1.0.2/src/markerclusterer_compiled.js';

    /** Enable automatic center/zoom **/
    protected $enableAutomaticCenterZoom = FALSE;

    /** maximum longitude of all markers **/
    protected $maxLng = -1000000;

    /** minimum longitude of all markers **/
    protected $minLng = 1000000;

    /** max latitude of all markers **/
    protected $maxLat = -1000000;

    /** min latitude of all markers **/
    protected $minLat = 1000000;
    
    /** default Latitude **/
    protected $fDefaultLat =48.8792;
    
    /** default Latitude **/
    protected $fDefaultLng =2.34778;

    /** map center latitude (horizontal), calculated automatically as markers are added to the map **/
    protected $centerLat = NULL;

    /** map center longitude (vertical),  calculated automatically as markers are added to the map **/
    protected $centerLng = NULL;

    /** factor by which to fudge the boundaries so that when we zoom encompass, the markers aren't too close to the edge **/
    protected $coordCoef = 0.01;

    /** Type of map to display **/
    protected $mapType = 'ROADMAP';

    /** Include the JS or not (if you have multiple maps **/
    protected $includeJs = TRUE;

    /** Enable geolocation and center map **/
    protected $enableGeolocation = FALSE;
    
    /** Enable load XML File **/
    protected $enableParcours = FALSE;
    
      /** Enable load XML File **/
    protected $sShowImmediatParcours = FALSE;
    
    
    
    /** Enable StreetView logo **/
    protected $sEnablestreetViewControl = 'false';
    

    /** XML File **/
    protected $coords = NULL;
    
    protected $iParcours_id = NULL;
    protected $iEvent_id = NULL;

    
    /**
     * Class constructor
     */
    public function __construct() {
    }

    /**
     * Set the useClusterer parameter (optimization to display a lot of marker)
     *
     * @param boolean $useClusterer         use cluster or not
     * @param int     $gridSize             grid size (The grid size of a cluster in pixel.Each cluster will be a square.If you want the algorithm to run faster, you can set this value larger.The default value is 100.)
     * @param int     $maxZoom              maxZoom (The max zoom level monitored by a marker cluster.If not given, the marker cluster assumes the maximum map zoom level.When maxZoom is reached or exceeded all markers will be shown without cluster.)
     * @param string  $clustererLibraryPath clustererLibraryPath
     *
     * @return void
     */
    public function setClusterer($useClusterer, $gridSize = 100, $maxZoom = 9, $clustererLibraryPath = '') {
        $this->useClusterer = $useClusterer;
        $this->gridSize = $gridSize;
        $this->maxZoom = $maxZoom;
        ($clustererLibraryPath == '')
            ? $this->clustererLibraryPath = 'http://google-maps-utility-library-v3.googlecode.com/svn/tags/markerclusterer/1.0/src/markerclusterer_packed.js'
            : $this->clustererLibraryPath = $clustererLibraryPath;
    }

    /**
     * Set the type of map, can be :
     * HYBRID, TERRAIN, ROADMAP, SATELLITE
     *
     * @param string $type
     * @return void
     */
    public function setMapType($type) {
        $mapsType = array('ROADMAP', 'HYBRID', 'TERRAIN', 'SATELLITE');
        if (!in_array(strtoupper($type), $mapsType)) {
            $this->mapType = $mapsType[0];
        } else {
            $this->mapType = strtoupper($type);
        }
    }

    /**
     * Set the ID of the default gmap DIV
     *
     * @param string $googleMapId the google div ID
     *
     * @return void
     */
    public function setDivId($googleMapId) {
        $this->googleMapId = $googleMapId;
    }

    /**
     * Set the ID of the default gmap direction DIV
     *
     * @param string $googleMapDirectionId GoogleMap  Direction ID for the HTML DIV
     *
     * @return void
     */
    public function setDirectionDivId($googleMapDirectionId) {
        $this->googleMapDirectionId = $googleMapDirectionId;
    }

    /**
     * Set the size of the gmap
     *
     * @param int $width  GoogleMap  width
     * @param int $height GoogleMap  height
     *
     * @return void
     */
    public function setSize($width, $height) {
        $this->width = $width;
        $this->height = $height;
    }

    /**
     * @return mixed
     */
    public function getEnableGeolocation() {
        return $this->enableGeolocation;
    }

    /**
     * @param mixed $enableGeolocation
     */
    public function setEnableGeolocation($enableGeolocation) {
        $this->enableGeolocation = $enableGeolocation;
    }

    /**
     * Set the with of the gmap infowindow (on marker clik)
     *
     * @param int $infoWindowWidth GoogleMap  info window width
     *
     * @return void
     */
    public function setInfoWindowWidth($infoWindowWidth) {
        $this->infoWindowWidth = $infoWindowWidth;
    }

//    /**
//     * Set the size of the icon markers
//     *
//     * @param int $iconWidth  GoogleMap  marker icon width
//     * @param int $iconHeight GoogleMap  marker icon height
//     *
//     * @return void
//     */
//    public function setIconSize($iconWidth, $iconHeight) {
//        $this->iconWidth = $iconWidth;
//        $this->iconHeight = $iconHeight;
//    }

//    /**
//     * Set the size of anchor icon markers
//     *
//     * @param int $iconAnchorWidth  GoogleMap  anchor icon width
//     * @param int $iconAnchorHeight GoogleMap  anchor icon height
//     *
//     * @return void
//     */
//    public function setIconAnchorSize($iconAnchorWidth, $iconAnchorHeight) {
//        $this->iconAnchorWidth = $iconAnchorWidth;
//        $this->iconAnchorHeight = $iconAnchorHeight;
//    }

    /**
     * Set the lang of the gmap
     *
     * @param string $lang GoogleMap  lang : fr,en,..
     *
     * @return void
     */
    public function setLang($lang) {
        $this->lang = $lang;
    }

    /**
     * Set the zoom of the gmap
     *
     * @param int $zoom GoogleMap  zoom.
     *
     * @return void
     */
    public function setZoom($zoom) {
        $this->zoom = $zoom;
    }
    
     /**
     * Set the maximum zoom of the gmap
     *
     * @param int $iMaxZoom GoogleMap  maxZoom.
     *
     * @return void
     */
    public function setMaxZoom($iMaxZoom) {
        $this->iMaxZoom = $iMaxZoom;
    }
    
    /**
     * Set the minimum zoom of the gmap
     *
     * @param int $zoom GoogleMap  minZoom.
     *
     * @return void
     */
    public function setMinZoom($iMinZoom) {
        $this->iMinZoom = $iMinZoom;
    }

    /**
     * Set the zoom of the infowindow
     *
     * @param int $infoWindowZoom GoogleMap  zoom.
     *
     * @return void
     */
    public function setInfoWindowZoom($infoWindowZoom) {
        $this->infoWindowZoom = $infoWindowZoom;
    }

    /**
     * Enable the zoom on the marker when you click on it
     *
     * @param int $enableWindowZoom GoogleMap  zoom.
     *
     * @return void
     */
    public function setEnableWindowZoom($enableWindowZoom) {
        $this->enableWindowZoom = $enableWindowZoom;
    }

    /**
     * Enable theautomatic center/zoom at the gmap load
     *
     * @param int $enableAutomaticCenterZoom GoogleMap  zoom.
     *
     * @return void
     */
    public function setEnableAutomaticCenterZoom($enableAutomaticCenterZoom) {
        $this->enableAutomaticCenterZoom = $enableAutomaticCenterZoom;
    }
    
    /**
     * Set the center of the gmap (an address)
     *
     * @param float $fDefaultLat GoogleMap  center (an address)
     *
     * @return void
     */
    public function setDefaultLat($fDefaultLat){
        $this->fDefaultLat = $fDefaultLat;
    }
    
    /**
     * Set the default Longitude center of the gmap (an address)
     *
     * @param float $fDefaultLng GoogleMap  center (an address)
     *
     * @return void
     */
    public function setDefaultLng($fDefaultLng){
        $this->fDefaultLng = $fDefaultLng;
    }
    
    
    /**
     * Set the center of the gmap (an address)
     *
     * @param string $center GoogleMap  center (an address)
     *
     * @return void
     */
    public function setCenter($center) {
        $this->center = $center;
    }

    /**
     * Set the center of the gmap (a lat and lng)
     *
     * @param float $fLat
     * @param float $fLng
     *
     * @return void
     */
    public function setCenterLatLng($fLat, $fLng) {
        $this->centerLatLng = 'new google.maps.LatLng(' . $fLat . ', ' . $fLng . ')';
    }


    /**
     * Set the defaultHideMarker
     *
     * @param boolean $defaultHideMarker hide all the markers on the map by default
     *
     * @return void
     */
    public function setDefaultHideMarker($defaultHideMarker) {
        $this->defaultHideMarker = $defaultHideMarker;
    }

    /**
     * Set the includeJs
     *
     * @param boolean $includeJs do not include JS
     *
     * @return void
     */
    public function setincludeJs($includeJs) {
        $this->includeJs = $includeJs;
    }
    
    /**
     * Set the sEnablestreetViewControl
     *
     * @param boolean $sEnablestreetViewControl GoogleMap  streetViewControl
     *
     * @return void
     */
    public function setStreetViewControl($bEnablestreetViewControl) {
        if ($bEnablestreetViewControl){
            $this->sEnablestreetViewControl = 'true';
        }
    }
    
    /**
     * Set the sShowImmediatParcours
     *
     * @param boolean $sShowImmediatParcours GoogleMap  setMap , fitBounds
     *
     * @return void
     */
    
    public function setShowImmediatParcours($bshowImmediatParcours){
        if ($bshowImmediatParcours){
            $this->sShowImmediatParcours = 'true';
        }
    }
    
    public function setParcours_id($iParcours_id) {
        
        $this->iParcours_id = $iParcours_id;
        
    }
    
    public function setEvent_id($iEvent_id) {
        
        $this->iEvent_id = $iEvent_id;
        
    }

    /**
     * Get the google map content
     *
     * @return string the google map html code
     */
    public function getGoogleMap() {
        return $this->content;
    }

    /**
     * Get URL content using cURL.
     *
     * @param string $url the url
     *
     * @return string the html code
     *
     * @todo add proxy settings
     */
    public function getContent($url) {
        $curl = curl_init();
        curl_setopt($curl, CURLOPT_TIMEOUT, 10);
        curl_setopt($curl, CURLOPT_CONNECTTIMEOUT, 5);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, TRUE);
        curl_setopt($curl, CURLOPT_URL, $url);
        $data = curl_exec($curl);
        curl_close($curl);
        return $data;
    }

    /**
     * Geocoding an address (address -> lat,lng)
     *
     * @param string $address an address
     *
     * @return array array with precision, lat & lng
     */
    public function geocoding($address) {
        $url = 'http://maps.googleapis.com/maps/api/geocode/json?address=' . urlencode($address) . '&sensor=true';

        if (function_exists('curl_init')) {
            $data = $this->getContent($url);
        } else {
            $data = file_get_contents($url);
        }

        $response = json_decode($data, TRUE);
        $status = $response['status'];

        if ($status == 'OK') {
            $return = array(
                $status,
                $response['results'][0]['types'],
                $response['results'][0]['geometry']['location']['lat'],
                $response['results'][0]['geometry']['location']['lng']
            ); // successful geocode, $status-$precision-$lat-$lng
        } else {
            echo '<!-- geocoding : failure to geocode : ' . $status . " -->\n";
            $return = NULL; // failure to geocode
        }

        return $return;
    }

    /**
     * Add marker by his coord
     *
     * @param string $lat      lat
     * @param string $lng      lngs
     * @param string $title    title
     * @param string $html     html code display in the info window
     * @param string $category marker category
     * @param string $icon     an icon url
     *
     * @return void
     */
    public function addMarkerByCoords($lat, $lng, $title, $html = '', $category = '', $icon = '', $id = '') {
        if ($icon == '') {
            $icon = 'markerdefault';
        }

        // Save the lat/lon to enable the automatic center/zoom
        $this->maxLng = (float)max((float)$lng, $this->maxLng);
        $this->minLng = (float)min((float)$lng, $this->minLng);
        $this->maxLat = (float)max((float)$lat, $this->maxLat);
        $this->minLat = (float)min((float)$lat, $this->minLat);
        $this->centerLng = (float)($this->minLng + $this->maxLng) / 2;
        $this->centerLat = (float)($this->minLat + $this->maxLat) / 2;

        $this->contentMarker .= "\t" . 'addMarker(new google.maps.LatLng("' . $lat . '","' . $lng . '"),"' . $title . '","' . $html . '","' . $category . '",' . $icon . ',map' . $this->googleMapId . ',"' . $id . '");' . "\n";
    }

    /**
     * Add marker by his address
     *
     * @param string $address  an ddress
     * @param string $title    title
     * @param string $content  html code display in the info window
     * @param string $category marker category
     * @param string $icon     an icon url
     *
     * @return void
     */
    public function addMarkerByAddress($address, $title = '', $content = '', $category = '', $icon = '', $id = '') {
        $point = $this->geocoding($address);
        if ($point !== NULL) {
            $this->addMarkerByCoords($point[2], $point[3], $title, $content, $category, $icon, $id);
        } else {
            echo '<!-- addMarkerByAddress : ADDRESS NOT FOUND ' . strip_tags($address) . " -->\n";
        }
    }

    /**
     * Add marker by an array of coord
     *
     * @param string $coordtab an array of lat,lng,content
     * @param string $category marker category
     * @param string $icon     an icon url
     *
     * @return void
     */
    public function addArrayMarkerByCoords($coordtab, $category = '', $icon = '') {
        foreach ($coordtab as $coord) {
            $this->addMarkerByCoords($coord[0], $coord[1], $coord[2], $coord[3], $category, $icon, (!empty($coord[4])) ? $coord[4] : '');
        }
    }

    /**
     * Add marker by an array of address
     *
     * @param string $coordtab an array of address
     * @param string $category marker category
     * @param string $icon     an icon url
     *
     * @return void
     */
    public function addArrayMarkerByAddress($coordtab, $category = '', $icon = '') {
        foreach ($coordtab as $coord) {
            $this->addMarkerByAddress($coord[0], $coord[1], $coord[2], $category, $icon, (!empty($coord[3])) ? $coord[3] : '');
        }
    }

    /**
     * Parse a KML file and add markers to a category
     *
     * @param string $url      url of the kml file compatible with gmap and gearth
     * @param string $category marker category
     * @param string $icon     an icon url
     *
     * @return void
     */
    public function addKML($url, $category = '', $icon = '') {
        $xml = new SimpleXMLElement($url, NULL, TRUE);
        foreach ($xml->Document->Folder->Placemark as $item) {
            $coordinates = explode(',', (string)$item->Point->coordinates);
            $name = (string)$item->name;
            $this->addMarkerByCoords($coordinates[1], $coordinates[0], $name, $name, $category, $icon);
        }
    }
    
    /**
     * Parse a GPX file and add markers to a category
     *
     * @param string $url      url of the gpx file compatible with gmap and gearth
     * @param string $category marker category
     * @param string $icon     an icon url
     *
     * @return void
     */
    
    
   
    

   
    
    public function addParticipants($tParticipants, $category) {
        
        foreach ($tParticipants as $item) {            
            $name = (string)'<b>'.$item['nom'].'</b> '.$item['prenom'].' ('.$item['idMembre'].')';
            $this->addMarkerByCoords($item['lat'], $item['lng'], $item['nom'].' '.$item['prenom'], $name, $category, 'markerHome',$item['idMembre']);
            //$lat, $lng, texte aleternatif, contenu du marker, Groupe d'affectation, $icon = '', $id = ''
        }    
    }
    
    public function addPoints($tPointsOfChasuble) {

        foreach ($tPointsOfChasuble as $keys => $item) {            
            switch ($item['typeofpoint_id']){
                case 1 :
                    $logo = 'markerChasuble';
                    $category = 'chasubleSpot';
                    break;
                case 2 :
                    $logo = 'markerRelais';
                    $category = 'relaisSpot';                    
                    break;
                default :
                    $logo = 'markerdefault';
                    $category = '';
                    break;
            }
            $content = (string)'<b>'.$item['lat'].'</b> '.$item['lng'].' ('.$item['idPoint'].')<br /><input type=\"button\" value=\"Delete\" onclick=\"DeleteMarker(\'point_'.$item['idPoint'].'\');\" />';
            
            $this->addMarkerByCoords($item['lat'], $item['lng'], $item['name'], $content, $category, $logo,'point_'.$item['idPoint']);            
        }    
    }


    /**
     * Initialize the javascript code
     *
     * @return void
     */
    public function init() {
        // Google map DIV
        if (($this->width != '') && ($this->height != '')) {
            $this->content .= "\t" . '<div id="' . $this->googleMapId . '" style="width:' . $this->width . ';height:' . $this->height . '"></div>' . "\n";
        } else {
            $this->content .= "\t" . '<div id="' . $this->googleMapId . '"></div>' . "\n";
        }

        if ($this->includeJs === TRUE) {
            // Google map JS
            $this->content .= '<script type="text/javascript" src="https://maps.googleapis.com/maps/api/js?sensor=false&region=FR' . $this->lang . '">';
            $this->content .= '</script>' . "\n";
            $this->content .= '<script type="text/javascript" src="./js/oms.min.js"></script>' . "\n";
            // Clusterer JS
            if ($this->useClusterer == TRUE) {
                $this->content .= '<script src="' . $this->clustererLibraryPath . '" type="text/javascript"></script>' . "\n";
            }
        }

        $this->content .= '<script type="text/javascript">' . "\n";


        $this->content .= "\t " . 'function addLoadEvent(func) { ' . "\n";
        $this->content .= "\t\t " . 'var oldonload = window.onload; ' . "\n";
        $this->content .= "\t\t " . 'if (typeof window.onload != \'function\') { ' . "\n";
        $this->content .= "\t\t\t " . 'window.onload = func; ' . "\n";
        $this->content .= "\t\t " . '} else { ' . "\n";
        $this->content .= "\t\t\t " . 'window.onload = function() { ' . "\n";
        $this->content .= "\t\t\t\t " . 'if (oldonload) { ' . "\n";
        $this->content .= "\t\t\t\t\t " . 'oldonload(); ' . "\n";
        $this->content .= "\t\t\t\t " . '} ' . "\n";
        $this->content .= "\t\t\t\t " . 'func(); ' . "\n";
        $this->content .= "\t\t\t " . '} ' . "\n";
        $this->content .= "\t\t " . '}' . "\n";
        $this->content .= "\t " . '} ' . "\n";

        $this->content .= "\t " . 'var geocoder = new google.maps.Geocoder();' . "\n";
        $this->content .= "\t " . 'var mapcontainerMap;' . "\n";
        $this->content .= "\t " . 'var gmarkers = [];' . "\n";
        $this->content .= "\t " . 'var infowindow;' . "\n";
        $this->content .= "\t " . 'var oms;' . "\n";
        $this->content .= "\t " . 'var arrayListner = [];' . "\n";
        $this->content .= "\t " . 'var Listner = [];' . "\n";
        
        $this->content .= "\t " . 'var Listener_2;' . "\n";
        $this->content .= "\t " . 'var directions = new google.maps.DirectionsRenderer();' . "\n";
        $this->content .= "\t " . 'var directionsService = new google.maps.DirectionsService();' . "\n";
        $this->content .= "\t " . 'var current_lat = 0;' . "\n";
        $this->content .= "\t " . 'var current_lng = 0;' . "\n";
        $this->content .= "\t " . 'var iParcours_id =' . $this->iParcours_id . ';' . "\n";
        $this->content .= "\t " . 'var iEvent_id =' . $this->iEvent_id . ';' . "\n";
        $this->content .= "\t " . 'var remove_poi = [' . "\n";
        $this->content .= "\t\t " . '{' . "\n";
        $this->content .= "\t\t\t " .'"featureType": "poi",' . "\n";        
        $this->content .= "\t\t\t " . '"stylers": [' . "\n";
        $this->content .= "\t\t\t\t " . '  { "visibility": "off" }' . "\n";
        $this->content .= "\t\t\t " . ']' . "\n";
        $this->content .= "\t\t\t " . '},' . "\n";
        $this->content .= "\t\t " . '{' . "\n";
        $this->content .= "\t\t\t " .'"featureType": "transit",' . "\n";        
        $this->content .= "\t\t\t " . '"stylers": [' . "\n";
        $this->content .= "\t\t\t\t " . '  { "visibility": "off" }' . "\n";
        $this->content .= "\t\t\t " . ']' . "\n";
        $this->content .= "\t\t\t " . '}' . "\n";
        $this->content .= "\t " . ']' . "\n";

        $this->content .= "\t " . 'function getCurrentLat() {' . "\n";
        $this->content .= "\t\t\t " . 'return current_lat;' . "\n";
        $this->content .= "\t " . '}' . "\n";

        $this->content .= "\t " . 'function getCurrentLng() {' . "\n";
        $this->content .= "\t\t\t " . 'return current_lng;' . "\n";
        $this->content .= "\t " . '}' . "\n";

            // JS public function to add a  marker
//        $this->content .= "\t " . 'function addMarker(latlng,title,content,category,icon,currentmap,id) {' . "\n";
//        $this->content .= "\t\t " . 'var marker = new google.maps.Marker({' . "\n";
//        $this->content .= "\t\t\t " . 'map:  currentmap,' . "\n";
//        $this->content .= "\t\t\t " . 'title : title,' . "\n";
//        $this->content .= "\t\t\t " . 'icon:  icon,' . "\n";
//        $this->content .= "\t\t\t " . 'position: latlng' . "\n";
//        $this->content .= "\t\t " . '});' . "\n";        
//        $this->content .= "\t\t " . 'var html = \'<div style="text-align:left;" class="infoGmaps">\'+content+\'</div>\';' . "\n";
//        $this->content .= "\t\t " . 'arrayListner[id] = google.maps.event.addListener(marker, "click", function() {' . "\n";
//        $this->content .= "\t\t\t " . 'if (infowindow) infowindow.close();' . "\n";
//        $this->content .= "\t\t\t " . 'infowindow = new google.maps.InfoWindow({content: html,disableAutoPan: false});' . "\n";
//        $this->content .= "\t\t\t " . 'infowindow.open(currentmap,marker);' . "\n";
//
//        // Enable the zoom when you click on a marker
//        if ($this->enableWindowZoom == TRUE) {
//            $this->content .= "\t\t\t" . 'currentmap.setCenter(new google.maps.LatLng(latlng.lat(),latlng.lng()),' . $this->infoWindowZoom . ');' . "\n";
//        }
//
//        $this->content .= "\t\t" . '});' . "\n";
//        $this->content .= "\t\t" . 'marker.mycategory = category;' . "\n";
//        $this->content .= "\t\t" . 'if (id) marker.id = id; else marker.id = \'marker_\'+gmarkers.length;' . "\n";
//        $this->content .= "\t\t" . 'gmarkers.push(marker);' . "\n";
//        $this->content .= "\t\t" . 'oms.addMarker(marker);' . "\n";
//        //$this->content .= "\t\t" . 'marker.setVisible(false);' . "\n";        
//        $this->content .= "\t" . '}' . "\n";

        // JS public function to add a geocode marker
        $this->content .= "\t" . 'function geocodeMarker(address,title,content,category,icon) {' . "\n";
        $this->content .= "\t\t" . 'if (geocoder) {' . "\n";
        $this->content .= "\t\t\t" . 'geocoder.geocode( { "address" : address}, function(results, status) {' . "\n";
        $this->content .= "\t\t\t\t" . 'if (status == google.maps.GeocoderStatus.OK) {' . "\n";
        $this->content .= "\t\t\t\t\t" . 'var latlng = 	results[0].geometry.location;' . "\n";
        $this->content .= "\t\t\t\t\t" . 'addMarker(results[0].geometry.location,title,content,category,icon)' . "\n";
        $this->content .= "\t\t\t\t" . '}' . "\n";
        $this->content .= "\t\t\t" . '});' . "\n";
        $this->content .= "\t\t" . '}' . "\n";
        $this->content .= "\t" . '}' . "\n";

        // JS public function to center the gmaps dynamically
        $this->content .= "\t" . 'function geocodeCenter(address) {' . "\n";
        $this->content .= "\t\t" . 'if (geocoder) {' . "\n";
        $this->content .= "\t\t\t" . 'geocoder.geocode( { "address": address}, function(results, status) {' . "\n";
        $this->content .= "\t\t\t\t" . 'if (status == google.maps.GeocoderStatus.OK) {' . "\n";
        $this->content .= "\t\t\t\t" . 'map' . $this->googleMapId . '.setCenter(results[0].geometry.location);' . "\n";
        $this->content .= "\t\t\t\t" . '} else {' . "\n";
        $this->content .= "\t\t\t\t" . 'alert("Geocode was not successful for the following reason: " + status);' . "\n";
        $this->content .= "\t\t\t\t" . '}' . "\n";
        $this->content .= "\t\t\t" . '});' . "\n";
        $this->content .= "\t\t" . '}' . "\n";
        $this->content .= "\t" . '}' . "\n";

        $this->content .= "\t " . 'function geocodePosition(pos) {' . "\n";
        $this->content .= "\t " . '  geocoder.geocode({' . "\n";
        $this->content .= "\t\t " . 'latLng: pos' . "\n";
        $this->content .= "\t " . '  }, function(responses) {' . "\n";
        $this->content .= "\t\t " . 'if (responses && responses.length > 0) {' . "\n";
        $this->content .= "\t\t " . '  updateMarkerPosition(responses[0].geometry.location.H, responses[0].geometry.location.L);' . "\n";
        $this->content .= "\t\t " . '} else {' . "\n";
        $this->content .= "\t\t " . '  updateMarkerPosition(\'Cannot determine address at this location.\');' . "\n";
        $this->content .= "\t\t " . '}' . "\n";
        $this->content .= "\t " . '  });' . "\n";
        $this->content .= "\t " . '}' . "\n";

            // JS public function to set direction
        $this->content .= "\t " . 'function updateMarkerPosition(Lat,Lng) {' . "\n";
        $this->content .= "\t\t " . '$("input#Lat").val(Lat);' . "\n";
        $this->content .= "\t\t " . '$("input#Lng").val(Lng);  ' . "\n";
        $this->content .= "\t " . '}' . "\n";

        $this->content .= "\t " . 'function showMarker(id) {' . "\n";
        $this->content .= "\t\t " . 'for (var i=0; i<gmarkers.length; i++) {' . "\n";
        $this->content .= "\t\t\t " . 'if (gmarkers[i].id == id) {' . "\n";
        $this->content .= "\t\t\t\t\t " . ' google.maps.event.trigger(gmarkers[i],\'click\');' . "\n";
        $this->content .= "\t\t\t " . '}' . "\n";
        $this->content .= "\t\t " . '}' . "\n";
        $this->content .= "\t " . '}' . "\n";

        $this->content .= "\t " . 'function showCategory(category) {' . "\n";
        $this->content .= "\t\t " . 'for (var i=0; i<gmarkers.length; i++) {' . "\n";
        $this->content .= "\t\t\t " . 'if (gmarkers[i].mycategory == category) {' . "\n";
        $this->content .= "\t\t\t\t " . 'gmarkers[i].setVisible(true);' . "\n";
        $this->content .= "\t\t\t " . '}' . "\n";
        $this->content .= "\t\t " . '}' . "\n";
        $this->content .= "\t " . '}' . "\n";

        $this->content .= "\t " . 'function hideCategory(category) {' . "\n";
        $this->content .= "\t\t " . 'for (var i=0; i<gmarkers.length; i++) {' . "\n";
        $this->content .= "\t\t\t " . 'if (gmarkers[i].mycategory == category) {' . "\n";
        $this->content .= "\t\t\t\t " . 'gmarkers[i].setVisible(false);' . "\n";
        $this->content .= "\t\t\t " . '}' . "\n";
        $this->content .= "\t\t " . '}' . "\n";
        $this->content .= "\t\t " . 'if(infowindow) { infowindow.close(); }' . "\n";
        $this->content .= "\t " . '}' . "\n";

//        // JS public function to hide all the markers
        $this->content .= "\t" . 'function hideAll() {' . "\n";
        $this->content .= "\t\t" . 'for (var i=0; i<gmarkers.length; i++) {' . "\n";
        $this->content .= "\t\t\t" . 'gmarkers[i].setVisible(false);' . "\n";
        $this->content .= "\t\t" . '}' . "\n";
        $this->content .= "\t\t" . 'if(infowindow) { infowindow.close(); }' . "\n";
        $this->content .= "\t" . '}' . "\n";

        // JS public function to show all the markers
        $this->content .= "\t" . 'function showAll() {' . "\n";
        $this->content .= "\t\t" . 'for (var i=0; i<gmarkers.length; i++) {' . "\n";
        $this->content .= "\t\t\t" . 'gmarkers[i].setVisible(true);' . "\n";
        $this->content .= "\t\t" . '}' . "\n";
        $this->content .= "\t\t" . 'if(infowindow) { infowindow.close(); }' . "\n";
        $this->content .= "\t" . '}' . "\n";


        $this->content .= "\t " . 'function toggleHideShowMarker(category) {' . "\n";
        $this->content .= "\t\t\t " . 'for (var i=0; i<gmarkers.length; i++) {' . "\n";
        $this->content .= "\t\t\t\t\t " . 'if (gmarkers[i].mycategory === category) {' . "\n";
        $this->content .= "\t\t\t\t\t\t " . 'if (gmarkers[i].getVisible()===true) { gmarkers[i].setVisible(false); }' . "\n";
        $this->content .= "\t\t\t\t\t\t " . 'else gmarkers[i].setVisible(true);' . "\n";
        $this->content .= "\t\t\t\t\t " . '}' . "\n";
        $this->content .= "\t\t\t " . '}' . "\n";
        $this->content .= "\t\t\t " . 'if(infowindow) { infowindow.close(); }' . "\n";
        $this->content .= "\t " . '}' . "\n";

        

//        if ($this->enableParcours == TRUE) {
        
        
//        $this->content .= "\t " . 'function clickParcours(){' . "\n";
//        $this->content .= "\t " . '   if ($("button#btnParcours").text()=== \'Afficher les parcours\'){' . "\n";
//        $this->content .= "\t\t\t " . '$("button#btnParcours").text(\'Masquer le parcours\');' . "\n";
//        $this->content .= "\t\t " . '}else{' . "\n";
//        $this->content .= "\t\t\t " . '$("button#btnParcours").text(\'Afficher le parcours\');' . "\n";
//        $this->content .= "\t\t " . '}' . "\n";
//        $this->content .= "\t\t " . 'toggleHideShowParcours();' . "\n";
//        $this->content .= "\t " . '}' . "\n";
//        }
        
             
        
    }

    /**
     * Generate the HTML code of the gmap
     */
    public function generate() {
        $this->init();

        //Fonction init()
        $this->content .= "\t" . 'function initialize' . $this->googleMapId . '() {' . "\n";
        $this->content .= "\t" . 'var myLatlng = new google.maps.LatLng(' . $this->fDefaultLat . ','. $this->fDefaultLng .');' . "\n";
        $this->content .= "\t" . 'var myOptions = {' . "\n";
        $this->content .= "\t\t" . 'zoom: ' . $this->zoom . ',' . "\n";
        $this->content .= "\t\t" . 'maxZoom: ' . $this->iMaxZoom . ',' . "\n";
        $this->content .= "\t\t" . 'minZoom: ' . $this->iMinZoom . ',' . "\n";
        $this->content .= "\t\t" . 'center: myLatlng,' . "\n";
        $this->content .= "\t\t" . 'streetViewControl: '.$this->sEnablestreetViewControl.',' . "\n";
        $this->content .= "\t\t" . 'mapTypeId: google.maps.MapTypeId.' . $this->mapType . "\n";
        $this->content .= "\t" . '}' . "\n";

        //Goole map Div Id
        $this->content .= "\t" . 'map' . $this->googleMapId . ' = new google.maps.Map(document.getElementById("' . $this->googleMapId . '"), myOptions);' . "\n";
        $this->content .= "\t" . 'oms = new OverlappingMarkerSpiderfier(map' . $this->googleMapId . ');' . "\n";
        $this->content .= "\t" . 'map' . $this->googleMapId . '.setOptions({styles: remove_poi})'. "\n";
//        //PrÃ©chargement du parcours
//        if ($this->enableParcours == TRUE) {
//            $this->content .= "\t" . 'var myPoints = '. $this->coords .';'. "\n";
//
//            $this->content .= "\t" . 'poly = new google.maps.Polyline({' . "\n";
//         // use your own style here
//            $this->content .= "\t\t" . 'path: myPoints,'. "\n";
//            $this->content .= "\t\t" . 'strokeColor: "#FF00AA",' . "\n";
//            $this->content .= "\t\t" . 'strokeOpacity: .7,' . "\n";
//            $this->content .= "\t\t" . 'strokeWeight: 4,' . "\n";
//            $this->content .= "\t\t" . 'clickable: false' . "\n";
//            $this->content .= "\t" . '});' . "\n";
//            
//            $this->content .= "\t" . 'bounds = new google.maps.LatLngBounds();'. "\n";           
//            $this->content .= "\t" . 'for(var i = 1; i < myPoints.length; i++){'. "\n";
//            $this->content .= "\t\t" . 'bounds.extend(new google.maps.LatLng(myPoints[i].lat,myPoints[i].lng));'. "\n";
//
//            $this->content .= "\t" . '}'. "\n";
//            if ($this->sShowImmediatParcours == TRUE) {
//                $this->content .= "\t\t" . 'poly.setMap(map' . $this->googleMapId . ');' . "\n";
//                $this->content .= "\t\t" . 'map' . $this->googleMapId . '.fitBounds(bounds);' . "\n";
//            }
//            
//
//        }
        
        $this->content .= "\t" . 'google.maps.event.addListener(map' . $this->googleMapId . ',"click",function(event) { if (event) { current_lat=event.latLng.lat();current_lng=event.latLng.lng(); }}) ;' . "\n";

        $this->content .= "\t" . 'directions.setMap(map' . $this->googleMapId . ');' . "\n";
//        $this->content .= "\t" . 'directions.setPanel(document.getElementById("' . $this->googleMapDirectionId . '"))' . "\n";

        // add all the markers
//        $this->content .= $this->contentMarker;
//        $this->content .= "\t\t" . 'hideAll();' . "\n";
        // Clusterer JS
        if ($this->useClusterer == TRUE) {
            $this->content .= "\t" . 'var markerCluster = new MarkerClusterer(map' . $this->googleMapId . ', gmarkers,{gridSize: ' . $this->gridSize . ', maxZoom: ' . $this->maxZoom . '});' . "\n";
        }

        $this->content .= '}' . "\n";

        // Chargement de la map a la fin du HTML
        //$this->content.= "\t".'window.onload=initialize;'."\n";
        $this->content .= "\t" . 'addLoadEvent(initialize' . $this->googleMapId . ');' . "\n";

        //Fermeture du javascript
        $this->content .= '</script>' . "\n";

    }

}
