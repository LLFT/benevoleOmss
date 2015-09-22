<div class="col-sm-offset-1 col-sm-2">
        <a class="btn btn-info" href="<?php echo $this->getLink('events::show',array('id'=>_root::getParam('idEvent')))?>">Retour à l'évènement</a>
</div>

<div class="col-sm-offset-1 ">
    <p class="form-control-static"><?php echo $this->oModuleGoogleMap->show();?></p>
</div> 

<div class="form-group">
    <div class="col-sm-offset-2 col-sm-2">
    <!--<a class="btn btn-success" href="<?php // echo $this->getLink('parcours::ajoutSignaleur',array( 'id'=>$this->oParcours->getId(), 'idEvent'=>_root::getParam('idEvent') ) )?>">Ajouter les signaleurs</a>-->
    </div>
    <div class="col-sm-offset-2 col-sm-2">
    <a class="btn btn-danger" href="<?php echo $this->getLink('parcours::delete',array( 'id'=>$this->oParcours->getId(), 'idEvent'=>_root::getParam('idEvent') ) )?>">Supprimer</a>
    </div>
</div>    
 

        