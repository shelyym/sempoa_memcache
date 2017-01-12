<?php
/**
 * Created by PhpStorm.
 * User: efindiongso
 * Date: 11/21/16
 * Time: 1:18 PM
 */

namespace Leap\View;


class InputTextPattern extends Html
{

    public $type;
    public $pattern;

    public function __construct($type, $id, $name, $value, $pattern = "", $classname = 'form-control')
    {
        $this->id = $id;
        $this->name = $name;
        $this->type = $type;
        $this->classname = $classname;
        $this->value = stripslashes($value);
        $this->pattern = $pattern;
    }

    public function p()
    {
        $sem = $this->type;
        $idku = $this->id;
        if ($this->type == "date") {
            $sem = "text";
            if ($this->value != "") {
                $this->value = date("d-m-Y", strtotime($this->value));
            }
            $idku = $idku . time();
        }
        if ($this->pattern == "") {
            ?>
            <input type="<?= $sem; ?>" name="<?= $this->name; ?>" value="<?= $this->value; ?>" id="<?= $idku; ?>"
                   class="<?= $this->classname; ?>" <?= $this->readonly; ?> >
            <?
        } else {
            ?>
            <input type="<?= $sem; ?>" name="<?= $this->name; ?>" value="<?= $this->value; ?>" id="<?= $idku; ?>"
                   class="<?= $this->classname; ?>" <?= $this->readonly; ?> pattern="<?= $this->pattern; ?>">
            <?
        }

//        echo "<input type='{$sem}' name='{$this->name}' value='".str_replace("'","\'",$this->value)."' id='{$idku}' class='{$this->classname}' {$this->readonly}>";

        if ($this->type == "date") {
            echo '
<script>
     $( "#' . $idku . '" ).datepicker({ dateFormat: \'dd-mm-yy\' });
</script>';

        }
    }
}
