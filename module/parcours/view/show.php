<div class="col-sm-offset-1 col-sm-2">
        <a class="btn btn-info" href="<?php echo $this->getLink('events::show',array('id'=>_root::getParam('idEvent')))?>">Retour à l'évènement</a>
</div>
<div class="col-sm-12">
    <div class="col-sm-offset-1 ">        
        <?php echo $this->oModuleGoogleMap->getGoogleMap();;?>
        </div>
    </div>
    <div class="col-sm-offset-1 ">
        <label>Latitude</label>
        <input id="Lat" type="text">
        <label>Longitude</label>
        <input id="Lng" type="text">        
    </div>
</div>
<div class="form-group">
    
    <div class="col-sm-offset-1 col-sm-6">    
        <button id="btnVolon" onclick="clickVolon();">Masquer les volontaires</button>          
        <button id="btnParcours" onclick="clickParcours();">Masquer le parcours</button>             
        <button id="ajoutSign" onclick="addSpot();">Ajouter un signaleur</button>        
        <button id="btnSignaleur" onclick="clickSignaleur();">Masquer les signaleurs</button>
        
        <button id="ajoutRelais" onclick="addRelais()">Ajouter un Relais</button>
        <button id="btnRelais" onclick="clickRelais()">Masquer les relais</button>
    </div>
</div>     
 

        