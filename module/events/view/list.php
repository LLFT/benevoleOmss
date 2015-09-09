<table class="table table-striped">
	<tr>
		
		<th>Nom de l'évènement</th>

		<th>Date</th>

		<th>Lieux</th>


		<th></th>
	</tr>
	<?php if($this->tEvents):?>
		<?php foreach($this->tEvents as $oEvents):?>
		<tr <?php echo plugin_tpl::alternate(array('','class="alt"'))?>>
			
		<td><?php echo $oEvents->nomEvent ?></td>

		<td><?php echo $oEvents->date ?></td>

		<td><?php echo $oEvents->lieux ?></td>

			<td>
				
				
<a class="btn btn-success" href="<?php echo $this->getLink('events::edit',array(
										'id'=>$oEvents->getId()
									) 
							)?>">Edit</a>

<a class="btn btn-danger" href="<?php echo $this->getLink('events::delete',array(
										'id'=>$oEvents->getId()
									) 
							)?>">Delete</a>

<a class="btn btn-default" href="<?php echo $this->getLink('events::show',array(
										'id'=>$oEvents->getId()
									) 
							)?>">Show</a>

				
				
			</td>
		</tr>	
		<?php endforeach;?>
	<?php else:?>
		<tr>
			<td colspan="5">Aucune ligne</td>
		</tr>
	<?php endif;?>
</table>

<p><a class="btn btn-primary" href="<?php echo $this->getLink('events::new') ?>">Ajouter un évènement</a></p>

