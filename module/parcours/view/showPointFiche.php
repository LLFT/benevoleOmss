

<form  class="form-horizontal" action="" method="POST"  enctype="multipart/form-data">
    <input type="hidden" name="PointID" value="<?php echo $this->oPoints->idPoint; ?>">
    <input type="hidden" name="ParcoursID" value="<?php echo $this->oPoints->parcours_id; ?>">
    <table class="form-group">
        <thead>
            <tr><td> Label du point : <input name="Label" type="text" value="<?php echo $this->oPoints->name; ?>" ></td></tr>
            <tr><th>Signaleur(s) affecté(s) sur ce point : </th><th>Affecté</th></tr>
        </thead>
    <tbody>
        
        
       <?php foreach ($this->tMembres  as $membre) :?>
        <tr>
            <td><?php echo $membre['nom'].' '. $membre['prenom'].'('.$membre['idMembre'].')'; ?></td>
            <td>
                <input type="hidden" name="chk_<?php echo $membre['idMembre']; ?>" value="0" checked="">
                <input type="checkbox" name="chk_<?php echo $membre['idMembre']; ?>" value="1" checked="">
            </td>
        </tr> 

       <?php endforeach; ?>
    </tbody>
    <tfoot>
        <tr><td><label>Affecter sur ce point un nouveau Signaleur : </label></td></tr>
        <tr><td>
                <input type="text" name="AjoutMembre" list="dataMembres">
                <datalist id="dataMembres">
                    <?php foreach ($this->tFreeMembres  as $FreeMembre) :?>
                    <option value="<?php echo $FreeMembre['idMembre']; ?>"><?php echo $FreeMembre['nom'].' '.$FreeMembre['prenom']; ?></option>
                    <?php endforeach; ?>
                </datalist>
            </td>
            <td><input type="submit" value="Valider" > </td>
        </tr>
    </tfoot>
        
    </table>
</form>