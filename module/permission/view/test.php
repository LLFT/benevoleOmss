<table border='1'>
<tr><th>Modules</th>    
    <?php foreach($this->tJoinmodel_groupe as $keyGroupe => $sGroupe):?>
        <th><?php echo $sGroupe; ?></th>        
    <?php endforeach; ?>
</tr>    
    
    
<?php foreach($this->tPermissionDistinct as $sRows => $sRow):?>   
    <tr><th scope="row">  <?php echo $sRow->element; ?></th>
<?php endforeach; ?>
        
        
</tr>
</table>
<form>
<select name="permissions" id="permissions">
<?php foreach($this->tModule as $key => $oModule):?>
    <optgroup label="<?php echo $key; ?>">
        <?php foreach($oModule as $sModule):?>
            <option value="<?php echo $sModule; ?>"><?php echo $sModule; ?></option>
        <?php endforeach; ?>
    </optgroup>
<?php endforeach; ?>
</select>
    <button value="Ajouter">Ajouter</button>
</form>



