<?php

/**
 * Description of PageComment
 *
 * @author Elroy Hardoyo<elroy.hardoyo@leap-systems.com>
 */
class PageComment extends Model{
    //Nama Table
    public $table_name = "jp_posts__comment";  
    
    //Primary
    public $main_id = 'comment_id';
    
    //Default Coloms for read
    public $default_read_coloms = 'comment_id,comment_text,comment_author,comment_date,comment_page_id';
    
    //allowed colom in CRUD filter
    public $coloumlist = 'comment_id,comment_text,comment_author,comment_date,comment_page_id,comment_type';
    
    public $comment_id;
    public $comment_text;
    public $comment_author;
    public $comment_date;
    public $comment_page_id;
    public $comment_type;
}
