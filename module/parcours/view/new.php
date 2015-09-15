<?php 
$oForm=new plugin_form($this->oParcours);
$oForm->setMessage($this->tMessage);
?>
<form  class="form-horizontal" action="" method="POST"  enctype="multipart/form-data">	
    <div class="form-group">
        <label class="col-sm-2 control-label">Label : </label>
        <div class="col-sm-10"><?php echo $oForm->getInputText('label',array('class'=>'form-control'))?></div>
    </div>
    <div class="form-group">
        <label class="col-sm-2 control-label">Fichier GPX (*.gpx) :</label>
        <div class="col-sm-10"><?php echo $oForm->getInputUpload('url',array('accept'=>".gpx"))?></div>
    </div>

        <?php echo $oForm->getToken('token',$this->token)?>

    <div class="form-group">
        <div class="col-sm-offset-2 col-sm-10">
            <input type="submit" class="btn btn-success" value="Ajouter" /> <a class="btn btn-link" href="<?php echo $this->getLink('events::show',array( 'id'=>_root::getParam('idEvent')))?>">Annuler</a>
        </div>
    </div>
</form>
