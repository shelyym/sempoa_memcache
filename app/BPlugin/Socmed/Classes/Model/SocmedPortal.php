<?php

/**
 * Created by PhpStorm.
 * User: MarcelSantoso
 * Date: 12/10/14
 * Time: 8:18 PM
 */
class SocmedPortal extends ModelPortalContent {

	//Nama Table
	public $table_name = "sp_content__socmed";

	//Primary
	public $main_id = 'socmed_id';

	//Default Coloms for read
	public $default_read_coloms = 'socmed_id,socmed_post_id,socmed_title,socmed_text,socmed_url,socmed_img_url,socmed_type';

	//allowed colom in CRUD filter
	public $coloumlist = 'socmed_id,socmed_post_id,socmed_title,socmed_text,socmed_url,socmed_img_url,socmed_type';

	public $socmed_id;
	public $socmed_post_id;
	public $socmed_title;
	public $socmed_text;
	public $socmed_url;
	public $socmed_img_url;
	public $socmed_type;

}
