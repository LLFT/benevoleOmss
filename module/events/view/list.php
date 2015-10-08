<table class="table table-striped">
	<tr>
		
		<th>Nom de l'évènement</th>

		<th>Date</th>

		<th>Lieux</th>
	</tr>
	<?php if($this->oEvents):?>
		<?php foreach($this->oEvents as $oEvent):?>
		<tr <?php echo plugin_tpl::alternate(array('','class="alt "'))?>>
			
		<td><?php if ($oEvent->active != 1) :?><s> <?php endif; ?><a class="" href="<?php echo $this->getLink('events::show',array(
										'id'=>$oEvent->getId()
									) 
							)?>"><?php echo $oEvent->nomEvent ?></a><?php if ($oEvent->active != 1) :?></s> <?php endif; ?></td>

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

<p>
    <?php if ( _root::getACL()->can('ACCESS','membres::new')):?>
        <a class="btn btn-primary" href="<?php echo $this->getLink('events::new') ?>">Ajouter un nouvel évènement</a>
    <?php endif;?>
<?php if (_root::getParam('action')=='archiv'):?>
<a class="btn btn-info" href="<?php echo $this->getLink('events::list') ?>">Afficher les évènements</a></p>
<?php else :?>
<a class="btn btn-warning" href="<?php echo $this->getLink('events::list',array('action'=>'archiv')) ?>">Afficher les évènements archivés</a></p>
<?php endif;?>