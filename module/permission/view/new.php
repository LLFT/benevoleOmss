<?php 
$oForm=new plugin_form($this->oPermission);
$oForm->setMessage($this->tMessage);
?>
<form  class="form-horizontal" action="" method="POST" >

	
	<div class="form-group">
		<label class="col-sm-2 control-label">Actions</label>
		<div class="col-sm-10"><?php echo $oForm->getInputText('action',array('class'=>'form-control'))?></div>
	</div>

	<div class="form-group">
		<label class="col-sm-2 control-label">Element</label>
		<div class="col-sm-10"><?php echo $oForm->getSelect('element',$this->tJoinmodel_element,array('class'=>'form-control'))?></div>
	</div>

	<div class="form-group">
		<label class="col-sm-2 control-label">Permission</label>
		<div class="col-sm-10"><?php echo $oForm->getSelect('allowdeny',$this->tAllowDeny,array('class'=>'form-control'))?></div>
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
