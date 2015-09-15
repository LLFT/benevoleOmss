<?php 
$oForm=new plugin_form($this->oMembres);
$oForm->setMessage($this->tMessage);
?>
<form class="form-horizontal" action="" method="POST" >

    <fieldset>
        <legend>Contact</legend>
        <p style="font-size:10px" class="col-sm-offset-1"> <i>* Champs obligatoires</i></p>

	<div class="form-group">
		
                <label control-label">Nom *</label>
		<?php echo $oForm->getInputText('nom',array('class'=>'form-control','maxlength'=>"40"))?>
		<label control-label">Prénom *</label>
		<?php echo $oForm->getInputText('prenom',array('class'=>'form-control','maxlength'=>"40"))?>
                
	</div>
        
        <div class="form-group">
                <label class=" control-label">Possède une adresse Mail ? : </label>
                <?php echo $oForm->getInputCheckbox('chkMail',1, array('class'=>'form-control'))?>                  
        </div>
	
        <div class="form-group">
		<label class=" control-label">Adresse Mail *</label>
                <?php $sParamMail=array('class'=>'form-control','maxlength'=>"40");
                    if ($this->oMembres->chkMail!=1){$sParamMail['disabled']='';}
                ?>                
		<?php echo $oForm->getInputText('mail',$sParamMail)?>
	</div>

	<div class="form-group">
		<label class=" control-label">Téléphone Fixe **</label>
		<?php echo $oForm->getInputText('fixe',array('class'=>'form-control','maxlength'=>"20"))?>
		<label class=" control-label">Téléphone GSM ** </label>
		<?php echo $oForm->getInputText('gsm',array('class'=>'form-control','maxlength'=>"20"))?>
	</div>
        <p style="font-size:10px" class="col-sm-offset-1"> <i>** Au moins l'un des 2 champs obligatoires</i></p>
        
        <div class="form-group">
		<label class=" control-label">Année de Naissance</label>
		<?php echo $oForm->getInputText('anneeNaissance',array('class'=>'form-control','maxlength'=>"4", 'placeholder'=>"1900"))?>
	</div>
    </fieldset>
    
    <fieldset>
        <legend>Adresse Postale</legend>

	<div class="form-group">
		<label class=" control-label">Numéro de Rue</label>
		<?php echo $oForm->getInputText('numero',array('class'=>'form-control','maxlength'=>"4"))?>
		<label class=" control-label">Nom de Rue *</label>
		<?php echo $oForm->getInputText('rue',array('class'=>'form-control','maxlength'=>"40",'placeholder'=>"Rue, Boulevard, Place, Chemin, Allée,..."))?>
	</div>

	<div class="form-group">
		<label class=" control-label">Complément d'adresse</label>
		<?php echo $oForm->getInputText('complement',array('class'=>'form-control','maxlength'=>"40", 'placeholder'=>"Lieu-Dit, Lotissement, Bis, A, B, C,..."))?>
	</div>

	<div class="form-group">
		<label class=" control-label">Ville *</label>
		<?php echo $oForm->getInputText('ville',array('class'=>'form-control','maxlength'=>"40"))?>
		<label class=" control-label">Code Postal *</label>
		<?php echo $oForm->getInputText('codePostal',array('class'=>'form-control','maxlength'=>"6"))?>
	</div>
    </fieldset>

    <fieldset>
        <legend>Informations Complémentaires</legend>

	<div class="form-group">
		<label class=" control-label">Club / Association </label>
		<?php echo $oForm->getInputText('club',array('class'=>'form-control','maxlength'=>"40"))?>
	</div>
        
        <div class="form-group">
                <label class=" control-label">Possède le Permis ? : </label>
                <?php echo $oForm->getInputCheckbox('chkPermis',1, array('class'=>'form-control'))?>                   
        </div>
            
	<div class="form-group">
		<label class=" control-label">Numéros de Permis</label>
                <?php $sParamNumPermis=array('class'=>'form-control','maxlength'=>"20");
                    if ($this->oMembres->chkPermis!=1){$sParamNumPermis['disabled']='';}
                ?> 
		<?php echo $oForm->getInputText('numPermis',$sParamNumPermis)?>
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

<div class="form-group">
    <div class="col-sm-offset-2 ">
		<input type="submit" class="btn btn-success" value="Modifier" /> <a class="btn btn-link" href="<?php echo $this->getLink('membres::show',array('id'=>$this->oMembres->idMembre))?>">Annuler</a>
	</div>
    <div class="col-sm-offset-7 col-sm-1">
                    <a class="btn btn-danger" href="<?php echo $this->getLink('membres::delete',array('id'=>$this->oMembres->idMembre))?>">Supprimer</a>
    </div>
</div>
    
    
</form>
