<table class="table table-striped">
	<tr>
		
		<th>Nom de l'élément</th>

		<th>Actions</th>
	</tr>
	<?php if($this->tElement):?>
		<?php foreach($this->tElement as $oElement):?>
		<tr <?php echo plugin_tpl::alternate(array('','class="alt"'))?>>
			
		<td><?php echo $oElement->element ?></td>
                <td><?php echo $oElement->descElement ?></td>

			<td>
				
				
<a class="btn btn-success" href="<?php echo $this->getLink('element::edit',array(
										'id'=>$oElement->getId()
									) 
							)?>">Edit</a>

<a class="btn btn-danger" href="<?php echo $this->getLink('element::delete',array(
										'id'=>$oElement->getId()
									) 
							)?>">Delete</a>

				
				
			</td>
		</tr>	
		<?php endforeach;?>
	<?php else:?>
		<tr>
			<td colspan="2">Aucune ligne</td>
		</tr>
	<?php endif;?>
</table>

<p><a class="btn btn-primary" href="<?php echo $this->getLink('element::new') ?>">Ajouter un élément</a></p>

