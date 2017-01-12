<?php
/**
 * Created by PhpStorm.
 * User: elroy
 * Date: 3/29/16
 * Time: 6:47 PM
 */

//set menu format domain, menuname. menu url
Registor::registerAdminMenu("Capsule", "DevicesCaps", "PushNotBE/DeviceModelCapsule");
//set yang bisa lihat menu
Registor::setDomainAndRoleMenu("DevicesCaps");


//set menu format domain, menuname. menu url
Registor::registerAdminMenu("Capsule", "Campaign_Caps", "PushNotCapsBE/PushNotCampCaps","Push Notifications Campaign");
//set yang bisa lihat menu
Registor::setDomainAndRoleMenu("Campaign_Caps");





//
Registor::registerAdminMenu("Capsule", "testPush_Caps", "PushNotCapsBE/testPush");

Registor::setDomainAndRoleMenu("testPush_Caps");


//set menu format domain, menuname. menu url
Registor::registerAdminMenu("Capsule", "Camp_ResultData", "PushNotCapsBE/GCMResultCaps");
//set yang bisa lihat menu
Registor::setDomainAndRoleMenu("Camp_ResultData");


//set menu format domain, menuname. menu url
Registor::registerAdminMenu("Capsule", "Camp_Log", "PushNotCapsBE/PushLoggerCaps");
//set yang bisa lihat menu
Registor::setDomainAndRoleMenu("Camp_Log");
