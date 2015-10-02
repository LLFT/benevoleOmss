<?php if(isset($this->oModulePagination))echo $this->oModulePagination->show();?>
<table class="table table-striped">
	<tr>
            <th></th>
		<th>Nom</th>

		<th>Prénom</th>

		<th>Téléphone Fixe</th>

		<th>Téléphone GSM</th>

		<th>Ville</th>
                
		<th>Adresse Mail</th>

		<th>Actions</th>
	</tr>
	<?php if($this->tMembres):?>
		<?php foreach($this->tMembres as $oMembres):?>
		<tr <?php echo plugin_tpl::alternate(array('','class="alt"'))?>>
                    
                <td> <img TITLE="Signaleur" id="chasubleSignal_<?php echo $oMembres->getId();?>" <?php if($oMembres->chkSignaleur != 1): ?> style="display: none" <?php endif; ?> src="../css/images/chasuble-J-36x47.png" alt="Chasuble Jaune" height="15" width="15">
                    <img TITLE="chkFormulaire" id="validForm_<?php echo $oMembres->getId();?>" <?php if($oMembres->chkFormulaire != 1): ?> style="display: none" <?php endif; ?> src="../css/images/coche_verte.gif" alt="Coche verte" height="15" width="15">
                    <?php echo ' '.$oMembres->indexMembre .' : '?></td>    
		<td><?php echo $oMembres->nom ?></td>

		<td><?php echo $oMembres->prenom ?></td>

		<td><?php echo $oMembres->fixe ?></td>

		<td><?php echo $oMembres->gsm ?></td>

                <td><?php echo $oMembres->ville ?></td>

                <td><?php echo $oMembres->mail ?></td>



			<td>
				
				

<div class="btn-group">
  <a class="btn btn-primary btn-xs" href="<?php echo $this->getLink('membres::show',array( 'id'=>$oMembres->getId()))?>">Consulter Fiche</a>  
  <button type="button" class="btn btn-primary dropdown-toggle btn-xs" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
    <span class="caret"></span>
    <span class="sr-only">Toggle Dropdown</span>
  </button>
  <ul class="dropdown-menu">      
    <li><a class="btn btn-large btn-block" href="<?php echo $this->getLink('membres::edit',array( 'id'=>$oMembres->getId()))?>">Editer Fiche</a></li>
    <li role="separator" class="divider"></li>
    <li><a onclick="btnSignalFnt(<?php echo $oMembres->getId().','.$oMembres->chkSignaleur ?>)" id="btnSignal" class="btn btn-large btn-block" href="#"> Signaleur <span id="glyphSignal_<?php echo $oMembres->getId();?>" <?php if($oMembres->chkSignaleur != 1): ?> style="display: none" <?php endif; ?>class="add-on glyphicon glyphicon-ok"></span></a></li>
  </ul>
</div>


				
				
			</td>
		</tr>	
		<?php endforeach;?>
	<?php else:?>
		<tr>
			<td colspan="13">Aucune ligne</td>
		</tr>
	<?php endif;?>
</table>

<?php if(isset($this->oModulePagination))echo $this->oModulePagination->show();?>

<p>
<div class="btn-group" role="group">


	<?php if ( _root::getACL()->can('ACCESS','membres::new')):?>
		<a  class="btn btn-success" href="<?php echo $this->getLink('membres::new') ?>">Ajouter membre</a>
	<?php endif;?>
	
	<div class="btn-group dropup">
		<button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
			Filtres <span class="caret"></span>
		</button>
		<ul class="dropdown-menu">
			<li><a href="<?php echo $this->getLink('membres::listEmptyAdress') ?>">Adresses Postale Manquantes</a></li>
			<li><a href="<?php echo $this->getLink('membres::listEmptyMail') ?>">Adresses Mail Manquantes</a></li>
			<li><a href="<?php echo $this->getLink('membres::listEmptyPermis') ?>">Permis de conduire Manquants</a></li>
			<!--    <li role="separator" class="divider"></li>
			<li><a href="#">Exporter</a></li>-->
		</ul>
	</div>

	<?php if ( _root::getACL()->can('ACCESS','membres::exportCSV')):?>
		<a class="btn btn-success" href="<?php echo $this->getLink('membres::exportCSV',array('action'=>$this->sAction)) ?>">Exporter</a>
	<?php endif;?>
<script language="Javascript">
   window.onload = function(){  
       console.log( "ready!" );
    };   
    
    function btnSignalFnt(paramId){
        console.log( "click" );
        $.ajax({
            url: 'index.php?:nav=membres::ajaxSignaleur&id='+paramId+'',
            success: function() {
            // call function
            showGlyphSignal(paramId);
            }
        });
    }
    
    function showGlyphSignal(paramId){
        $('#glyphSignal_'+paramId).toggle();
        $('#chasubleSignal_'+paramId).toggle();
    }
        
   
  </script>
</div>

