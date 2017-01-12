<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace Leap\View;

/**
 * Description of InputTextWithMaxLength
 *
 * @author efindiongso
 */
class InputTextWithMaxLength extends Html {

    public $type;
    public $maxlength;

    public function __construct ($type, $id, $name, $value, $maxlength='10000000', $classname = 'form-control')
    {
        $this->id = $id;
        $this->name = $name;
        $this->type = $type;
        $this->classname = $classname;
        $this->value = stripslashes($value);
        $this->maxlength = $maxlength;
//        $this->constraints = $constraint;
    }

    public function p ()
    {
        $sem = $this->type;
        $idku = $this->id;
        if($this->type == "date"){
            $sem = "text";
            if($this->value != ""){
                $this->value =date("d-m-Y", strtotime($this->value));
            }
            $idku = $idku.time();
        }

        ?>
        <input type="<?=$sem;?>" name="<?=$this->name;?>" value="<?=$this->value;?>" id="<?=$idku;?>" class="<?=$this->classname;?>" data-minlength="<?=$this->maxlength;?>" maxlength="<?=$this->maxlength;?>" <?=$this->readonly;?> >
        <?
//        echo "<input type='{$sem}' name='{$this->name}' value='".str_replace("'","\'",$this->value)."' id='{$idku}' class='{$this->classname}' {$this->readonly}>";
        
        if($this->type == "date"){
echo '
<script>
     $( "#'.$idku.'" ).datepicker({ dateFormat: \'dd-mm-yy\' });    
</script>';
             
        }
    }
}
