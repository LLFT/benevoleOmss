<?php if(_root::getAuth() and _root::getAuth()->getAccount()) :?>
<p> Connecté en tant que : <?php echo _root::getAuth()->getAccount()->login; ?> </p>
<?php endif; ?>

<noscript>
<h1>Bienvenue sur cet outil ! Pour continuer il vous faudra activer la prise en charge du contenu Javascript</h1>
</noscript>
