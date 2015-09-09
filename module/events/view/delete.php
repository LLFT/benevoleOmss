<form class="form-horizontal" action="" method="POST">


	<div class="form-group">
		<label class="col-sm-2 control-label">Nom de l&#039;&Atilde;&copy;v&Atilde;&uml;nement</label>
		<div class="col-sm-10"><?php echo $this->oEvents->nomEvent ?></div>
	</div>

	<div class="form-group">
		<label class="col-sm-2 control-label">Date</label>
		<div class="col-sm-10"><?php echo $this->oEvents->date ?></div>
	</div>

	<div class="form-group">
		<label class="col-sm-2 control-label">Lieux</label>
		<div class="col-sm-10"><?php echo $this->oEvents->lieux ?></div>
	</div>

	<div class="form-group">
		<label class="col-sm-2 control-label">description</label>
		<div class="col-sm-10"><?php echo $this->oEvents->description ?></div>
	</div>


<input type="hidden" name="token" value="<?php echo $this->token?>" />
<?php if($this->tMessage and isset($this->tMessage['token'])): echo $this->tMessage['token']; endif;?>

<div class="form-group">
    <div class="col-sm-offset-2 col-sm-10">
		<input class="btn btn-danger" type="submit" value="Confirmer la suppression" /> <a class="btn btn-link" href="<?php echo $this->getLink('events::list')?>">Annuler</a>
	</div>
</div>
</form>
