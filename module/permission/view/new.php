<?php 
$oForm=new plugin_form($this->oPermission);
$oForm->setMessage($this->tMessage);
?>
<form  class="form-horizontal" action="" method="POST" >

	
	<div class="form-group">
		<label class="col-sm-2 control-label">action</label>
		<div class="col-sm-10"><?php echo $oForm->getInputText('action',array('class'=>'form-control'))?></div>
	</div>

	<div class="form-group">
		<label class="col-sm-2 control-label">element</label>
		<div class="col-sm-10"><?php echo $oForm->getInputText('element',array('class'=>'form-control'))?></div>
	</div>

	<div class="form-group">
		<label class="col-sm-2 control-label">allowdeny</label>
		<div class="col-sm-10"><?php echo $oForm->getInputText('allowdeny',array('class'=>'form-control'))?></div>
	</div>
    
        <div class="form-group">
		<label class="col-sm-2 control-label">Groupe</label>
		<div class="col-sm-10"><?php echo $oForm->getSelect('groupe_id',$this->tJoinmodel_groupe,array('class'=>'form-control'))?></div>
	</div>


<?php echo $oForm->getToken('token',$this->token)?>


<div class="form-group">
    <div class="col-sm-offset-2 col-sm-10">
		<input type="submit" class="btn btn-success" value="Créer" /> <a class="btn btn-link" href="<?php echo $this->getLink('permission::list')?>">Annuler</a>
	</div>
</div>
</form>
