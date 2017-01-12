<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of BLoggerWeb
 *
 * @author Elroy Hardoyo<elroy.hardoyo@leap-systems.com>
 */
class BLoggerWeb extends WebService{
    function WhoIsOnline(){
        $min = isset($_GET['min'])?addslashes($_GET['min']):10;
        $ret = BLogger::getUserOnlineLastXMinutes($min);
        //pr($ret);
        echo '<h1>'.Lang::t('Number of Users Online : ').$ret['nr']."</h1>";

        $t = time();
        ?>
<div class="table-responsive">
    <div style="padding-bottom:  20px;">
        <?=Lang::t('Select Time Frame');?> :
    <select id="selectortime_<?=$t;?>">
        <option <?if($min=='5')echo "selected";?> value="5">5 Min</option>
        <option <?if($min=='10')echo "selected";?> value="10">10 Min</option>
        <option <?if($min=='30')echo "selected";?> value="30">30 Min</option>
        <option <?if($min=='60')echo "selected";?> value="60">60 Min</option>
        <option <?if($min=='120')echo "selected";?> value="120">2 Hours</option>
        <option <?if($min=='360')echo "selected";?> value="360">6 Hours</option>
        <option <?if($min=='720')echo "selected";?> value="720">12 Hours</option>
        <option <?if($min=='1440')echo "selected";?> value="1440">1 Day</option>
    </select>
    </div>

    <script>
        $('#selectortime_<?=$t;?>').change(function(){
           var slc =  $('#selectortime_<?=$t;?>').val();
           openLw('WhoIsOnline','<?=_SPPATH;?>BLoggerWeb/WhoIsOnline?min='+slc,'fade');
        });
    </script>
    <table class="table table-bordered table-hover">
        <thead>
            <tr>
                <th><?=Lang::t('Time');?></th>
                <th><?=Lang::t('ID');?></th>
                <th><?=Lang::t('Username');?></th>
                <th><?=Lang::t('Role');?></th>
                <th><?=Lang::t('URL');?></th>
                <th><?=Lang::t('IP');?></th>
                <th><?=Lang::t('Action');?></th>
                <th><?=Lang::t('Device');?></th>
                <th><?=Lang::t('Note');?></th>
            </tr>
        </thead>
        <? foreach($ret['all'] as $log){?>
        <tr>
            <td>
                <?=  indonesian_date($log->b_log_time);?>
            </td>
            <td>
                <?=$log->b_log_userid;?>
            </td>
            <td>
                <?=$log->b_log_username;?>
            </td>
            <td>
                <?=$log->b_log_userrole;?>
            </td>
            <td>
                <?=$log->b_log_url;?>
            </td>
            <td>
                <?=$log->b_log_ip;?>
            </td>
            <td>
                <?=$log->b_log_action;?>
            </td>
            <td>
                <?=$log->b_log_user_agent;?>
            </td>
            <td>
                <?=$log->b_log_keterangan;?>
            </td>
        </tr>
        <? }?>
    </table>
</div>
        <?
    }

    function Backup(){
        $dir    = _PHOTOPATH."logs";
        $files1 = scandir($dir);
        //echo $dir;
        //pr($files1);
        $arrThemes = array();
        //ThemeItem::emptyAll();
        ?>
<h1><?=Lang::t("Logs Backup");?></h1>
<div class="table-responsive">

<table class="table table-bordered table-striped">
<?
        foreach($files1 as $tname){
	        //if(strstr($tname,".json")||strstr($tname,".sql")||strstr($tname,".csv")){
                if(strstr($tname,".json")||strstr($tname,".sql")){
                //echo $tname;
                ?>
<tr>
    <td>
        <a target="_blank" href="<?=_SPPATH._PHOTOURL;?>logs/<?=$tname;?>"><?=$tname;?></a>
    </td>
</tr>
                <?
            }
            else{

            }
        }
        ?>
</table>
</div>
         <?
    }

    function DoBackup(){
        $bl = new BLogger();
        BLogger::dumpDataJSON();
        //BLogger::dumpSQL();
	BLogger::dumpDataCSV();
        //$bl->truncate();
        exit();
    }
    public function BLogger ()
    {
        //create the model object
        $cal = new BLogger();
        //send the webclass 
        $webClass = __CLASS__;

        //run the crud utility
        Crud::run($cal, $webClass);

        //pr($mps);
    }
    
    public function Top_Page(){
        
         $bl = new BLogger();
         
         $beginDate = addslashes($_GET['begindate']);
         
         if($beginDate==""){
            $month = date("n");
            $day = 1;
            $year = date("Y");

            $timeAwal = mktime(0, 0, 0, $month, $day, $year);
            $timeAkhir = mktime(0, 0, 0, $month+1, $day, $year);

            $mon = $month;
            $y = $year;
            
            $timeAwalText = date("Y")."-".date("m")."-01 00:00:00";

            $ts = mktime(0, 0, 0, date("n") + 1, 1,date("Y"));
            $timeAkhirText =  date("Y-m-d H:i:s", $ts);
         }else{
             $timeAwalText = $beginDate." 00:00:00";
             $bgindatestr = strtotime($beginDate);
             $mon = date("n",$bgindatestr);
             $y = date("Y",$bgindatestr);
             $ts = mktime(0, 0, 0, $mon + 1, 1,$y);
             $timeAkhirText =  date("Y-m-d H:i:s", $ts);
             $year = $y;
         }
        
         
         
         /*echo $timeAwal;
         echo "<br>";
         echo $timeAkhir;
         */
         ?>
        <h1>Top Page</h1>    
         <?
         $text = "(b_log_time BETWEEN '$timeAwalText' AND '$timeAkhirText')";
         $textAs = "b_timestamp >= $timeAwal AND b_timestamp < $timeAkhir";
        // echo "<br>";
        // echo $text;
         $arrLogs = $bl->getWhere("$text ORDER BY b_timestamp ASC");
         //pr($arrLogs);
         
         foreach($arrLogs as $h){
             $newArr[$h->b_log_url][] = $h;
             
         }
         
         foreach($newArr as $url=>$n){
             $newArrs[$url] = count($n);
         }
         asort($newArrs);
         $jadi = array_reverse($newArrs);
        // pr($newArr);
         $t = time();
        
         ?>
<div class="table-responsive">
  <form class="form-inline">
  <div class="form-group">
    <label for="monselection_<?=$t;?>">Select Month</label>
    <select class="form-control" id="monselection_<?=$t;?>"><?
        $beginyear = date("Y")-5;
        $endyear = date("Y");
        $beginyear = 2015;
        $mons = array(1 => "Jan", 2 => "Feb", 3 => "Mar", 4 => "Apr", 5 => "May", 6 => "Jun", 7 => "Jul", 8 => "Aug", 9 => "Sep", 10 => "Oct", 11 => "Nov", 12 => "Dec");
        
        for($x=$beginyear;$x<=$endyear;$x++){
            for($m=1;$m<13;$m++){
                if($m == $mon && $x == $year){
                   $select = "selected";
                   echo "in";
                }else { $select = "";}
                
                if($x == date("Y"))
                    if($m > date("n"))
                        continue;
                ?>
                <option <?=$select;?> value="<?=$x;?>-<?=$m;?>-01"><?=$x;?> <?=$mons[$m];?> </option>   
                 <?
            }
        }
    
    ?>
    </select> 
  </div>
 <button class="btn btn-default" onclick="window.open('<?=_SPPATH._PHOTOURL."logs/TopPage_".$year."_".$mon;?>.xls', '_blank');event.preventDefault();">Download</button>
</form>
    
     
    
    <script>
    $('#monselection_<?=$t;?>').change(function(){
        var slc = $('#monselection_<?=$t;?>').val();
       openLw('Top_Page','<?=_SPPATH;?>BLoggerWeb/Top_Page?begindate='+slc,'fade'); 
    });
    </script>
    <div style="padding: 10px;"></div>
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Rank</th>
                <th>URL</th>
                <th>No.Visits</th>
            </tr>
        </thead>
        <? 
        $num = 0;
        $arrExcel = array();
        $arrExcel[] = "Rank;URL;No.Visits";
        $arrExcel2 = array();
        foreach($jadi as $url=>$n){
            
            $num++;
             $arrExcel[] = "$num;$url;$n";  
            ?>
        <tr>
            <td><?=$num;?></td>
            <td><?=$url;?> <a href="<?=$url;?>" target="_blank">link</a></td>           
            <td><?=$n;?></td>
        </tr>
        <? 
        $obj = array("Rank"=>$num,"URL"=>$url,"Visits"=>$n);
        $arrExcel2[] = $obj;
        } ?>
    </table>
</div>    
         <?
       /* $fname = "TopPage_".$year."_".$mon. ".csv";
        $file = fopen(_PHOTOPATH . "logs/" . $fname, "w+");

        foreach ($arrExcel as $line) {
                fputcsv($file, explode(';', $line));
        }

        fclose($file);
        */
        $fname = _PHOTOPATH . "logs/" ."TopPage_".$year."_".$mon. ".xls";
        ExcelExporter::saveIt($arrExcel2, $fname);
    }
    
    public function Top_User(){
        
         $bl = new BLogger();
         
         $beginDate = addslashes($_GET['begindate']);
         
         if($beginDate==""){
            $month = date("n");
            $day = 1;
            $year = date("Y");

            $timeAwal = mktime(0, 0, 0, $month, $day, $year);
            $timeAkhir = mktime(0, 0, 0, $month+1, $day, $year);

            $mon = $month;
            $y = $year;
            
            $timeAwalText = date("Y")."-".date("m")."-01 00:00:00";

            $ts = mktime(0, 0, 0, date("n") + 1, 1,date("Y"));
            $timeAkhirText =  date("Y-m-d H:i:s", $ts);
         }else{
             $timeAwalText = $beginDate." 00:00:00";
             $bgindatestr = strtotime($beginDate);
             $mon = date("n",$bgindatestr);
             $y = date("Y",$bgindatestr);
             $ts = mktime(0, 0, 0, $mon + 1, 1,$y);
             $timeAkhirText =  date("Y-m-d H:i:s", $ts);
             $year = $y;
         }
        
         
         /*echo $timeAwal;
         echo "<br>";
         echo $timeAkhir;
         */
         ?>
        <h1>Top User</h1>    
         <?
         $text = "(b_log_time BETWEEN '$timeAwalText' AND '$timeAkhirText')";
         $textAs = "b_timestamp >= $timeAwal AND b_timestamp < $timeAkhir";
        // echo "<br>";
        // echo $text;
         $arrLogs = $bl->getWhere("$text ORDER BY b_timestamp ASC");
         //pr($arrLogs);
         
         foreach($arrLogs as $h){
             if($h->b_log_username == "" || $h->b_log_userid ==0)
                                  continue;
             $newArr[$h->b_log_username][] = $h;
             
         }
         
         foreach($newArr as $url=>$n){
             $newArrs[$url] = count($n);
         }
         asort($newArrs);
         $jadi = array_reverse($newArrs);
        // pr($newArr);
         $t = time();
        
         ?>
<div class="table-responsive">
    <form class="form-inline">
  <div class="form-group">
    <label for="monselection_<?=$t;?>">Select Month</label>
    <select class="form-control" id="monselection_<?=$t;?>"><?
        $beginyear = date("Y")-5;
        $endyear = date("Y");
        $beginyear = 2015;
        $mons = array(1 => "Jan", 2 => "Feb", 3 => "Mar", 4 => "Apr", 5 => "May", 6 => "Jun", 7 => "Jul", 8 => "Aug", 9 => "Sep", 10 => "Oct", 11 => "Nov", 12 => "Dec");
        
        for($x=$beginyear;$x<=$endyear;$x++){
            for($m=1;$m<13;$m++){
                if($m == $mon && $x == $year){
                   $select = "selected";
                   echo "in";
                }else { $select = "";}
                
                if($x == date("Y"))
                    if($m > date("n"))
                        continue;
                ?>
                <option <?=$select;?> value="<?=$x;?>-<?=$m;?>-01"><?=$x;?> <?=$mons[$m];?> </option>   
                 <?
            }
        }
    
    ?>
    </select> 
  </div>
 <button class="btn btn-default" onclick="window.open('<?=_SPPATH._PHOTOURL."logs/TopUser_".$year."_".$mon;?>.xls', '_blank');event.preventDefault();">Download</button>
</form>
    <script>
        $('#monselection_<?=$t;?>').change(function(){
            var slc = $('#monselection_<?=$t;?>').val();
            openLw('Top_User','<?=_SPPATH;?>BLoggerWeb/Top_User?begindate='+slc,'fade'); 
        });
        </script>
    <div style="padding: 10px;"></div>
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Rank</th>
                
                <th>Username</th>
                <th>URL</th>
                <th>No.Visits</th>
            </tr>
        </thead>
        <? 
        $num = 0;
        $arrExcel = array();
        $arrExcel[] = "Rank;Username;No.Visits";
        $arrExcel2 = array();
        foreach($jadi as $url=>$n){
            $alog = $newArr[$url];
            $num++;
            $arrExcel[] = "$num;$url;$n"; 
            
            ?>
        <tr>
            <td><?=$num;?></td>
            <td><span style="cursor:pointer; text-decoration: underline;" onclick="$('.detail_<?=$url;?>').toggle();"><?=$url;?></span></td>    
            <td></td>
            <td><?=$n;?></td>
        </tr>
        <? 
        $obje = array();
        $obje["Rank"] = $num;
        $obje["Username"] = $url;
        $obje["URL"] = "";
        $obje["No Visits"] = $n;
        $arrExcel2[] = $obje;
        
        $key = $url;
        $newArr_dalam = array();
        foreach($alog as $h){
             $newArr_dalam[$h->b_log_url][] = $h;
             
         }
         $newArrs_dalam = array();
         foreach($newArr_dalam as $url=>$n){
             $newArrs_dalam[$url] = count($n);
         }
         asort($newArrs_dalam);
         $jadi_dalam = array_reverse($newArrs_dalam);
         
         ?>
        <? 
        $num_dalam = 0;
        foreach($jadi_dalam as $url_dalam=>$n_dalam){
            
            $num_dalam++;
            ?>
        <tr  class="detail_<?=$key;?>" style="display:none;">
            <td></td>
            <td></td>
            <td><?=$url_dalam;?> <a href="<?=$url_dalam;?>" target="_blank">link</a></td>           
            <td><?=$n_dalam;?></td>
        </tr>
        <? 
        $obje2 = array();
        $obje2["Rank"] = " ";
        $obje2["Username"] = " ";
        $obje2["URL"] = $url_dalam;
        $obje2["No Visits"] = $n_dalam;
        $arrExcel2[] = $obje2;
        
        } ?>
        
        <? } ?>
    </table>
</div>    
         <?
         /*
          $fname = "TopUser_".$year."_".$mon. ".csv";
        $file = fopen(_PHOTOPATH . "logs/" . $fname, "w+");

        foreach ($arrExcel as $line) {
                fputcsv($file, explode(';', $line));
        }

        fclose($file);
          * 
          */
         $fname = _PHOTOPATH . "logs/" ."TopUser_".$year."_".$mon. ".xls";
        ExcelExporter::saveIt($arrExcel2, $fname);
    }
    
    
    public function Top_Department(){
        
         $bl = new BLogger();
         
         $beginDate = addslashes($_GET['begindate']);
         
         if($beginDate==""){
            $month = date("n");
            $day = 1;
            $year = date("Y");

            $timeAwal = mktime(0, 0, 0, $month, $day, $year);
            $timeAkhir = mktime(0, 0, 0, $month+1, $day, $year);

            $mon = $month;
            $y = $year;
            
            $timeAwalText = date("Y")."-".date("m")."-01 00:00:00";

            $ts = mktime(0, 0, 0, date("n") + 1, 1,date("Y"));
            $timeAkhirText =  date("Y-m-d H:i:s", $ts);
         }else{
             $timeAwalText = $beginDate." 00:00:00";
             $bgindatestr = strtotime($beginDate);
             $mon = date("n",$bgindatestr);
             $y = date("Y",$bgindatestr);
             $ts = mktime(0, 0, 0, $mon + 1, 1,$y);
             $timeAkhirText =  date("Y-m-d H:i:s", $ts);
             $year = $y;
         }
        
         
         /*echo $timeAwal;
         echo "<br>";
         echo $timeAkhir;
         */
         ?>
        <h1>Top Department</h1>    
         <?
         $text = "(b_log_time BETWEEN '$timeAwalText' AND '$timeAkhirText')";
         $textAs = "b_timestamp >= $timeAwal AND b_timestamp < $timeAkhir";
        // echo "<br>";
        // echo $text;
         $arrLogs = $bl->getWhere("$text ORDER BY b_timestamp ASC");
         //pr($arrLogs);
         
         foreach($arrLogs as $h){
             if($h->log_user_org == "" || $h->log_user_org ==0)
                                  continue;
             $newArr["org_".$h->log_user_org][] = $h;
             
         }
         
         foreach($newArr as $url=>$n){
             $newArrs[$url] = count($n);
         }
         asort($newArrs);
         $jadi = array_reverse($newArrs);
        // pr($newArr);
         $t = time();
        //pr($jadi);
         ?>
<div class="table-responsive">
    <form class="form-inline">
  <div class="form-group">
    <label for="monselection_<?=$t;?>">Select Month</label>
    <select class="form-control" id="monselection_<?=$t;?>"><?
        $beginyear = date("Y")-5;
        $endyear = date("Y");
        $beginyear = 2015;
        $mons = array(1 => "Jan", 2 => "Feb", 3 => "Mar", 4 => "Apr", 5 => "May", 6 => "Jun", 7 => "Jul", 8 => "Aug", 9 => "Sep", 10 => "Oct", 11 => "Nov", 12 => "Dec");
        
        for($x=$beginyear;$x<=$endyear;$x++){
            for($m=1;$m<13;$m++){
                if($m == $mon && $x == $year){
                   $select = "selected";
                   echo "in";
                }else { $select = "";}
                
                if($x == date("Y"))
                    if($m > date("n"))
                        continue;
                ?>
                <option <?=$select;?> value="<?=$x;?>-<?=$m;?>-01"><?=$x;?> <?=$mons[$m];?> </option>   
                 <?
            }
        }
    
    ?>
    </select> 
  </div>
 <button class="btn btn-default" onclick="window.open('<?=_SPPATH._PHOTOURL."logs/TopDepartment_".$year."_".$mon;?>.xls', '_blank');event.preventDefault();">Download</button>
</form>
    <script>
        $('#monselection_<?=$t;?>').change(function(){
            var slc = $('#monselection_<?=$t;?>').val();
            openLw('Top_Department','<?=_SPPATH;?>BLoggerWeb/Top_Department?begindate='+slc,'fade'); 
        });
        </script>
    <div style="padding: 10px;"></div>
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Rank</th>
                
                <th>Department</th>
                <th>URL</th>
                <th>No.Visits</th>
            </tr>
        </thead>
        <? 
        $num = 0;
        $arrExcel = array();
        $arrExcel2 = array();
        $arrExcel[] = "Rank;Department;No.Visits";
        foreach($jadi as $url=>$n){
            $alog = $newArr[$url];
            $num++;
            $dp = new RoleOrganization();
            $id = explode("_",$url);
            //pr($id);
            $dp->getByID($id[1]);
            $arrExcel[] = "$num;{$dp->organization_name};$n";
            ?>
        <tr>
            <td><?=$num;?></td>
            <td><span style="cursor:pointer; text-decoration: underline;" onclick="$('.detail_<?=$url;?>').toggle();"><?=$dp->organization_name;?></span></td>    
            <td></td>
            <td><?=$n;?></td>
        </tr>
        <? 
        $obje = array();
        $obje["Rank"] = $num;
        $obje["Department"] = $dp->organization_name;
        $obje["URL"] = "";
        $obje["No Visits"] = $n;
        $arrExcel2[] = $obje;
        
        $key = $url;
        $newArr_dalam = array();
        foreach($alog as $h){
             $newArr_dalam[$h->b_log_url][] = $h;
             
         }
         $newArrs_dalam = array();
         foreach($newArr_dalam as $url=>$n){
             $newArrs_dalam[$url] = count($n);
         }
         asort($newArrs_dalam);
         $jadi_dalam = array_reverse($newArrs_dalam);
         
         ?>
        <? 
        $num_dalam = 0;
        foreach($jadi_dalam as $url_dalam=>$n_dalam){
            
            $num_dalam++;
            ?>
        <tr  class="detail_<?=$key;?>" style="display:none;">
            <td></td>
            <td></td>
            <td><?=$url_dalam;?> <a href="<?=$url_dalam;?>" target="_blank">link</a></td>           
            <td><?=$n_dalam;?></td>
        </tr>
        <? 
        $obje2 = array();
        $obje2["Rank"] = " ";
        $obje2["Department"] = " ";
        $obje2["URL"] = $url_dalam;
        $obje2["No Visits"] = $n_dalam;
        $arrExcel2[] = $obje2;
        
        } ?>
        
        <? } ?>
    </table>
</div>    
         <?
         /*
        $fname = "TopDepartment_".$year."_".$mon. ".csv";
        $file = fopen(_PHOTOPATH . "logs/" . $fname, "w+");

        foreach ($arrExcel as $line) {
                fputcsv($file, explode(';', $line));
        }

        fclose($file);*/
          $fname = _PHOTOPATH . "logs/" ."TopDepartment_".$year."_".$mon. ".xls";
        ExcelExporter::saveIt($arrExcel2, $fname);
    }
}
