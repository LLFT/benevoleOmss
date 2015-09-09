<form  class="form-horizontal" action="" method="POST" enctype="multipart/form-data" >
    <fieldset>
        <legend>Ajouter un nouveau parcours : </legend>
    <div class="form-group">
        <label class="col-sm-2 control-label">Label : </label>
        <div class="col-sm-10"><input type="text" name="label" /></div>
        <p class="text-danger"> <?php if($this->tMessage and isset($this->tMessage['label'])): echo  implode(',',$this->tMessage['label']); endif;?></p>
    </div>


    <div class="form-group">
        <label class="col-sm-2 control-label">Fichier GPX (*.gpx) : </label>
        <div class="col-sm-10"><input type="file" name="fileGPX" /></div>
        <?php  if($this->tMessage and isset($this->tMessage['extension'])):?><p class="text-danger" ><?php echo $this->tMessage['extension']; ?></p> <?php endif;?></p>
    </div>
    <div class="form-group">
        <div class="col-sm-offset-2 col-sm-10">
            <input type="submit" class="btn btn-success" value="Sauvegarder" /> <a class="btn btn-danger" href="<?php echo $this->getLink('parcours::list')?>">Annuler</a>
        </div>
    </div>
    <?php if($this->tMessage and isset($this->tMessage['message'])):?> <p class="<?php if($this->tMessage['lvlError']!=1){echo 'bg-success'; }else{echo 'bg-warning'; } ?> "><?php echo $this->tMessage['message']; ?></p> <?php endif;?>
    </fieldset>
</form>