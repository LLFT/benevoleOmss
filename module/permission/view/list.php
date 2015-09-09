<table class="table table-striped">
	<tr>
		
		<th>Action</th>

		<th>Element</th>

		<th>Allow / Deny</th>

                <th>Groupe</th>

		<th></th>
	</tr>
	<?php if($this->tPermission):?>
		<?php foreach($this->tPermission as $oPermission):?>
		<tr <?php echo plugin_tpl::alternate(array('','class="alt"'))?>>
			
		<td><?php echo $oPermission->action ?></td>

		<td><?php echo $oPermission->element ?></td>

		<td><?php echo $oPermission->allowdeny ?></td>
                
                <td><?php if(isset($this->tJoinmodel_groupe[$oPermission->groupe_id])){ echo $this->tJoinmodel_groupe[$oPermission->groupe_id];}else{ echo $oPermission->groupe_id ;}?></td>

			<td>
				
				
<a class="btn btn-success" href="<?php echo $this->getLink('permission::edit',array(
										'id'=>$oPermission->getId()
									) 
							)?>">Edit</a>

<a class="btn btn-danger" href="<?php echo $this->getLink('permission::delete',array(
										'id'=>$oPermission->getId()
									) 
							)?>">Delete</a>

<a class="btn btn-default" href="<?php echo $this->getLink('permission::show',array(
										'id'=>$oPermission->getId()
									) 
							)?>">Show</a>

				
				
			</td>
		</tr>	
		<?php endforeach;?>
	<?php else:?>
		<tr>
			<td colspan="4">Aucune ligne</td>
		</tr>
	<?php endif;?>
</table>

<p><a class="btn btn-primary" href="<?php echo $this->getLink('permission::new') ?>">New</a></p>

