<table class="table table-striped">
	<tr>
		
		<th>Label</th>
	</tr>
	<?php if($this->tParcours):?>
		<?php foreach($this->tParcours as $oParcours):?>
		<tr <?php echo plugin_tpl::alternate(array('','class="alt"'))?>>
                    <td>
                        <a class="btn btn-primary btn-xs" href="<?php echo $this->getLink('parcours::show',array( 'id'=>$oParcours->getId()))?>"><?php echo $oParcours->label ?></a>
                    </td>
		</tr>	
		<?php endforeach;?>
	<?php else:?>
		<tr>
			<td colspan="13">Aucune ligne</td>
		</tr>
	<?php endif;?>
</table>

<p><a class="btn btn-success" href="<?php echo $this->getLink('parcours::new') ?>">Ajouter parcours</a></p>