<form class="form-horizontal" action="" method="POST">

    <fieldset class="col-sm-12">
            <legend><?php echo $this->oAccount->login ?></legend>
            
            <div class="form-group">
		<label class="col-sm-2 control-label">Nom : </label>
		<div class="col-sm-10"><p class="form-control-static"><?php echo $this->oAccount->nomUser ?></p></div>
            </div>

            <div class="form-group">
		<label class="col-sm-2 control-label">Prénom : </label>
		<div class="col-sm-10"><p class="form-control-static"><?php echo $this->oAccount->prenomUser ?></p></div>
            </div>
    </fieldset>

<input type="hidden" name="token" value="<?php echo $this->token?>" />
<?php if($this->tMessage and isset($this->tMessage['token'])): echo $this->tMessage['token']; endif;?>

<div class="form-group">
    <div class="col-sm-offset-2 col-sm-10">
		<input class="btn btn-danger" type="submit" value="Confirmer la suppression" /> <a class="btn btn-link" href="<?php echo $this->getLink('account::list')?>">Annuler</a>
	</div>
</div>
</form>
