<?php 

    $sThead="";
    $sTbody="";
    $Selected=False;
    foreach($this->tJoinmodel_groupe as $keyGroupe => $sGroupe){
            $sThead .= '<th>'.$sGroupe.'</th>';        
    } 

    foreach($this->oPermissionDistinct as $uRows => $sRow){
        $sTbody.='<tr><form   action="'.$this->getLink('permission::editPermission').'" method="POST" ><th>'.$sRow->element.'</th>';       
        foreach($this->tJoinmodel_groupe as $uIdGroupe => $sGroupe){
            foreach ($this->oPermission as $key => $sPermission) {
                if(($sPermission->element != $sRow->element )||($sPermission->groupe_id != $uIdGroupe )){continue;}                
                $Selected='selected';
            }
            
            
            $sTbody.='<td><SELECT name="'.$uIdGroupe.'_'.$sRow->element.'" ';
            if($Selected){
                $sTbody.='class="list1" >';
            }else{
                $sTbody.=' class="list2" >';
            }
            $sTbody.='<OPTION class="option1">DENY
                      <OPTION class="option2"  ';
            
            $sTbody.=$Selected.'>ALLOW</SELECT></td>';
            $Selected=False;
        }
        $sTbody.='<td><noscript><button value="Modifier">Modifier les Permissions</button></noscript></td></form></tr>';
    }
?>
        
        
<form  class="form-horizontal" action="<?php echo $this->getLink('permission::addElement'); ?>" method="POST" >
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
<table class="table" id="tablePerm">
    
        <thead><tr><th>Modules</th><?php echo $sThead ; ?></tr></thead>
            <tbody>
                <?php echo $sTbody ; ?>
            </tbody>
            <tfoot><tr></tr></tfoot>    
    
</table>


<script language="Javascript">
    window.onload = function(){  
        console.log( "ready!" );
        $( "#tablePerm select" )
          .change(function (e) {
            var colorR = "#FF4000";
            var colorG = "#64FE2E";
              console.log( "change ! "+this.value );
            if(this.value === "ALLOW"){
              $(this).css('background-color',colorG);
            }else{
              $(this).css('background-color',colorR);
            }
            this.form.submit();  
        });
    };   
</script>