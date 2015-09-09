<?php 
$oForm=new plugin_form($this->oParcours);
$oForm->setMessage($this->tMessage);
?>

<form  class="form-horizontal" action="" method="POST" enctype="multipart/form-data" >
    <fieldset>
        <legend>Ajouter un nouveau parcours : </legend>
    <div class="form-group">
        <label class="col-sm-2 control-label">Label : </label>
        <div class="col-sm-4"><?php echo $oForm->getInputText('label',array('class'=>'form-control','maxlength'=>"40"))?></div>
    </div>


    <div class="form-group">
        <label class="col-sm-2 control-label">Fichier GPX (*.gpx) : </label>
        <div class="col-sm-10"><input type="file" name="fileGPX" /></div>        
    </div>
    <div class="form-group">
        <div class="col-sm-offset-2 col-sm-10">
            <input type="submit" class="btn btn-success" value="Sauvegarder" /> <a class="btn btn-danger" href="<?php echo $this->getLink('parcours::list')?>">Annuler</a>
        </div>
    </div>    
    </fieldset>
</form>