<?php
namespace Leap\View;
    /*
     * To change this license header, choose License Headers in Project Properties.
     * To change this template file, choose Tools | Templates
     * and open the template in the editor.
     */

/**
 * Description of InputSelect
 *
 * @author User
 */
class InputSelectOnChange extends InputSelect
{
    public $options = array();
    public $selected;
    public $id_yangdiganti;
    public $webservice;

    public function __construct($arr, $id, $name, $selected, $id_yangdiganti, $webservice, $classname = 'form-control')
    {
        $this->options = $arr;
        $this->id = $id;
        $this->name = $name;
        $this->selected = $selected;
        $this->classname = $classname;
        $this->id_yangdiganti = $id_yangdiganti;
        $this->webservice = $webservice;
    }

    public function p()
    {
        ?>
        <select class='<?= $this->classname; ?>' name="<?= $this->name; ?>"
                id="<?= $this->id; ?>" <?= $this->readonly; ?>>
            <? foreach ($this->options as $val => $text) {
                if ($this->selected == $val) {
                    $selected = "selected";
                } else {
                    $selected = "";
                }
                ?>
                <option value="<?= $val; ?>" <?= $selected; ?>><?= stripslashes($text); ?></option>
            <? } ?>
        </select>
        <script>
            $('#<?= $this->id; ?>').change(function () {
                var slc = $('#<?= $this->id; ?>').val();
//                alert(slc);
                $('#<?=$this->id_yangdiganti;?>').load("<?=$this->webservice;?>?id=" + slc);
            });
        </script>
        <?
    }
}
