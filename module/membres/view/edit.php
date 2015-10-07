<?php 
$oForm=new plugin_form($this->oMembres);
$oForm->setMessage($this->tMessage);
?>


<form class="form-horizontal" action="" method="POST" >

    <fieldset>
        <legend>Contact</legend>
        <p style="font-size:10px" class="col-sm-offset-1"> <i>* Champs obligatoires</i></p>

	<div class="form-group">
		<label class="col-sm-2 control-label">Nom *</label>
		<div class="col-sm-4"><?php echo $oForm->getInputText('nom',array('class'=>'form-control','maxlength'=>"40"))?></div>
		<label class="col-sm-2 control-label">Prénom *</label>
		<div class="col-sm-4"><?php echo $oForm->getInputText('prenom',array('class'=>'form-control','maxlength'=>"40"))?></div>
	</div>
        
        <div class="form-group">
                <label class="col-sm-3 control-label">Possède-t-il une adresse Mail ? : </label>
                <div class="col-sm-1"><?php echo $oForm->getInputCheckbox('chkMail',1, array('class'=>'form-control'))?></div>
                <label class="col-sm-2 control-label">Adresse Mail *</label>
                <?php $sParamMail=array('class'=>'form-control','maxlength'=>"40");
                    if ($this->oMembres->chkMail!=1){$sParamMail['disabled']='';}
                ?>                
		<div class="col-sm-6"><?php echo $oForm->getInputText('mail',$sParamMail)?></div>
        </div>

	
        
	<div class="form-group">
		<label class="col-sm-2 control-label">Téléphone Fixe **</label>
		<div class="col-sm-4"><?php echo $oForm->getInputText('fixe',array('class'=>'form-control','maxlength'=>"20"))?></div>
		<label class="col-sm-2 control-label">Téléphone GSM ** </label>
		<div class="col-sm-4"><?php echo $oForm->getInputText('gsm',array('class'=>'form-control','maxlength'=>"20"))?></div>
	</div>
        <p style="font-size:10px" class="col-sm-offset-1"> <i>** Au moins l'un des 2 champs obligatoires</i></p>
        
        <div class="form-group">
		<label class="col-sm-2 control-label">Année de Naissance</label>
		<div class="col-sm-1"><?php echo $oForm->getInputText('anneeNaissance',array('class'=>'form-control','maxlength'=>"4", 'placeholder'=>"1900"))?></div>
	</div>
    </fieldset>
    
    <fieldset>
        <legend>Adresse Postale</legend>

	<div class="form-group">
		<label class="col-sm-2 control-label">Numéro de Rue</label>
		<div class="col-sm-1"><?php echo $oForm->getInputText('numero',array('class'=>'form-control','maxlength'=>"4"))?></div>
		<label class="col-sm-2 control-label">Nom de Rue *</label>
		<div class="col-sm-7"><?php echo $oForm->getInputText('rue',array('class'=>'form-control','maxlength'=>"40",'placeholder'=>"Rue, Boulevard, Place, Chemin, Allée,..."))?></div>
	</div>

	<div class="form-group">
		<label class="col-sm-2 control-label">Complément d'adresse</label>
		<div class="col-sm-10"><?php echo $oForm->getInputText('complement',array('class'=>'form-control','maxlength'=>"40", 'placeholder'=>"Lieu-Dit, Lotissement, Bis, A, B, C,..."))?></div>
	</div>

	<div class="form-group">
		<label class="col-sm-2 control-label">Ville *</label>
		<div class="col-sm-4"><?php echo $oForm->getInputText('ville',array('class'=>'form-control','maxlength'=>"40"))?></div>
		<label class="col-sm-2 control-label">Code Postal *</label>
		<div class="col-sm-4"><?php echo $oForm->getInputText('codePostal',array('class'=>'form-control','maxlength'=>"6"))?></div>
	</div>
    </fieldset>

    <fieldset>
        <legend>Informations Complémentaires</legend>
        <div class="form-group">
            <label class="col-sm-3 control-label">Coordonnées validées ? : </label>
                <div class="col-sm-2"><?php echo $oForm->getInputCheckbox('chkFormulaire',1, array('class'=>'form-control'))?></div>
            <label class="col-sm-3 control-label">Souhaite-t-il être signaleur ? : </label>
                <div class="col-sm-2"><?php echo $oForm->getInputCheckbox('chkSignaleur',1, array('class'=>'form-control'))?></div>
        
        </div>

	<div class="form-group">
		<label class="col-sm-2 control-label">Club / Association </label>
		<div class="col-sm-10"><?php echo $oForm->getInputText('club',array('class'=>'form-control','maxlength'=>"40"))?></div>
	</div>
        
        <div class="form-group">
                <label class="col-sm-2 control-label">Possède le Permis ? : </label>
                <div class="col-sm-1"><?php echo $oForm->getInputCheckbox('chkPermis',1, array('class'=>'form-control'))?></div>                    
        </div>
            
	<div class="form-group">
		<label class="col-sm-2 control-label">Numéros de Permis : </label>
                <?php $sParamNumPermis=array('class'=>'form-control','maxlength'=>"20");
                    if ($this->oMembres->chkPermis!=1){$sParamNumPermis['disabled']='';}
                ?> 
		<div class="col-sm-10"><?php echo $oForm->getInputText('numPermis',$sParamNumPermis)?></div>
	</div>
        
        <div class="form-group">
		<label class="col-sm-2 control-label">Commentaire : </label>
		<div class="col-sm-10"><?php echo $oForm->getInputTextarea('comment',array('class'=>'form-control'))?></div>
	</div>
    
            
        
    </fieldset>
    
<?php echo $oForm->getToken('token',$this->token)?>
    
<script language="Javascript">
function happycode(){
    $.fn.bootstrapSwitch.defaults.onText = "Oui";
    $.fn.bootstrapSwitch.defaults.offText = "Non";
    $.fn.bootstrapSwitch.defaults.onColor = "success";
    $.fn.bootstrapSwitch.defaults.offColor = "danger";
   $('input[name="chkPermis"]').bootstrapSwitch();
   $('input[name="chkMail"]').bootstrapSwitch();
   $('input[name="chkFormulaire"]').bootstrapSwitch();
   $('input[name="chkSignaleur"]').bootstrapSwitch();
   
   $('input[name="chkMail"]').on('switchChange.bootstrapSwitch', function(event, state) {
       // console.log(this); // DOM element
       // console.log(event); // jQuery event
       activerMail(state);
   });

   $('input[name="chkPermis"]').on('switchChange.bootstrapSwitch', function(event, state) {
       activerNumPermis(state);
   });
   
   
   
   
}

function activerMail(state) {
    if (state){
        $('input[name="mail"]').prop('disabled', false);
     //   console.log(state); // true | false
    }else{
        $('input[name="mail"]').prop('disabled', true); 
    }
 }

function activerNumPermis(state) {
    if (state){
        $('input[name="numPermis"]').prop('disabled', false);
    }else{
        $('input[name="numPermis"]').prop('disabled', true); 
    }
}
window.onload=happycode ; 
</script>

<div class="col-sm-offset-1 btn-group" role="group">
		<input type="submit" class="btn btn-success" value="Modifier" /> 
                <a class="btn btn-default" href="<?php echo $this->getLink('membres::show',array('id'=>$this->oMembres->idMembre))?>">Annuler</a>
                <a class="btn btn-danger" href="<?php echo $this->getLink('membres::delete',array('id'=>$this->oMembres->idMembre))?>">Supprimer</a>

</div>
    
    
</form>
