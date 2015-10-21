<?php 
$oForm=new plugin_form($this->oMembres);
$oForm->setMessage($this->tMessage);
?>
	
	<fieldset class="col-sm-12">
            <legend><?php echo $this->oMembres->indexMembre .' : '.$this->oMembres->nom .' '. $this->oMembres->prenom ?></legend>
        </fieldset>
<form class="form-horizontal" action="" method="POST" >
    <div class="col-sm-offset-2 col-sm-10">
Souhaitez-vous supprimer définitivement <b><?php echo$this->oMembres->nom .' '. $this->oMembres->prenom; ?></b> de votre base de membre ?<br/><br/>
    </div>
<!--    <div class="form-group">
		<label class="col-sm-2 control-label">Raison : </label>
		<div class="col-sm-10"><?php // echo $oForm->getInputTextarea('comment',array('class'=>'form-control'))?></div>
	</div>-->
    <input type="hidden" name="token" value="<?php echo $this->token?>" />
    <?php if($this->tMessage and isset($this->tMessage['token'])): echo $this->tMessage['token']; endif;?>


<div class="btn-group">

		<input class="btn btn-danger" type="submit" value="Confirmer la suppression" /> <a class="btn btn-default" href="<?php echo $this->getLink('membres::show',array('id'=>$this->oMembres->idMembre))?>">Annuler</a>
</div>
</form>
