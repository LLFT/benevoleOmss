<table class="table table-striped">
    <tr>
        <th>Label du parcours  </th>
        <th>Evènement associé </th>
    </tr>
	<?php if($this->oParcours):?>
		<?php foreach($this->oParcours as $oParcours):?>
		<tr <?php echo plugin_tpl::alternate(array('','class="alt"'))?>>
			
		<td><a  href="<?php echo $this->getLink('parcours::show',array(
										'id'=>$oParcours->idParcours,'idEvent'=>$oParcours->event_id
									) 
                        )?>"><?php echo $oParcours->label ?></a></td>

		<td><?php echo $this->tJoinmodelEvents[$oParcours->event_id] ?></td>
		</tr>
                

		<?php endforeach;?>
	<?php else:?>
		<tr>
			<td colspan="3">Aucune ligne</td>
		</tr>
	<?php endif;?>
</table>


