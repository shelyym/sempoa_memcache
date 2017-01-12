<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of SettingWeb
 *
 * @author User
 */
class ThemeModWeb extends WebService {

    public $arrActive = array("0"=>"inactive","1"=>"<b>active</b>");
    public function ThemeMod ()
    {
        //create the model object
        $cal = new ThemeMod();
        //send the webclass 
        $webClass = __CLASS__;

        //filter only for active theme
        $dir = ThemeItem::getTheme();
        $cal->read_filter_array = array("set_theme_id"=>$dir);
        
        //run the crud utility
        Crud::run($cal, $webClass);

        //pr($mps);
    }
    
    

    public function select(){
        
        $dir    = './themes';
        $files1 = scandir($dir);
        //pr($files1);
        $arrThemes = array();
        //ThemeItem::emptyAll();
        foreach($files1 as $tname){
            if(!strstr($tname,".")){
                if($tname != "adminlte"){
                    $themeItem = new ThemeItem();
                    $themeItem->theme_dir = $tname;
                    $themeItem->save();
                    $arrThemes[] = $tname;
                    
                }
            }
        }
        //get All
        $themeItem = new ThemeItem();
        $arrThemes2 = $themeItem->getAll();
        $t = time();
        
        //
        $adaPreview = 0;
        foreach($arrThemes2 as $theme){
            if(in_array($theme->theme_dir, $arrThemes)){
                if(ThemeItem::getPreviewTheme() == $theme->theme_id){
                    $adaPreview = 1;
                }               
                
            }
        }
        ?>
<table class="table">
    <thead>
    <tr>
        <th><?=Lang::t('Theme Name');?></th>
        <th><?=Lang::t('Status');?></th>
        <th><?=Lang::t('Preview');?></th>
        <th><?=Lang::t('Edit');?></th>
    </tr>
    
    </thead>
    <tbody>
        <?
        foreach($arrThemes2 as $theme){
            if(in_array($theme->theme_dir, $arrThemes)){
                if(ThemeItem::getPreviewTheme() == $theme->theme_id){
                    $preview = 1;
                }               
            else {$preview = 0;}
            ?>
        <tr>
            <td><?=$theme->theme_dir;?></td>
            <td>
                <? if(!$theme->theme_active){?>
                <select class="form-control" id="select_<?=$theme->theme_id;?>_<?=$t;?>">
                    <? foreach($this->arrActive as $num=>$h){?>
                    <option value="<?=$num;?>" <? if($theme->theme_active ==  $num)echo "selected";?>><?=$h;?></option>
                    <? } ?>
                </select>
                <? }else{
                echo $this->arrActive[$theme->theme_active];
                 } ?>
            </td>
            <td>
                <? if(!$theme->theme_active){?>
                <? if(!$preview){?>
                <button id="activatebutton_<?=$theme->theme_id;?>_<?=$t;?>" class="btn btn-default"><?=Lang::t('Edit Mode');?></button>
                <?}else{?>
                <button id="deactivatebutton_<?=$theme->theme_id;?>_<?=$t;?>" class="btn btn-default"><?=Lang::t('Remove Edit Mode');?></button>              
                <? }} ?>
            </td>
            <td>
              <?if($theme->theme_active){?>
                <? if(!$adaPreview){?>
                <button onclick="openLw('ThemeSetting','<?=_SPPATH;?>ThemeModWeb/ThemeMod?ti='+$.now(),'fade');" class="btn btn-default"><?=Lang::t('Edit Colors');?></button>
                <?} ?>
                <button onclick="if(confirm('<?=Lang::t('This will restore the themes to its initial state, all changes will be gone, are you sure?');?>'))$.get( '<?=_SPPATH;?>ThemeModWeb/restores?tdir=<?=$theme->theme_dir;?>&t='+$.now(),function(data){alert(data);});" class="btn btn-default"><?=Lang::t('Restore to Default');?></button>
              <?}?>
              <? if($preview){?>
                <button onclick="openLw('ThemeSetting','<?=_SPPATH;?>ThemeModWeb/ThemeMod?ti='+$.now(),'fade');" class="btn btn-default"><?=Lang::t('Edit Colors');?></button>            
              <?}?>
            </td>
        </tr>
    <script>
        $("#select_<?=$theme->theme_id;?>_<?=$t;?>").change(function(){
           var slc =  $("#select_<?=$theme->theme_id;?>_<?=$t;?>").val();
           $.get("<?=_SPPATH;?>ThemeModWeb/activate?id=<?=$theme->theme_id;?>&active="+slc,function(data){
                console.log(data);
                if(data.bool){
                    lwrefresh('ThemeSelector');
                }else{
                    alert('<?=Lang::t('failed');?>');
                }
           },'json');
        });
        <? if(!$preview){?>
        $("#activatebutton_<?=$theme->theme_id;?>_<?=$t;?>").click(function(){
            $.get("<?=_SPPATH;?>ThemeModWeb/preview?id=<?=$theme->theme_id;?>",function(data){
                console.log(data);
                if(data.bool){
                    lwrefresh('ThemeSelector');
                    //alert('<?=Lang::t('changes applied');?>');
                }else{
                    alert('<?=Lang::t('failed');?>');
                }
           },'json');
        });
         <?}else{?>
         $("#deactivatebutton_<?=$theme->theme_id;?>_<?=$t;?>").click(function(){
            $.get("<?=_SPPATH;?>ThemeModWeb/depreview?id=<?=$theme->theme_id;?>",function(data){
                console.log(data);
                if(data.bool){
                    lwrefresh('ThemeSelector');
                    //alert('<?=Lang::t('changes applied');?>');
                }else{
                    alert('<?=Lang::t('failed');?>');
                }
           },'json');
        });
         <? }?>
        </script>
        <? } //if
        }?>
    </tbody>
</table>
        <?
    }
    
    public function preview(){
        $json = array();
        $json['bool'] = 1;
        $id = isset($_GET['id'])?addslashes($_GET['id']):0;
        if($id<1)$json['bool'] = 0;
        else
            ThemeItem::setPreviewTheme ($id);
        
        echo json_encode($json);
    }
    public function depreview(){
        $json = array();
        $json['bool'] = 1;
        $id = isset($_GET['id'])?addslashes($_GET['id']):0;
        if($id<1)$json['bool'] = 0;
        else
            ThemeItem::removePreviewTheme();
        
        echo json_encode($json);
    }

    public function restores(){
        $tdir = isset($_GET['tdir'])?addslashes($_GET['tdir']):die("NO ID");
        $ok = ThemeItem::restoreTheme($tdir);        
        if($ok)echo Lang::t("Restoration Success");
        else echo Lang::t("Restoration Failed");
    }

    public function activate() {
        //pr($_GET);
        $id = isset($_GET['id'])?addslashes($_GET['id']):die("NO ID");
        $active = isset($_GET['active'])?addslashes($_GET['active']):die("NO ID");
        $json = array();
        $json['bool'] = 0;
        if($active){
            ThemeItem::nonActiveAll();
        
            $tm = new ThemeItem();
            $tm->getByID($id);
            $tm->theme_active = $active;
            $tm->load = 1;
            $json['bool'] = $tm->save();
        }
        echo json_encode($json);
    }

}
