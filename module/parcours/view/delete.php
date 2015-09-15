<form class="form-horizontal" action="" method="POST">


	<div class="form-group">
            <div class="col-sm-offset-2 col-sm-10">
                <p> Veuillez confirmer que vous souhaitez supprimer le parcours <b> <?php echo $this->oParcours->label ?></b> qui est associé à l'évènement <b><?php echo $this->oEvents->nomEvent ?></b> </p>
            </div>
	</div>


<input type="hidden" name="token" value="<?php echo $this->token?>" />
<?php if($this->tMessage and isset($this->tMessage['token'])): echo $this->tMessage['token']; endif;?>

<div class="form-group">
    <div class="col-sm-offset-2 col-sm-10">
		<input class="btn btn-danger" type="submit" value="Confirmer la suppression" /> <a class="btn btn-link" href="<?php echo $this->getLink('parcours::show',array('id'=>_root::getParam('id'), 'idEvent'=>_root::getParam('idEvent')))?>">Annuler</a>
	</div>
</div>
</form>
