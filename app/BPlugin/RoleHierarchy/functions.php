<?php
/**
 * Created by PhpStorm.
 * User: elroy
 * Date: 7/20/16
 * Time: 9:52 PM
 */

Registor::registerAdminMenu("RBAC", "AccessRight", "RoleHBE/AccessRight");
//set yang bisa lihat menu
Registor::setDomainAndRoleMenu("AccessRight");

Registor::registerAdminMenu("RBAC", "AccessRight2Role", "RoleHBE/AccessRight2Role");
//set yang bisa lihat menu
Registor::setDomainAndRoleMenu("AccessRight2Role");

Registor::registerAdminMenu("RBAC", "AccessMatrix", "RoleHBE/AccessMatrix");
//set yang bisa lihat menu
Registor::setDomainAndRoleMenu("AccessMatrix");