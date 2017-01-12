<?php
/*ADMIN MENU */
Registor::emptyAdminMenu();
//set menu format domain, menuname. menu url
Registor::registerAdminMenu("UserAndRoles", "Account", "AccountLoginWeb/account","Used for Admin Account Management Systems");
//set yang bisa lihat menu
Registor::setDomainAndRoleMenu("Account");

//set menu format domain, menuname. menu url
Registor::registerAdminMenu("UserAndRoles", "Role", "AccountLoginWeb/Role","Used for defining the roles of the admin accounts");
//set yang bisa lihat menu
Registor::setDomainAndRoleMenu("Role");

//set menu format domain, menuname. menu url
//Registor::registerAdminMenu("UserAndRoles", "Role2Role", "AccountLoginWeb/Role2Role");
//set yang bisa lihat menu
//Registor::setDomainAndRoleMenu("Role2Role");

//set menu format domain, menuname. menu url
Registor::registerAdminMenu("UserAndRoles", "Role2RoleTree", "AccountLoginWeb/ShowRole2RoleLevel","Contains the correlation tree between roles.");
//set yang bisa lihat menu
Registor::setDomainAndRoleMenu("Role2RoleTree");

//set menu format domain, menuname. menu url
//Registor::registerAdminMenu("UserAndRoles", "Role2Account", "AccountLoginWeb/Role2Account");
//set yang bisa lihat menu
//Registor::setDomainAndRoleMenu("Role2Account");

//set menu format domain, menuname. menu url
Registor::registerAdminMenu("UserAndRoles", "Role2Menu", "RoleWeb/Role2Menu","Used to define access control of the roles");
//set yang bisa lihat menu
Registor::setDomainAndRoleMenu("Role2Menu");


