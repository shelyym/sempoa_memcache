<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Action
 * Action Class mendapat isi string object/methods
 *
 * @author ElroyHardoyo
 */
class Action {
    public static function getLink ($obj, $webClass)
    {
        if ($obj instanceof Model) {
            $classname = get_class($obj);
            $t = time();
            $main_id = $obj->main_id;
            ?>
            <span id="<?= $classname; ?>_<?= $obj->{$main_id}; ?><?= $t; ?>"><?= $obj->getName(); ?></span>
            <script type="text/javascript">
                $("#<?=$classname;?>_<?=$obj->{$main_id};?><?=$t;?>").click(function () {
                    openLw('<?=$webClass;?>View_<?=$obj->{$main_id};?>', '<?=_SPPATH;?><?=$webClass;?>/<?=$classname;?>?cmd=edit&id=<?=$obj->{$main_id};?>&parent_page=' + window.selected_page, 'fade');
                });
            </script>
        <?
        }
    }
}
