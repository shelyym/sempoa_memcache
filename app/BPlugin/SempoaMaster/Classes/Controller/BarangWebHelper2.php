<?php

/**
 * Created by PhpStorm.
 * User: efindiongso
 * Date: 8/10/17
 * Time: 1:06 PM
 */
class BarangWebHelper2 extends WebService
{

    public function getLevel()
    {
        $id =  isset($_GET['id']) ? addslashes($_GET['id']) : 0;
        $arrResLevel = array();
        if ($id == 0) {
            $arrResLevel = Generic::getAllLevel();

            foreach ($arrResLevel as $key=>$val) {
                ?>

                <option value="<?= $key; ?>"><?= $val; ?></option>
                <?
            }
        } else {
            $arrResLevel = Generic::getLevelKurikulumLama();
            foreach ($arrResLevel as $key=>$val) {
                ?>

                <option value="<?= $key; ?>"><?= $val; ?></option>
                <?
            }

        }
    }


}