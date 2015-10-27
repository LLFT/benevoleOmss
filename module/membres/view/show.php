<?php if(!isset($this->oMembre)) :?>
    
    <p>Aucun Membre n'est connu sous cet ID.</p><br> 
    <a class="btn btn-danger" href="<?php echo $this->getLink('membres::list')?>">Retour</a>

<?php else :?>
	
	<fieldset>
            <legend>
                <img <?php if($this->oMembre->chkSignaleur != 1): ?> style="display: none" <?php endif; ?> src="../css/images/chasuble-J-36x47.png" alt="Chasuble Jaune" height="15" width="15" TITLE="Signaleur Volontaire">
                
                <?php if ($this->oMembre->active != 1) :?> <s> <?php endif; ?>  <?php echo $this->oMembre->nom .' '. $this->oMembre->prenom; ?> <?php if ($this->oMembre->active != 1) :?> </s> <?php endif; ?>
                
                <img <?php if($this->oMembre->chkFormulaire != 1): ?> style="display: none" <?php endif; ?> src="../css/images/coche_verte.gif" alt="Coche verte" height="15" width="15" TITLE="Coord. Validées">
                
            </legend>
            
	<div class="col-sm-offset-1">
            <b>Adresse Mail : </b> <?php echo $this->oMembre->mail ?><br/>
            <b>Téléphone Fixe : </b> <?php echo $this->oMembre->fixe ?><br/>
            <b>Téléphone GSM : </b> <?php echo $this->oMembre->gsm ?><br/>
            <?php if($this->oMembre->anneeNaissance!=0) :?>
            <b>Année de Naissance :</b>  <?php echo $this->oMembre->anneeNaissance ?><br/>
            <?php endif;?>
	</div>
        </fieldset>



	<fieldset>
        <legend>Adresse Postale : </legend>
                <div class="col-sm-offset-1">
                    <?php if (strlen(trim($this->oMembre->rue))>=1){  if ($this->oMembre->numero >0){echo $this->oMembre->numero;} echo ' '.  $this->oMembre->rue.' '. $this->oMembre->complement; } ?><br/>
                    <?php if (strlen(trim($this->oMembre->ville))>=1){ if ($this->oMembre->codePostal >0){echo $this->oMembre->codePostal;} echo ' '.$this->oMembre->ville; } ?><br/>
                </div>
                    </fieldset>
            
        <fieldset>
        <legend>Infos complémentaire : </legend>
            	<div class="col-sm-offset-1">
                    <b>Club / Association : </b>  <?php echo $this->oMembre->club ?><br>
                    <b>N° de Permis : </b> <?php echo $this->oMembre->numPermis ?><br>
                    <b>Commentaire : </b> <?php echo $this->oMembre->comment ?></p></div>
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
                        <input type='hidden' value='<?php echo $this->oMembre->idMembre ?>' name='idMembreHidden'>
                        <button value="Ajouter">Ajouter ce membre à cet évènement</button></noscript>
                        </form>  
                    </div>

                   <?php endforeach;?>

               
           </div>
        
        </fieldset>
        </div>
    <?php endif;?>

    

<div class="col-sm-offset-1 btn-group" role="group">
   
        <a class="btn bg-info" href="<?php echo $this->getLink('membres::show',array( 'id'=>($this->oMembre->idMembre-1)))?>">Membre Prec.</a>	 
	
        <?php if (( _root::getACL()->can('ACCESS','membres::edit'))&&($this->oMembre->active != 0)):?>            
            <a class="col-sm-offset-1 btn btn-success" href="<?php echo $this->getLink('membres::edit',array( 'id'=>$this->oMembre->idMembre))?>">Editer</a>	 
        <?php elseif (_root::getACL()->can('ACCESS','permission::list')) :?>
            <a class="btn btn-success" href="<?php echo $this->getLink('membres::undelete',array('id'=>$this->oMembre->idMembre))?>">RéIntégrer</a>
        <?php endif; ?>
            
        <?php if ( _root::getACL()->can('ACCESS','membres::localizeMember')):?>   
        <?php if (($this->oMembre->rue !="")&&($this->oMembre->coord !=1)&&($this->oMembre->active != 0)):?>            
            <a class="btn btn-default" href="<?php echo $this->getLink('membres::localizeMember',array( 'id'=>$this->oMembre->idMembre))?>">Localiser</a>
        <?php elseif (($this->oMembre->rue !="")&&($this->oMembre->coord == 1)&&($this->oMembre->active != 0)) :?>    
            <a class="btn btn-default" href="<?php echo $this->getLink('membres::localizeMember',array( 'id'=>$this->oMembre->idMembre))?>">Re-Localiser</a>
        <?php endif;?> 
        <?php endif;?>
            
                
        <a class="btn btn-danger" href="<?php echo $this->getLink('membres::list',array( 'letter'=>$this->oMembre->nom[0]))?>">Retour</a>
        <a class="btn bg-info" href="<?php echo $this->getLink('membres::show',array( 'id'=>($this->oMembre->idMembre+1)))?>">Membre Suiv.</a>	 

    
</div>
    <?php if(_root::getACL()->can('ACCESS','permission::list')): ?>
        <div class="legend2">
            <?php if($this->oMembre->owner){ echo 'Créé par '. $this->oOwner->login.' ('.$this->oMembre->creer.')';} ?><br>
            <?php if($this->oMembre->updater){ echo 'Modifié par '.$this->oUpdater->login.' ('.$this->oMembre->modifier.')';} ?><br>
            <?php if($this->oMembre->deleter){ echo 'Supprimé par '.$this->oDeleter->login.' ('.$this->oMembre->supprimer.')';} ?><br>
        </div>
    <?php endif;?>
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
            url: 'index.php?:nav=membres::ajaxJoinEventMembre&action='+action+'&idMembre='+<?php echo $this->oMembre->idMembre; ?>+'&idEvent='+this.value,
            
        });
      
      
    });
        
   };   
  </script>
<?php endif; ?>