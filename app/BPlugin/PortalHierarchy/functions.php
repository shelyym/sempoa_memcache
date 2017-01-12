<?php



Registor::registerAdminMenu("Setting", "Level", "PortalAdminWeb/RoleLevel");
//set yang bisa lihat menu
Registor::setDomainAndRoleMenu("Level");

Registor::registerAdminMenu("Setting", "Department", "PortalAdminWeb/RoleOrganization");
//set yang bisa lihat menu
Registor::setDomainAndRoleMenu("Department");

Registor::registerAdminMenu("Setting", "NewsChannel", "PortalAdminWeb/NewsChannel");
//set yang bisa lihat menu
Registor::setDomainAndRoleMenu("NewsChannel");

Registor::registerAdminMenu("Setting", "NewsChannelMatrix", "NewsChannelWeb/NewsChannelMatrix");
//set yang bisa lihat menu
Registor::setDomainAndRoleMenu("NewsChannelMatrix");

Registor::registerAdminMenu("Setting", "Account2LevelAndDept", "PortalAdminWeb/AccountManagement");
//set yang bisa lihat menu
Registor::setDomainAndRoleMenu("Account2LevelAndDept");
