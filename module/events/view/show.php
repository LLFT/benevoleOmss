<form class="form-horizontal" action="" method="POST" >
    <fieldset>
        <legend><?php echo $this->oEvents->nomEvent ?>(<?php echo $this->oEvents->date ?>)</legend>
	
	<div class="form-group">
		<label class="col-sm-2 control-label">Lieux</label>
		<div class="col-sm-10"><?php echo $this->oEvents->lieux ?></div>
	</div>

	<div class="form-group">
		<label class="col-sm-2 control-label">description</label>
		<div class="col-sm-10"><?php echo $this->oEvents->description ?></div>
	</div>
    </fieldset>
    
    
    <fieldset>
        <legend>Parcours Associés</legend>  
        
        <table class="table table-striped">
	<tr>
		
		<th>Label</th>
	</tr>
	<?php if($this->oParcours):?>
		<?php foreach($this->oParcours as $oParcour):?>
		<tr <?php echo plugin_tpl::alternate(array('','class="alt"'))?>>
                    <td>
                        <a class="btn btn-primary btn-xs" href="<?php echo $this->getLink('parcours::show',array( 'id'=>$oParcour->getId(), 'idEvent'=>_root::getParam('id')))?>"><?php echo $oParcour->label ?></a>
                    </td>
		</tr>	
		<?php endforeach;?>
	<?php else:?>
		<tr>
			<td colspan="13">Aucune ligne</td>
		</tr>
	<?php endif;?>
    </table>
        
    <p><a class="btn btn-success" href="<?php echo $this->getLink('parcours::new',array('idEvent'=>_root::getParam('id'))) ?>">Ajouter parcours</a></p>
    </fieldset>
    
    
<div class="form-group">
    <div class="col-sm-offset-2 col-sm-10">
		 <a class="btn btn-default" href="<?php echo $this->getLink('events::list')?>">Retour</a>
	</div>
</div>
</form>
