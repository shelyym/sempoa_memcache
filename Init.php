<?php
/*
 * Leap System eLearning
 * Each line should be prefixed with  * 
 */
use Leap\InitLeap;

/**
 * Description of Init
 *
 * @author User
 */
class Init extends InitLeap {


    public function __construct ($mainClass, $DbSetting, $WebSetting, $timezone, $js, $css, $nameSpaceForApps)
    {
        parent::__construct($mainClass);

        //start session if needed
        //if(!$this->is_session_started())

        // init whats needed //kalau ga perlu bisa dihilangkan tergantung kebutuhan
        //set globals


        $this->setGlobalVariables($WebSetting);

        //Initialize DB
        // DbChooser::setDBSelected();
        //DB setting di access di overwrite spy bisa ada choosernya...
        //$skolahDB = DbChooser::getDBSelected();
        //$DbSetting = $this->arrDBSetting[$skolahDB];
        global $DbSetting;
        $this->setDB($DbSetting);

        //overwrite global variable to set photopath for different schools
        global $photo_path;
        global $photo_url;
        define('_PHOTOPATH', $photo_path);
        define('_PHOTOURL', $photo_url);

        //Init Template
        $this->setTemplate($WebSetting);
        //Init Web Parameter
        $this->setParams();
        //Init Timezone
        $this->setTimezone($timezone);

        //Init Mobile Check in untuk menentukan default
        $this->setHardwareType();
        if ($this->getHardwareType() == "mobile") {
            Mobile::setMobile(1);
        }

        //cek to mobile get
        Mobile::checkGetMobile();

        //$nameSpaceForApps        
        $this->setNameSpacesForApps($nameSpaceForApps);
        //add css and js
        $this->template->addFilesToHead($js);
        $this->template->addFilesToHead($css);
        //run it
        //$this->run();
    }


}
