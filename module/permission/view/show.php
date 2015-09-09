<form class="form-horizontal" action="" method="POST" >
	
	<div class="form-group">
		<label class="col-sm-2 control-label">action</label>
		<div class="col-sm-10"><?php echo $this->oPermission->action ?></div>
	</div>

	<div class="form-group">
		<label class="col-sm-2 control-label">element</label>
		<div class="col-sm-10"><?php echo $this->oPermission->element ?></div>
	</div>

	<div class="form-group">
		<label class="col-sm-2 control-label">allowdeny</label>
		<div class="col-sm-10"><?php echo $this->oPermission->allowdeny ?></div>
	</div>


<div class="form-group">
    <div class="col-sm-offset-2 col-sm-10">
		 <a class="btn btn-default" href="<?php echo $this->getLink('permission::list')?>">Retour</a>
	</div>
</div>
</form>
