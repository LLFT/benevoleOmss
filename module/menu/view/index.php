<script>
function openMenu(id){
	var a=getById('cat'+id);
	if(a){
		if(a.style.display==='none'){
			a.style.display='block';
		}else{
			a.style.display='none';
		}
	}
}
</script>
<div class="navbar navbar-inverse navbar-fixed-top" role="navigation">
	<div class="container-fluid">
		<div class="navbar-header">
			<button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#bs-navbar-collapse-1">
			<span class="sr-only">Toggle navigation</span>
			<span class="icon-bar"></span>
			<span class="icon-bar"></span>
			<span class="icon-bar"></span>
			</button>
                    <a class="navbar-brand" href="<?php echo $this->getLink($this->tLink2['Accueil']) ?>">benevoleOmss</a>
		</div>
            
		<div class="collapse navbar-collapse" id="bs-navbar-collapse-1">

			<ul class="nav navbar-nav">
                        <?php $i=0;?>
			<?php foreach($this->tLink as $sLibelle => $sLink): ?>
                            <?php if(is_array($sLink)):?>
                                <li class="dropdown">                                    
                                    <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false"><?php echo $sLibelle?><span class="caret"></span></a>
                                <ul class="dropdown-menu">
                                    <?php foreach($sLink as $sLibelle2 => $uLink):?>
					<?php if(_root::getParamNav()==$uLink):?>
						<li class="active"><a href="<?php echo $this->getLink($uLink) ?>"><?php echo $sLibelle2 ?></a></li>
					<?php else:?>
						<li><a href="<?php echo $this->getLink($uLink) ?>"><?php echo $sLibelle2 ?></a></li>
					<?php endif;?>
                                    <?php endforeach;?>
                                </ul>
                                </li>
                                <?php $i++;?>
                            <?php else:?>
				<?php if(_root::getParamNav()==$sLink):?>
					<li class="active"><a href="<?php echo $this->getLink($sLink) ?>"><?php echo $sLibelle ?><span class="sr-only">(current)</span></a></li>
				<?php else:?>
					<li><a href="<?php echo $this->getLink($sLink) ?>"><?php echo $sLibelle ?></a></li>
				<?php endif;?>
                            <?php endif;?>
			<?php endforeach;?>
                            <li><a href="<?php echo $this->getLink($this->tLink2['Deconnexion']) ?>">Deconnexion</a></li>
			</ul>
                    
                     
				
		</div><!--/.nav-collapse -->
	</div>
</div>
