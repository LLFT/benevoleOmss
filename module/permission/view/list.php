<?php 

    $sThead="";
    $sTbody="";
    foreach($this->tJoinmodel_groupe as $keyGroupe => $sGroupe){
            $sThead .= '<th>'.$sGroupe.'</th>';        
    } 

    foreach($this->oPermissionDistinct as $uRows => $sRow){
        $sTbody.='<tr><th>'.$sRow->element.'</th>';       
        foreach($this->tJoinmodel_groupe as $uIdGroupe => $sGroupe){
            $sTbody.='<td><SELECT name="'.$uIdGroupe.'_'.$sRow->element.'">
<OPTION>DENY
<OPTION ';
            foreach ($this->oPermission as $key => $sPermission) {
                if(($sPermission->element != $sRow->element )||($sPermission->groupe_id != $uIdGroupe )){continue;}                
                $sTbody.='selected';
            }
            $sTbody.='>ALLOW</SELECT></td>';    
        }
        $sTbody.='</tr>';
    }
?>
        
        
<form  class="form-horizontal" action="" method="POST" >
<select name="permissions" id="permissions">
<?php foreach($this->tModule as $key => $oModule):?>
    <optgroup label="<?php echo $key; ?>">
        <?php foreach($oModule as $sModule):?>
            <?php if (in_array($sModule, $this->tPermissionDistinct)){continue;} ?>
            <option value="<?php echo $sModule; ?>"><?php echo $sModule; ?></option>
        <?php endforeach; ?>
    </optgroup>
<?php endforeach; ?>
</select>
    <button value="Ajouter">Ajouter</button>
</form>
<table class="table">
    <thead><tr><th>Modules</th><?php echo $sThead ; ?></tr></thead>
    <tbody>
        <?php echo $sTbody ; ?>
    </tbody>
    <tfoot></tfoot>    
</table>


<script language="Javascript">
    window.onload = function(){  
        console.log( "ready!" );
        $( "select" )
          .change(function (e) {
              console.log( "change ! "+this.name+' '+this.value ); 
        });
    };   
</script>