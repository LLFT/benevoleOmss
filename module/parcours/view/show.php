<link rel="stylesheet" href="./css/parcours.css">
<div id="wrapper">

	<div class="">
		<div id="menuShow">
		<ul>
		
			<li><a href="#" onclick="clickShowVolon();"><span class="btnParcours icon32parcours icon32ShowBenev" title="Afficher/Masquer les Bénévoles"></span></a></li>                        
			<li><a href="#" onclick="clickShowParcours();"><span id="clickShowParcours" class="btnParcours icon32parcours icon32ShowParcours" title="Afficher/Masquer le Parcours"></span></a></li>
			<li><a href="#" onclick="clickShowRelais();"><span class="btnParcours icon32parcours icon32ShowRelais" title="Afficher/Masquer les Relais"></span></a></li>
			<li><a href="#" onclick="clickShowSignaleur();"><span class="btnParcours icon32parcours icon32ShowSignaleurs" title="Afficher/Masquer les Signaleurs"></span></a></li>
			<li><a href="#" onclick="clickShowPatrouilles();"><span class="btnParcours icon32parcours icon32ShowPatrouilles" title="Afficher/Masquer les Patrouilles"></span></a></li>
			<li><a href="#" onclick="clickShowAnimations();"><span class="btnParcours icon32parcours icon32ShowAnimations" title="Afficher/Masquer les Animations"></span></a></li>
			<li><a href="#" onclick="clickShowStands();"><span class="btnParcours icon32parcours icon32ShowStands" title="Afficher/Masquer les Stands"></span></a></li>
                        <li><a href="#" onclick="clickShowFreeVolon();"><span class="btnParcours icon32parcours icon32ShowBenevFree" title="Afficher/Masquer les Bénévoles non Volontaires"></span></a></li>
		</ul>
		</div>
	
		<div id="leftcolumn">
		
		<div id="menuAddPOI">
			<a href="#" onclick="clickAddRelais();" ><span  class="btnParcours icon32parcours icon32RelaisNew" title="Ajouter un Relais"></span></a>
			<a href="#" onclick="clickAddChasuble();" ><span  class="btnParcours icon32parcours icon32ChasubleNew" title="Ajouter un Signaleur"></span></a>
			<a href="#" onclick="clickAddPm();" ><span  class="btnParcours icon32parcours icon32PmNew" title="Ajouter une Patrouille Municipale"></span></a>
			<a href="#" onclick="clickAddAnim();" ><span  class="btnParcours icon32parcours icon32AnimNew" title="Ajouter une Animation"></span></a>				
			<a href="#" onclick="clickAddStand();" ><span  class="btnParcours icon32parcours icon32OmssNew" title="Ajouter un Stand OMSS"></span></a>				
		</div>
		<div id="menuDelPOI">
			<a href="#" onclick="clickRemoveRelais();" ><span  class="btnParcours icon32parcours icon32RelaisDel" title="Supprimer un Relais"></span></a>
			<a href="#" onclick="clickRemoveChasuble();" ><span  class="btnParcours icon32parcours icon32ChasubleDel" title="Supprimer un Signaleur"></span></a>
			<a href="#" onclick="clickRemovePm();" ><span  class="btnParcours icon32parcours icon32PmDel" title="Supprimer une Patrouille Municipale"></span></a>
			<a href="#" onclick="clickRemoveAnim();" ><span  class="btnParcours icon32parcours icon32AnimDel" title="Supprimer une Animation"></span></a>				
			<a href="#" onclick="clickRemoveStand();" ><span  class="btnParcours icon32parcours icon32OmssDel" title="Supprimer un Stand OMSS"></span></a>					
				
		</div>
		
		<div id="menuAddPoint">
		</div>
		<div id="menuDelPoint">
			<a href="#" onclick="editlines();" ><span  class="btnParcours icon32parcours icon32ShowPoint" title="Afficher/Masquer les Points"></span></a>
			<a href="#" onclick="clickAddLastPoint();" ><span  class="btnParcours icon32parcours icon32AddLastPoint" title="Ajouter un dernier Point"></span></a>			
			<a href="#" onclick="clickRemoveLastPoint();" ><span  class="btnParcours icon32parcours icon32DelLastPoint" title="Supprimer le dernier Point"></span></a>	
			<a href="#" onclick="clickAddBetPoint();" ><span  class="btnParcours icon32parcours icon32AddBetweenPoint" title="Ajouter un Point entre deux Points"></span></a>				
			<a href="#" onclick="clickRemoveBetPoint();" ><span  class="btnParcours icon32parcours icon32DelBetweenPoint" title="Supprimer un Point entre deux Points"></span></a>				
			<a href="#" onclick="" ><span  class="btnParcours icon32parcours icon32Save" title="Sauvegarder le Tracé"></span></a>				
			<a href="#" onclick="" ><span  class="btnParcours icon32parcours icon32Cancel" title="Annuler les changements"></span></a>				
		</div>			
		
		</div>
		<?php echo $this->oModuleGoogleMap->getGoogleMap();;?>	
		<div id="rightcolumn" style="display: none;">
			<div>
                            
			<u><b>Liste des Participants:</b></u>
                        <select size="20" name="benevole" id="ListName" disabled class="form-control" >
                            <?php foreach ($this->tMembresCoord as $item):?>
                                <option value="<?php echo $item['idMembre']; ?>"> <?php echo $item['nom'] .' '. $item['prenom'] ; ?> </option>
                            <?php endforeach; ?>
                        </select>
			</div>
			<div id="ActList">
				<ul>
					
                                        <li><a href="#" onclick="centerOnMarkerHome();"><span  class="btnAction16 menuAct icon16target " title="Localiser" ></span></a></li>
                                        <li><a href="#" onclick="centerOnMarkerChasuble();"><span  class="btnAction16 icon32parcours menuAct icon16Chasuble hide" title="Afficher Position" ></span></a></li>
				</ul>
			</div>
                        <div><div id="ActList">
				<p><u><b>Adresse :</b></u></p>
			</div> 
                            
                        <textarea id="AdresseTextArea" rows="3" cols="20"  readonly="true" disabled class="form-control">
				Enter your text here...
			</textarea>
                                               
			</div>
			<div>
			<u><b>Commentaire Associé :</b></u>
            <textarea id="CommentTextArea" rows="3" cols="20"  readonly="true" disabled class="form-control">
				Enter your text here...
			</textarea>
			</div>
        </div>

	</div>
</div>
<div class="col-sm-offset-1 btn-group">
        <a class="btn btn-info" href="<?php echo $this->getLink('events::show',array('id'=>_root::getParam('idEvent')))?>">Retour à l'évènement</a>
</div>

 
<script type="text/javascript" src="./js/jsParcours.js"></script>
