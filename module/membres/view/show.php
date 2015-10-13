

	
	<fieldset>
            <legend>
                <img <?php if($this->oMembres->chkSignaleur != 1): ?> style="display: none" <?php endif; ?> src="../css/images/chasuble-J-36x47.png" alt="Chasuble Jaune" height="15" width="15" TITLE="Signaleur Volontaire">
                
                <?php echo ' '.$this->oMembres->indexMembre .' : '.$this->oMembres->nom .' '. $this->oMembres->prenom.' '; ?>
                <img <?php if($this->oMembres->chkFormulaire != 1): ?> style="display: none" <?php endif; ?> src="../css/images/coche_verte.gif" alt="Coche verte" height="15" width="15" TITLE="Coord. Validées">
                
            </legend>
            <?php if(_root::getACL()->can('ACCESS','permission::list')): ?>
            <div class="legend2"><?php if($this->oMembres->owner){ echo $this->oOwner->login.' ('.$this->oMembres->modifier.')';} ?></div>
            <?php endif;?>
	<div class="col-sm-offset-1">
            <b>Adresse Mail : </b> <?php echo $this->oMembres->mail ?><br/>
            <b>Téléphone Fixe : </b> <?php echo $this->oMembres->fixe ?><br/>
            <b>Téléphone GSM : </b> <?php echo $this->oMembres->gsm ?><br/>
            <?php if($this->oMembres->anneeNaissance!=0) :?>
            <b>Année de Naissance :</b>  <?php echo $this->oMembres->anneeNaissance ?><br/>
            <?php endif;?>
	</div>
        </fieldset>



	<fieldset>
        <legend>Adresse Postale : </legend>
                <div class="col-sm-offset-1">
                    <?php if (strlen(trim($this->oMembres->rue))>=1){  if ($this->oMembres->numero >0){echo $this->oMembres->numero;} echo ' '.  $this->oMembres->rue.' '. $this->oMembres->complement; } ?><br/>
                    <?php if (strlen(trim($this->oMembres->ville))>=1){ if ($this->oMembres->codePostal >0){echo $this->oMembres->codePostal;} echo ' '.$this->oMembres->ville; } ?><br/>
                </div>
                    </fieldset>
            
        <fieldset>
        <legend>Infos complémentaire : </legend>
            	<div class="col-sm-offset-1">
                    <b>Club / Association : </b>  <?php echo $this->oMembres->club ?><br>
                    <b>N° de Permis : </b> <?php echo $this->oMembres->numPermis ?><br>
                    <b>Commentaire : </b> <?php echo $this->oMembres->comment ?></p></div>
	</div>
        
        </fieldset>
    <?php if($this->tJoinEvents):?>
      <div class="container">
        <fieldset>
            <legend>Participe aux évènements : </legend>
            <div id="checkboxs" class=" ">
   
                   <?php foreach ($this->tJoinEvents as $key => $sNameEvent) :?> 
                    <div class="col-sm-offset-1 checkbox">
                        <form  action="<?php echo $this->getLink('membres::ajaxJoinEventMembre'); ?>" method="POST" >
                        <INPUT id="chk_Ev_<?php echo $key;?>" type="checkbox" name="action" value="<?php echo $key;?>" 
                               <?php if(in_array($key, $this->tJoinIdEvents)) :?> checked="checked" <?php endif;?>
                               <?php if ( !_root::getACL()->can('ACCESS','membres::ajaxJoinEventMembre')):?> disabled="disabled" <?php endif;?>
                             >                  
                 
                           <a  href="
                               <?php 
                               if ( _root::getACL()->can('ACCESS','events::show')){
                                    echo $this->getLink('events::show',array('id'=>$key));                               
                               }?>
                               
                               "><?php echo $sNameEvent ?></a>
                        <noscript>
                        <input id='EventHidden' type='hidden' value='<?php echo $key;?>' name='EventHidden'>
                        <input type='hidden' value='<?php echo $key;?>' name='idEventHidden'>
                        <input type='hidden' value='<?php echo $this->oMembres->idMembre ?>' name='idMembreHidden'>
                        <button value="Ajouter">Ajouter ce membre à cet évènement</button></noscript>
                        </form>  
                    </div>

                   <?php endforeach;?>

               
           </div>
        
        </fieldset>
        </div>
    <?php endif;?>

    

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

<script language="Javascript">
   window.onload = function(){  
       console.log( "ready!" );
    
   
 $('div#checkboxs div.col-sm-offset-1.checkbox input').on('click',function(){
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
