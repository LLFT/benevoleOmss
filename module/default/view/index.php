<?php if(_root::getAuth() and _root::getAuth()->getAccount()) :?>
<p> Connecté en tant que : <?php echo _root::getAuth()->getAccount()->login; ?> </p>
<?php endif; ?>

vue index
