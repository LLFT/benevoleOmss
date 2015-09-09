<?php 
$oForm=new plugin_form($this->oAccount);
$oForm->setMessage($this->tMessage);
?>
<form  class="form-horizontal" action="" method="POST" >

	
	<div class="form-group">
		<label class="col-sm-2 control-label">Utilisateur : </label>
		<div class="col-sm-10"><?php echo $oForm->getInputText('login',array('class'=>'form-control'))?></div>
	</div>

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
                <div class="col-sm-10"><?php echo $oForm->getInputPassword('pass',array('class'=>'form-control','type'=>'password'))?></div>
            </div>
            
            <div class="form-group">
		<label class="col-sm-2 control-label">Confirmation : </label>
		<div class="col-sm-10"><?php echo $oForm->getInputPassword('pass2',array('class'=>'form-control','type'=>'password'))?></div>
            </div>


<?php echo $oForm->getToken('token',$this->token)?>


<div class="form-group">
    <div class="col-sm-offset-2 col-sm-10">
		<input type="submit" class="btn btn-success" value="Créer" /> <a class="btn btn-link" href="<?php echo $this->getLink('account::list')?>">Annuler</a>
	</div>
</div>
</form>
