<h1>Ini mobile version</h1>
<table>
    <thead>
    <tr>
        <th>
            <?= Lang::t('month'); ?>
        </th>
        <th>
            <?= Lang::t('event'); ?>
        </th>
    </tr>
    </thead>
    <tbody>
    <? foreach ($bulanan as $n => $bln) {
        ?>
        <tr>
            <td>
                <?= $n; ?>
            </td>
            <td>
                <?
                foreach ($bln as $hari) {
                    if (isset($hari['activities'])) {
                        foreach ($hari['activities'] as $act) {
                            echo $act->cal_name;
                        }
                    }
                }
                ?>
            </td>
        </tr>
    <? } ?>
    </tbody>
</table>


<?php
pr($bulanan);

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

