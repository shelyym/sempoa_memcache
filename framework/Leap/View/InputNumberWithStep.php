<?php
/**
 * Created by PhpStorm.
 * User: efindiongso
 * Date: 1/6/17
 * Time: 5:21 AM
 */

namespace Leap\View;


class InputNumberWithStep extends Html {

    public $type;

    public $step;

    public function __construct ($type, $step, $id, $name, $value, $classname = 'form-control')
    {
        $this->id = $id;
        $this->name = $name;
        $this->type = $type;
        $this->classname = $classname;
        $this->value = stripslashes($value);
        $this->step = $step;
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

        $step = $this->step;
        ?>
        <input type="<?=$sem;?>" step="<?=$step;?>" name="<?=$this->name;?>" value="<?=$this->value;?>" id="<?=$idku;?>" class="<?=$this->classname;?>" <?=$this->readonly;?> >
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