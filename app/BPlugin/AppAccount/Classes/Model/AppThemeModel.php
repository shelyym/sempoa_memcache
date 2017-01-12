<?php
/**
 * Created by PhpStorm.
 * User: elroy
 * Date: 6/20/16
 * Time: 10:56 AM
 */

class AppThemeModel extends Model{

    //Nama Table
    public $table_name = "push__app_theme";

    //Primary
    public $main_id = 'apptheme_id';

    var $crud_webservice_allowed = "apptheme_id,apptheme_name,apptheme_group,apptheme_header,apptheme_font,apptheme_warna1,apptheme_warna2,apptheme_warna3,apptheme_warna4,apptheme_active,apptheme_order,apptheme_isfree,apptheme_price,apptheme_min_version,apptheme_grid,apptheme_style";


    //Default Coloms for read
    public $default_read_coloms = "apptheme_id,apptheme_name,apptheme_group,apptheme_header,apptheme_font,apptheme_warna1,apptheme_warna2,apptheme_warna3,apptheme_warna4,apptheme_active,apptheme_order,apptheme_isfree,apptheme_price,apptheme_min_version,apptheme_grid,apptheme_style";

//allowed colom in CRUD filter
    public $coloumlist = "apptheme_id,apptheme_name,apptheme_group,apptheme_header,apptheme_font,apptheme_warna1,apptheme_warna2,apptheme_warna3,apptheme_warna4,apptheme_active,apptheme_order,apptheme_isfree,apptheme_price,apptheme_min_version,apptheme_grid,apptheme_style";
    public $apptheme_id;
    public $apptheme_name;
    public $apptheme_group;
    public $apptheme_header;
    public $apptheme_font;
    public $apptheme_warna1;
    public $apptheme_warna2;
    public $apptheme_warna3;
    public $apptheme_warna4;
    public $apptheme_active;
    public $apptheme_order;
    public $apptheme_isfree;
    public $apptheme_price;
    public $apptheme_min_version;


    public $apptheme_grid;
    public $apptheme_style;

} 