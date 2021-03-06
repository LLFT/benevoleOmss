<form class="form-horizontal" action="" method="POST" >
    <fieldset>
        <legend> <?php if ($this->oEvents->active != 1) :?><s> <?php endif; ?> <?php echo $this->oEvents->nomEvent ?> - (<?php echo $this->oEvents->date ?>)<?php if ($this->oEvents->active != 1) :?></s> <?php endif; ?></legend>
	
        
        <div class="form-group">
		<label class="col-sm-2 control-label">Lieux  : </label>
		<div class="col-sm-10"><p class="form-control-static"><?php echo $this->oEvents->lieux ?></p></div>
	</div>

	<div class="form-group">
		<label class="col-sm-2 control-label">Description : </label>
                <div class="col-sm-10"><p class="form-control-static"><?php echo $this->oEvents->description ?></p></div>
	</div>
    </fieldset>
    
    
    <fieldset>
        <legend>Parcours Associés</legend>  
	<?php $i=1; if($this->oParcours):?>
		<?php foreach($this->oParcours as $oParcour):?>
                	
        <div class="form-group">
                		<label class="col-sm-2 control-label">Parcours <?php echo $i; $i++; ?> :</label>
                		<div class="col-sm-10"><a class="btn btn-primary btn-x" href="<?php echo $this->getLink('parcours::show',array( 'id'=>$oParcour->idParcours, 'idEvent'=>_root::getParam('id')))?>"><?php echo $oParcour->label ?></a></div>
                        </div>	
        
		<?php endforeach;?>
	<?php else:?>
		<div class="col-sm-offset-6">
                    <div class="col-sm-10"><p class="form-control-static"> -= Aucune ligne =-</p></div>
                </div>
	<?php endif;?>
    </table>
    <?php if ( _root::getACL()->can('ACCESS','parcours::new')):?>
    <?php if ($this->oEvents->active != 0) :?>    
    <p><a class="btn btn-success" href="<?php echo $this->getLink('parcours::new',array('idEvent'=>_root::getParam('id'))) ?>">Ajouter parcours</a></p>
    <?php endif;?>
    <?php endif;?>
    </fieldset>
    
    <?php if ($this->tListeDesParticipants) :?>
    <fieldset>
        <legend>Signaleurs Engagés</legend>
        <div class="table-responsive">
            <table class="table">
            <?php foreach($this->tListeDesParticipants as $key => $sParticipant):?>
                <?php if($key %4===0) :?> <tr><?php endif; ?>
                
                    <td> <?php echo $key+1 .' : '.$sParticipant; ?> </td>
                
                <?php if($key %4===3) :?> </tr><?php endif; ?>
            <?php endforeach;?>
            </table>
        </div>
    </fieldset>
    <?php endif;?>
    
    <?php if (($this->oListBenevolesDispo) && ($this->oEvents->active != 0)) :?>
    <fieldset>
        <legend>Signaleurs Disponibles</legend>
        <div class="table-responsive">
            <table class="table">
            <?php $inc = 0; ?>
            <?php foreach($this->oListBenevolesDispo as $tListBenevolesDispo):?>
                <?php if($inc %4===0) :?> <tr><?php endif; ?>
                
                    <td> <?php echo $inc+1 .' : '.$tListBenevolesDispo['nom'].' '.$tListBenevolesDispo['prenom'] ; ?> </td>
                
                <?php if($inc %4===3) :?> </tr><?php endif; ?>
                <?php $inc++; ?>
            <?php endforeach;?>
            </table>
        </div>
    </fieldset>
    <?php endif;?>
    
    <fieldset>
        <legend>Actions </legend>  
        <div class="btn-group" role="group">
            
                <a class="btn btn-default" href="<?php echo $this->getLink('events::list')?>">Retour</a>
                <a class="btn btn-info" href="<?php echo $this->getLink('events::exportCSV',array('idEvent'=>$this->oEvents->getId(),'nomEvent'=>$this->oEvents->nomEvent))?>">Exporter la liste des signaleurs</a>
            
            <?php if ( _root::getACL()->can('ACCESS','events::edit')):?>
                <?php if ($this->oEvents->active != 0) :?>
                
                    <a class="btn btn-success" href="<?php echo $this->getLink('events::edit',array('id'=>$this->oEvents->getId()))?>">Modifier</a>
                
                    <a class="btn btn-danger" href="<?php echo $this->getLink('events::archiver',array('id'=>$this->oEvents->getId()))?>">Archiver</a>
                
                <?php endif;?>
            <?php endif;?>
        </div>
    </fieldset>
</form>

