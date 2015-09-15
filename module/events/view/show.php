<form class="form-horizontal" action="" method="POST" >
    <fieldset>
        <legend><?php echo $this->oEvents->nomEvent ?> - (<?php echo $this->oEvents->date ?>)</legend>
	
        
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
                		<div class="col-sm-10"><a class="btn btn-primary btn-x" href="<?php echo $this->getLink('parcours::show',array( 'id'=>$oParcour->getId(), 'idEvent'=>_root::getParam('id')))?>"><?php echo $oParcour->label ?></a></div>
                        </div>	
        
		<?php endforeach;?>
	<?php else:?>
		<div class="col-sm-offset-6">
                    <div class="col-sm-10"><p class="form-control-static"> -= Aucune ligne =-</p></div>
                </div>
	<?php endif;?>
    </table>
        
    <p><a class="btn btn-success" href="<?php echo $this->getLink('parcours::new',array('idEvent'=>_root::getParam('id'))) ?>">Ajouter parcours</a></p>
    </fieldset>
    <fieldset>
        <legend>Actions </legend>  
        <div class="form-group">
            <div class="col-sm-offset-7 col-sm-1">
                <a class="btn btn-default" href="<?php echo $this->getLink('events::list')?>">Retour</a>
            </div>
            <div class="col-sm-1">
                <a class="btn btn-success" href="<?php echo $this->getLink('events::edit',array('id'=>$this->oEvents->getId()))?>">Modifier</a>
            </div>
            <div class=" col-sm-1">
                <a class="btn btn-danger" href="<?php echo $this->getLink('events::delete',array('id'=>$this->oEvents->getId()))?>">Supprimer</a>
            </div>
        </div>
    </fieldset>
</form>

