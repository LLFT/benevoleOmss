<form class="form-horizontal" action="" method="POST">


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


<input type="hidden" name="token" value="<?php echo $this->token?>" />
<?php if($this->tMessage and isset($this->tMessage['token'])): echo $this->tMessage['token']; endif;?>

<div class="col-sm-offset-2 btn-group" role="group">
    <input class="btn btn-danger" type="submit" value="Confirmer l'archivage" /> <a class="btn btn-default" href="<?php echo $this->getLink('events::show',array('id'=>  _root::getParam('id')))?>">Annuler</a>
</div>
</form>
