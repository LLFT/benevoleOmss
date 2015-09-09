<table class="table table-striped">
	<tr>
		
		<th>name</th>

		<th></th>
	</tr>
	<?php if($this->tGroupe):?>
		<?php foreach($this->tGroupe as $oGroupe):?>
		<tr <?php echo plugin_tpl::alternate(array('','class="alt"'))?>>
			
		<td><?php echo $oGroupe->name ?></td>

			<td>
				
				
<a class="btn btn-success" href="<?php echo $this->getLink('groupe::edit',array(
										'id'=>$oGroupe->getId()
									) 
							)?>">Edit</a>

<a class="btn btn-danger" href="<?php echo $this->getLink('groupe::delete',array(
										'id'=>$oGroupe->getId()
									) 
							)?>">Delete</a>

<a class="btn btn-default" href="<?php echo $this->getLink('groupe::show',array(
										'id'=>$oGroupe->getId()
									) 
							)?>">Show</a>

				
				
			</td>
		</tr>	
		<?php endforeach;?>
	<?php else:?>
		<tr>
			<td colspan="2">Aucune ligne</td>
		</tr>
	<?php endif;?>
</table>

<p><a class="btn btn-primary" href="<?php echo $this->getLink('groupe::new') ?>">New</a></p>

