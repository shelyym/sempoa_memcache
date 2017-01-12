<?php
/**
 * Created by PhpStorm.
 * User: elroy
 * Date: 11/24/15
 * Time: 1:11 PM
 */

class SearchAdminMenu extends WebService{

    function search(){
        $q = addslashes($_GET['q']);

        ?>
        <div class="row">
            <div class="col-md-12">
        <h1>Search Results for "<?=$q;?>"</h1>
        <?
        $allowed = Registor::getAllAdminMenuByRoles(Account::getMyRoles());
//        pr($allowed);
        $allows = array();

        foreach($allowed as $alls){
            foreach($alls as $key=>$c){
                $allows[] = $key;
            }
        }
//        echo $q;
//        pr(Registor::getAllAdminMenuFromSession());

        $allAdmin = Registor::getAllAdminMenuSearch();
//        pr($allAdmin);

        foreach($allAdmin as $all){
            foreach($all as $key=>$value){
                $save[$key]= $value;

            }
        }


        $stored = $save;


        foreach($stored as $key=>$store) {
            if (stripos($store,$q) !== false) {
//                echo "Key: " . $key . "<br />Found: " . $q . "<br />";

                $keys[] = $key;
            }

        }


        $regs = Registor::getAllAdminMenu();
//        pr($regs);
        $cnt = 0;
        foreach($regs as $domain=>$arre){
            foreach($arre as $key=>$re){
                if(in_array($key,$keys)) {
                    if(in_array($key,$allows)) {
                        $cnt++;
                        ?>
                        <div class="menuicon" style="background: white; padding: 10px; margin: 10px; margin-left: 0px;">
                            <h3 style="margin: 0; padding: 0; margin-bottom: 10px;">
                                <a href="javascript:openLw('<?= $key; ?>','<?= _SPPATH . $re; ?>','fade');activkanMenuKiri('<?= $key; ?>');"><?= Lang::t($key); ?></a>
                            </h3>

                            <p>
                                <?= $save[$key]; ?>
                            </p>
                        </div>
                    <?
                    }
                }
            }
        }

        if($cnt<1){
            ?>
            <h3>
                <?=Lang::t('Cannot Find Any Matching Features');?>
            </h3>
            <?
        }
//        pr(Registor::getAllAdminMenuSearch());
        ?></div>
        </div><?
    }

    function array_isearch($str, $array) {
//        echo "in";
        $found = array();
        foreach($array as $k => $v)
            if(strtolower($v) == strtolower($str)) $found[] = $k;
        return $found;
    }




} 