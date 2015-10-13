<table class="table table-striped">
	<tr>	
            <th>Session</th>
            <th>Nom</th>                
            <th>Prénom</th>
            <th>État</th>
            <th>Groupe</th>
            <th>Actions</th>
	</tr>
	<?php if($this->tAccount):?>
		<?php foreach($this->tAccount as $oAccount):?>
                    <tr <?php echo plugin_tpl::alternate(array('','class="alt"'))?>>
	
                        <td><?php echo strtoupper($oAccount->login) ?></td>
                        <td><?php echo $oAccount->nomUser ?></td>
                        <td><?php echo $oAccount->prenomUser ?></td>
                        
                        <td><?php if ($oAccount->active !=0) : ?>
                                Actif
                            <?php else: ?>
                                Inactif
                            <?php endif; ?>                        
                        </td>
                        <td><?php if(isset($this->tJoinmodel_groupe[$oAccount->groupe_id])){ echo $this->tJoinmodel_groupe[$oAccount->groupe_id];}else{ echo $oAccount->groupe_id ;}?></td>
			<td>
				
				
<a class="btn btn-success" href="<?php echo $this->getLink('account::edit',array(
										'id'=>$oAccount->getId()
									) 
							)?>">Editer</a>

<a class="btn btn-danger" href="<?php echo $this->getLink('account::delete',array(
										'id'=>$oAccount->getId()
									) 
							)?>">Supprimer</a>

<!--<a class="btn btn-default" href="<?php echo $this->getLink('account::show',array(
										'id'=>$oAccount->getId()
									) 
							)?>">Show</a>-->

				
				
			</td>
		</tr>	
		<?php endforeach;?>
	<?php else:?>
		<tr>
			<td colspan="3">Aucune ligne</td>
		</tr>
	<?php endif;?>
</table>

<p><a class="btn btn-primary" href="<?php echo $this->getLink('account::new') ?>">New</a></p>

