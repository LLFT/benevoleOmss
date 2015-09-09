<form class="form-horizontal" action="" method="POST" >
	
	<form class="form-horizontal" action="" method="POST">

    <fieldset class="col-sm-12">
            <legend><?php echo $this->oAccount->login ?></legend>
            
            <div class="form-group">
		<label class="col-sm-2 control-label">Nom : </label>
		<div class="col-sm-10"><?php echo $this->oAccount->nomUser ?></div>
            </div>

            <div class="form-group">
		<label class="col-sm-2 control-label">Prenom : </label>
		<div class="col-sm-10"><?php echo $this->oAccount->prenomUser ?></div>
            </div>
    </fieldset>


<div class="form-group">
    <div class="col-sm-offset-2 col-sm-10">
		 <a class="btn btn-default" href="<?php echo $this->getLink('account::list')?>">Retour</a>
	</div>
</div>
</form>
