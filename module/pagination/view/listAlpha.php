<div class="pagination">
    <ul class="list-inline">
    <?php foreach($this->tDistinctLetters as $sLetter):?>
        <?php $tParam=$this->tParam ?>
	<?php $tParam[$this->sParamPage]=$sLetter?>
        <li >
    
        <a  <?php if($sLetter==$this->sCurrentLetter):?>class="btn btn-info btn-xs"<?php else:?>class="btn btn-default btn-xs"<?php endif;?> href="<?php echo _root::getLink($this->sModuleAction,$tParam) ?>"><?php echo $sLetter ?></a>
          
            
        </li>

    
    <?php endforeach;?>
    </ul>
</div>