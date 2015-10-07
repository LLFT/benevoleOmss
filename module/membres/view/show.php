
<form class="form-horizontal" action="" method="POST" >
	
	<fieldset class="col-sm-12">
            <legend>
                <img <?php if($this->oMembres->chkSignaleur != 1): ?> style="display: none" <?php endif; ?> src="../css/images/chasuble-J-36x47.png" alt="Chasuble Jaune" height="15" width="15" TITLE="Signaleur Volontaire">
                
                <?php echo ' '.$this->oMembres->indexMembre .' : '.$this->oMembres->nom .' '. $this->oMembres->prenom.' '; ?>
                <img <?php if($this->oMembres->chkFormulaire != 1): ?> style="display: none" <?php endif; ?> src="../css/images/coche_verte.gif" alt="Coche verte" height="15" width="15" TITLE="Coord. Validées">
            </legend>

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
        
        <div class="form-group">
		<label class="col-sm-2 control-label">Commentaire : </label>
		<div class="col-sm-10"><p class="form-control-static"><?php echo $this->oMembres->comment ?></p></div>
	</div>
        
        </fieldset>
    <?php if($this->tJoinEvents):?>
      <div class="container">
        <fieldset>
            <legend>Participe aux évènements : </legend>
            <div id="checkboxs" class=" form-group">
   
                   <?php foreach ($this->tJoinEvents as $key => $sNameEvent) :?> 
                    <div class="col-sm-offset-1 checkbox">
                        
                        <INPUT type="checkbox" name="<?php echo 'Event_'.$key;?>" value="<?php echo $key;?>" 
                               <?php if(in_array($key, $this->tJoinIdEvents)) :?> checked="checked" <?php endif;?>
                               <?php if ( !_root::getACL()->can('ACCESS','events::list')):?> disabled="disabled" <?php endif;?>
                             >                  
                 
                           <a  href="
                               <?php 
                               if ( _root::getACL()->can('ACCESS','events::list')){
                                    echo $this->getLink('events::show',array('id'=>$key));                               
                               }?>
                               
                               "><?php echo $sNameEvent ?></a>
  
                    </div>

                   <?php endforeach;?>

               
           </div>
        
        </fieldset>
        </div>
    <?php endif;?>

    
</fieldset>
<div class="col-sm-offset-1 btn-group" role="group">
   
        <a class="btn bg-info" href="<?php echo $this->getLink('membres::show',array( 'id'=>($this->oMembres->idMembre-1)))?>">Membre Prec.</a>	 
	
        <?php if ( _root::getACL()->can('ACCESS','membres::edit')):?>
            <a class="col-sm-offset-1 btn btn-success" href="<?php echo $this->getLink('membres::edit',array( 'id'=>$this->oMembres->idMembre))?>">Editer</a>	 
        <?php endif;?>
            
        <?php if ( _root::getACL()->can('ACCESS','membres::localizeMember')):?>   
        <?php if (($this->oMembres->rue !="")&&($this->oMembres->coord !=1)):?>            
            <a class="btn btn-default" href="<?php echo $this->getLink('membres::localizeMember',array( 'id'=>$this->oMembres->idMembre))?>">Localiser</a>
        <?php elseif (($this->oMembres->rue !="")&&($this->oMembres->coord == 1)) :?>    
            <a class="btn btn-default" href="<?php echo $this->getLink('membres::localizeMember',array( 'id'=>$this->oMembres->idMembre))?>">Re-Localiser</a>
        <?php endif;?> 
        <?php endif;?>
            
                
        <a class="btn btn-danger" href="<?php echo $this->getLink('membres::list',array( 'letter'=>$this->oMembres->nom[0]))?>">Retour</a>
        <a class="btn bg-info" href="<?php echo $this->getLink('membres::show',array( 'id'=>($this->oMembres->idMembre+1)))?>">Membre Suiv.</a>	 

    
</div>
</form>

<script language="Javascript">
   window.onload = function(){  
       console.log( "ready!" );
    
   
 $('div#checkboxs.form-group div.col-sm-offset-1.checkbox input').on('click',function(){
     cochee = $(this).is(':checked');
     action='unjoin';
    if(cochee){
         action='join';
     }
        $.ajax({
            url: 'index.php?:nav=membres::ajaxJoinEventMembre&action='+action+'&idMembre='+<?php echo $this->oMembres->idMembre; ?>+'&idEvent='+this.value,
            
        });
      
      
    });
        
   };   
  </script>
