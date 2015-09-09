<?php 
$oForm=new plugin_form($this->oEvents);
$oForm->setMessage($this->tMessage);
?>
<form class="form-horizontal" action="" method="POST" >

	
	<div class="form-group">
		<label class="col-sm-2 control-label">Nom de l'évènement</label>
		<div class="col-sm-10"><?php echo $oForm->getInputText('nomEvent',array('class'=>'form-control'))?></div>
	</div>

	<div class="form-group">
		<label class="col-sm-2 control-label">Date</label>
		<div class="col-sm-10"><?php echo $oForm->getInputText('date',array('class'=>'form-control'))?></div>
	</div>

	<div class="form-group">
		<label class="col-sm-2 control-label">Lieux</label>
		<div class="col-sm-10"><?php echo $oForm->getInputText('lieux',array('class'=>'form-control'))?></div>
	</div>

	<div class="form-group">
		<label class="col-sm-2 control-label">description</label>
		<div class="col-sm-10"><?php echo $oForm->getInputTextarea('description',array('class'=>'form-control'))?></div>
	</div>


<?php echo $oForm->getToken('token',$this->token)?>
    
        <script language="Javascript">
           function chargeDatePicker(){
            $('input[name="date"]').datepicker($.datepicker.regional[ "fr" ]);
           } 
            
window.onload=chargeDatePicker ; 
        </script> 

<div class="form-group">
    <div class="col-sm-offset-2 col-sm-10">
		<input type="submit" class="btn btn-success" value="Modifier" /> <a class="btn btn-link" href="<?php echo $this->getLink('events::list')?>">Annuler</a>
	</div>
</div>
</form>

