<form class="form-horizontal" action="" method="POST" >
	
	<fieldset class="col-sm-12">
            <legend><?php echo $this->oMembres->indexMembre .' : '.$this->oMembres->nom .' '. $this->oMembres->prenom ?></legend>

	<div class="form-group">
		<label class="col-sm-2 control-label">Adresse Mail : </label>
		<div class="col-sm-10"><p class="form-control-static"><?php echo $this->oMembres->mail ?></p></div>
	</div>

	<div class="form-group">
		<label class="col-sm-2 control-label">Téléphone Fixe : </label>
		<div class="col-sm-10"><p class="form-control-static"><?php echo $this->oMembres->fixe ?></p></div>
	</div>

	<div class="form-group">
		<label class="col-sm-2 control-label">Téléphone GSM : </label>
		<div class="col-sm-10"><p class="form-control-static"><?php echo $this->oMembres->gsm ?></p></div>
	</div>



	<fieldset>
        <legend>Adresse Postale : </legend>
            <div class="form-group">
                <label class="col-sm-2 control-label">Adresse : </label>
                <div class="col-sm-10"><p class="form-control-static"><?php if (strlen(trim($this->oMembres->rue))>=1){  if ($this->oMembres->numero >0){echo $this->oMembres->numero;} echo ' '.  $this->oMembres->rue.' '. $this->oMembres->complement; } ?></p></div>
                    <div class="col-sm-offset-2 col-sm-10"><p class="form-control-static"><?php if (strlen(trim($this->oMembres->ville))>=1){ if ($this->oMembres->codePostal >0){echo $this->oMembres->codePostal;} echo ' '.$this->oMembres->ville; } ?></p></div>
            </div>
        </fieldset>

<input type="hidden" name="token" value="<?php echo $this->token?>" />
<?php if($this->tMessage and isset($this->tMessage['token'])): echo $this->tMessage['token']; endif;?>

<div class="form-group">
    <div class="col-sm-offset-2 col-sm-10">
		<input class="btn btn-danger" type="submit" value="Confirmer la suppression" /> <a class="btn btn-link" href="<?php echo $this->getLink('membres::show',array('id'=>$this->oMembres->idMembre))?>">Annuler</a>
	</div>
</div>
</form>
