<?php 
$oForm=new plugin_form($this->oAccount);
$oForm->setMessage($this->tMessage);
?>

<form class="form-horizontal" action="" method="POST" >

	
    <form class="form-horizontal" action="" method="POST">

        <fieldset class="col-sm-12">
            <legend><?php echo strtoupper($this->oAccount->login) ?></legend>
            <?php echo $oForm->getInputHidden('login') ?>
            <div class="form-group">
		<label class="col-sm-2 control-label">Nom : </label>
		<div class="col-sm-10"><?php echo $oForm->getInputText('nomUser',array('class'=>'form-control'))?></div>
            </div>

            <div class="form-group">
		<label class="col-sm-2 control-label">Prenom : </label>
		<div class="col-sm-10"><?php echo $oForm->getInputText('prenomUser',array('class'=>'form-control'))?></div>
            </div>
            
            <div class="form-group">
		<label class="col-sm-2 control-label">Groupe</label>
		<div class="col-sm-10"><?php echo $oForm->getSelect('groupe_id',$this->tJoinmodel_groupe,array('class'=>'form-control'))?></div>
            </div>
            
            <div class="form-group">
		<label class="col-sm-2 control-label">Email : </label>
		<div class="col-sm-10"><?php echo $oForm->getInputText('emailUser',array('class'=>'form-control'))?></div>
            </div>
            
            <div class="form-group">
		<label class="col-sm-2 control-label">Mot de passe : </label>
                <div class="col-sm-10"><?php echo $oForm->getInputPasswordEmpty('pass',array('class'=>'form-control'))?></div>
            </div>
            <div class="form-group">
                <label class="col-sm-2 control-label">Etat : </label>
                <div class="col-sm-10"><?php echo $oForm->getInputCheckbox('active',1, array('class'=>'form-control'))?></div>
            </div>
        </fieldset>
    
<?php echo $oForm->getToken('token',$this->token)?>
<script language="Javascript">
function happycode(){
    $.fn.bootstrapSwitch.defaults.onText = "Activer";
    $.fn.bootstrapSwitch.defaults.offText = "Désactiver";
    $.fn.bootstrapSwitch.defaults.onColor = "success";
    $.fn.bootstrapSwitch.defaults.offColor = "danger";
   $('input[name="active"]').bootstrapSwitch();
}     
window.onload=happycode ; 
</script>

<div class="form-group">
    <div class="col-sm-offset-2 col-sm-10">
		<input type="submit" class="btn btn-success" value="Modifier" /> <a class="btn btn-link" href="<?php echo $this->getLink('account::list')?>">Annuler</a>
	</div>
</div>
</form>

