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
                    
                <td><?php echo $oMembres->indexMembre .' : '?></td>    
		<td><?php echo $oMembres->nom ?></td>

		<td><?php echo $oMembres->prenom ?></td>

		<td><?php echo $oMembres->fixe ?></td>

		<td><?php echo $oMembres->gsm ?></td>

                <td><?php echo $oMembres->ville ?></td>

                <td><?php echo $oMembres->mail ?></td>



			<td>
				
				

<div class="btn-group">
  <button type="button" class="btn btn-primary btn-xs">Actions</button>
  <button type="button" class="btn btn-primary dropdown-toggle btn-xs" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
    <span class="caret"></span>
    <span class="sr-only">Toggle Dropdown</span>
  </button>
  <ul class="dropdown-menu">
      <li><a class="" href="<?php echo $this->getLink('membres::show',array( 'id'=>$oMembres->getId()))?>">Consulter Fiche</a></li>  
    <li><a href="#">Editer Fiche</a></li>
    <li><a href="#">Ajouter à un Evènement</a></li>
<!--    <li role="separator" class="divider"></li>
    <li><a href="#">Separated link</a></li>-->
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

</div>
</p>

