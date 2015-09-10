<table class="table table-striped">
	<tr>
		
		<th>label : </th>

		<th>url</th>

		<th></th>
	</tr>
	<?php if($this->tParcours):?>
		<?php foreach($this->tParcours as $oParcours):?>
		<tr <?php echo plugin_tpl::alternate(array('','class="alt"'))?>>
			
		<td><?php echo $oParcours->label ?></td>

		<td><?php echo $oParcours->url ?></td>

			<td>
				
				
<a class="btn btn-danger" href="<?php echo $this->getLink('parcours::delete',array(
										'id'=>$oParcours->getId()
									) 
							)?>">Delete</a>

<a class="btn btn-default" href="<?php echo $this->getLink('parcours::show',array(
										'id'=>$oParcours->getId()
									) 
							)?>">Show</a>

				
				
			</td>
		</tr>	
		<?php endforeach;?>
	<?php else:?>
		<tr>
			<td colspan="3">Aucune ligne</td>
		</tr>
	<?php endif;?>
</table>

<p><a class="btn btn-primary" href="<?php echo $this->getLink('parcours::new') ?>">New</a></p>

