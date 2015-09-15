
<form class="form-horizontal" action="" method="POST" >
	
	<fieldset class="col-sm-12">
            <legend><img <?php if($this->oMembres->chkSignaleur != 1): ?> style="display: none" <?php endif; ?> src="../css/images/chasuble-J-36x47.png" alt="Chasuble Jaune" height="15" width="15"><?php echo ' '.$this->oMembres->indexMembre .' : '.$this->oMembres->nom .' '. $this->oMembres->prenom ?></legend>

	<div class="form-group">
		<label class="col-sm-2 control-label">Adresse Mail : </label>
		<div class="col-sm-10"><p class="form-control-static"><?php echo $this->oMembres->mail ?></p></div>
	</div>

	<div class="form-group">
		<label class="col-sm-2 control-label">Téléphone Fixe : </label>
		<div class="col-sm-10"><p class="form-control-static"><?php echo $this->oMembres->fixe ?></p></div>
	</div>

	<div class="form-group">
		<label class="col-sm-2 control-label">Téléphone GSM : </label>
		<div class="col-sm-10"><p class="form-control-static"><?php echo $this->oMembres->gsm ?></p></div>
	</div>
            
        <div class="form-group">
		<label class="col-sm-2 control-label">Année de Naissance : </label>
		<div class="col-sm-10"><p class="form-control-static"><?php echo $this->oMembres->anneeNaissance ?></p></div>
	</div>



	<fieldset>
        <legend>Adresse Postale : </legend>
            <div class="form-group">
                <label class="col-sm-2 control-label">Adresse : </label>
                <div class="col-sm-10"><p class="form-control-static"><?php if (strlen(trim($this->oMembres->rue))>=1){  if ($this->oMembres->numero >0){echo $this->oMembres->numero;} echo ' '.  $this->oMembres->rue.' '. $this->oMembres->complement; } ?></p></div>
                    <div class="col-sm-offset-2 col-sm-10"><p class="form-control-static"><?php if (strlen(trim($this->oMembres->ville))>=1){ if ($this->oMembres->codePostal >0){echo $this->oMembres->codePostal;} echo ' '.$this->oMembres->ville; } ?></p></div>
            </div>
        </fieldset>
            
        <fieldset>
        <legend>Infos complémentaire : </legend>
            	<div class="form-group">
		<label class="col-sm-2 control-label">Club / Association : </label>
		<div class="col-sm-10"><p class="form-control-static"><?php echo $this->oMembres->club ?></p></div>
	</div>

	<div class="form-group">
		<label class="col-sm-2 control-label">N° de Permis : </label>
		<div class="col-sm-10"><p class="form-control-static"><?php echo $this->oMembres->numPermis ?></p></div>
	</div>
        </fieldset>
    

        <fieldset>
        <legend>Localisation : </legend>
        <?php if(isset($this->oModuleGoogleMap)):?>
            <div class="col-sm-offset-3 col-sm-7">
                <p class="form-control-static"><?php echo $this->oModuleGoogleMap->show();?></p>
            </div> 
           
        <?php else:?>
        
            <?php if($this->oMembres->rue ==""):?>
                <div class="col-sm-offset-3 col-sm-7">
                    <p>Les informations sont insuffisantes pour localiser ce membre.</p>
                </div>
            <?php endif;?>
        <?php endif;?>
        </fieldset>
    
</fieldset>
<div class="form-group">
    <div class="col-sm-offset-1 col-sm-10">
        <a class="btn btn-primary btnNext" href="<?php echo $this->getLink('membres::show',array( 'id'=>($this->oMembres->idMembre-1)))?>">Membre Prec.</a>	 
	
        <?php if ( _root::getACL()->can('ACCESS','membres::edit')):?>
            <a class="col-sm-offset-1 btn btn-success" href="<?php echo $this->getLink('membres::edit',array( 'id'=>$this->oMembres->idMembre))?>">Edit</a>	 
        <?php endif;?>
            
        <?php if ( _root::getACL()->can('ACCESS','membres::localizeMember')):?>   
            <?php if (($this->oMembres->rue !="")&&($this->oMembres->coord !=1)):?>            
                <a class="btn btn-info" href="<?php echo $this->getLink('membres::localizeMember',array( 'id'=>$this->oMembres->idMembre))?>">Localiser</a>
            <?php elseif (($this->oMembres->rue !="")&&($this->oMembres->coord == 1)) :?>    
                <a class="btn btn-info" href="<?php echo $this->getLink('membres::localizeMember',array( 'id'=>$this->oMembres->idMembre))?>">Re-Localiser</a>
            <?php endif;?> 
        <?php endif;?>
                
        <a class="btn btn-default" href="<?php echo $this->getLink('membres::list',array( 'letter'=>$this->oMembres->nom[0]))?>">Retour</a>
        <a class="col-sm-offset-1 btn btn-primary" href="<?php echo $this->getLink('membres::show',array( 'id'=>($this->oMembres->idMembre+1)))?>">Membre Suiv.</a>	 
	</div>
    
</div>
</form>
