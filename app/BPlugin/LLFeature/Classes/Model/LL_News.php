<?php

/**
 * Description of LL_Program
 *
 * @author Elroy Hardoyo<elroy.hardoyo@leap-systems.com>
 */
class LL_News extends Model
{
    //Nama Table
    public $table_name = "ll__news";

    //Primary
    public $main_id = 'news_id';

//Default Coloms for read
    public $default_read_coloms = "news_id,news_name,news_url,news_pic,news_active,news_date_created,news_start,news_end,news_order";

//allowed colom in CRUD filter
    public $coloumlist = "news_id,news_name,news_url,news_content,news_pic,news_active,news_date_created,news_start,news_end,news_order";
    public $news_id;
    public $news_name;
    public $news_url;
    public $news_content;
    public $news_pic;
    public $news_active;
    public $news_date_created;
    public $news_start;
    public $news_end;
    public $news_order;

    public $crud_setting = array("add" => 1, "search" => 1, "viewall" => 1, "export" => 1, "toggle" => 1, "import" => 0, "webservice" => 1);
    public $crud_webservice_allowed = "news_id,news_name,news_url,news_content,news_pic,news_active,news_date_created,news_start,news_end,news_order";

    public $crud_add_photourl = array("news_pic");

    /*
       * fungsi untuk ezeugt select/checkbox
       *
       */
    public function overwriteForm($return, $returnfull)
    {
        $return = parent::overwriteForm($return, $returnfull);
        $return['news_content'] = new \Leap\View\InputTextRTE("news_content", "news_content", $this->news_content);
        $return['news_pic'] = new \Leap\View\InputFoto("foto", "news_pic", $this->news_pic);
        $return['news_active'] = new Leap\View\InputSelect($this->arrayYesNO, "news_active", "news_active",
            $this->news_active);

        if (!isset($this->news_date_created))
            $dt = leap_mysqldate();
        else
            $dt = $this->news_date_created;

        $return['news_date_created'] = new \Leap\View\InputText("date", "news_date_created", "news_date_created", $dt);
        $return['news_start'] = new \Leap\View\InputText("date","news_start", "news_start", $this->news_start);
        $return['news_end'] = new \Leap\View\InputText("date","news_end", "news_end", $this->news_end);
        if(!isset($this->news_order))$this->news_order = 0;
        $return['news_order'] = new \Leap\View\InputText("number","news_order", "news_order", $this->news_order);




        return $return;
    }

    public function overwriteRead($return)
    {
        $return = parent::overwriteRead($return);

        $objs = $return['objs'];
        foreach ($objs as $obj) {
            if (isset($obj->news_pic)) {
                $obj->news_pic = \Leap\View\InputFoto::getAndMakeFoto($obj->news_pic, "news_image_" . $obj->news_pic);
            }

            if (isset($obj->news_active)) {
                $obj->news_active = $this->arrayYesNO[$obj->news_active];
            }
        }
        return $return;
    }

    public function overwriteReadExcel($return)
    {
//        $return = parent::overwriteRead($return);

        $objs = $return['objs'];
        foreach ($objs as $obj) {

            if (isset($obj->news_active)) {
                $obj->news_active = $this->arrayYesNO[$obj->news_active];
            }
        }
        return $return;
    }

    public function constraints()
    {
        //err id => err msg
        $err = array();

        if (!isset($this->news_name)) {
            $err['news_name'] = Lang::t('Program name cannot be empty');
        }


        if (!isset($this->news_pic)) {
            $err['news_pic'] = Lang::t('Please provide program photo');

        }


        return $err;
    }
}
