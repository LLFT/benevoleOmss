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
				
				


<a class="btn btn-primary btn-xs" href="<?php echo $this->getLink('membres::show',array( 'id'=>$oMembres->getId()))?>">Consulter Fiche</a>

				
				
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
<?php if ( _root::getACL()->can('ACCESS','membres::new')):?>
    <a  class="btn btn-success" href="<?php echo $this->getLink('membres::new') ?>">Ajouter membre</a>
 <?php endif;?>
<?php if ( _root::getACL()->can('ACCESS','membres::exportCSV')):?>
    <a class="btn btn-success" href="<?php echo $this->getLink('membres::exportCSV',array('action'=>$this->sAction)) ?>">Exporter</a>
<?php endif;?>
</p>

