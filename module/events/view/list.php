<table class="table table-striped">
	<tr>
		
		<th>Nom de l'évènement</th>

		<th>Date</th>

		<th>Lieux</th>
	</tr>
	<?php if($this->oEvents):?>
		<?php foreach($this->oEvents as $oEvent):?>
		<tr <?php echo plugin_tpl::alternate(array('','class="alt"'))?>>
			
		<td><a class="" href="<?php echo $this->getLink('events::show',array(
										'id'=>$oEvent->getId()
									) 
							)?>"><?php echo $oEvent->nomEvent ?></a></td>

		<td><?php echo $oEvent->date ?></td>

		<td><?php echo $oEvent->lieux ?></td>

		</tr>	
		<?php endforeach;?>
	<?php else:?>
		<tr>
			<td colspan="5">Aucune ligne</td>
		</tr>
	<?php endif;?>
</table>

<p><a class="btn btn-primary" href="<?php echo $this->getLink('events::new') ?>">Ajouter un évènement</a></p>
