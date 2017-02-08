<?php

/**
 * Created by PhpStorm.
 * User: efindiongso
 * Date: 1/12/17
 * Time: 9:45 AM
 */
class TestMemcache extends WebService
{

    function testMemcache()
    {
        global $memcache;
        pr($memcache->cacheAvailable);


    }


    function getMemcacheKeysThis()
    {

        global $domain;
        global $folder;
        $memcache = new Memcache;
        $memcache->connect('127.0.0.1', 11211)
        or die ("Could not connect to memcache server");

        $list = array();
        $allSlabs = $memcache->getExtendedStats('slabs');
        $items = $memcache->getExtendedStats('items');
        foreach ($allSlabs as $server => $slabs) {
            foreach ($slabs AS $slabId => $slabMeta) {
                $cdump = $memcache->getExtendedStats('cachedump', (int)$slabId);
                foreach ($cdump AS $keys => $arrVal) {
                    if (!is_array($arrVal)) continue;
                    foreach ($arrVal AS $k => $v) {
                        echo $k . '<br>';
                        pr($memcache->get($k));
                    }
                }
            }
        }

    }

    function printallKeys()
    {
        $memcache = new Memcache;
        $memcache->connect('127.0.0.1', 11211)
        or die ("Could not connect to memcache server");

        $list = array();
        $allSlabs = $memcache->getExtendedStats('slabs');
        $items = $memcache->getExtendedStats('items');
        foreach ($allSlabs as $server => $slabs) {
            foreach ($slabs AS $slabId => $slabMeta) {
                $cdump = $memcache->getExtendedStats('cachedump', (int)$slabId);
                foreach ($cdump AS $keys => $arrVal) {
                    if (!is_array($arrVal)) continue;
                    foreach ($arrVal AS $k => $v) {

                        echo $k . '<br>';
                        pr($memcache->get($k));


                    }
                }
            }
        }
    }

    function getMemcacheKeysByMyFolder()
    {

        global $folder;
        $memcache = new Memcache;
        $memcache->connect('127.0.0.1', 11211)
        or die ("Could not connect to memcache server");

        $list = array();
        $allSlabs = $memcache->getExtendedStats('slabs');
        $items = $memcache->getExtendedStats('items');
        foreach ($allSlabs as $server => $slabs) {
            foreach ($slabs AS $slabId => $slabMeta) {
                $cdump = $memcache->getExtendedStats('cachedump', (int)$slabId);
                foreach ($cdump AS $keys => $arrVal) {
                    if (!is_array($arrVal)) continue;
                    foreach ($arrVal AS $k => $v) {
                        $check = strpos($k, $folder);
                        if ($check) {
                            echo $k . '<br>' . $check;
                            pr($memcache->get($k));
                        }


                    }
                }
            }
        }

    }


// Bahaya!!
// Menghapus memcache di folder yg skrg lagi aktiv
    function delMemcacheKeysByMyFolder()
    {

        global $folder;
        $memcache = new Memcache;
        $memcache->connect('127.0.0.1', 11211)
        or die ("Could not connect to memcache server");

        $list = array();
        $allSlabs = $memcache->getExtendedStats('slabs');
        $items = $memcache->getExtendedStats('items');
        foreach ($allSlabs as $server => $slabs) {
            foreach ($slabs AS $slabId => $slabMeta) {
                $cdump = $memcache->getExtendedStats('cachedump', (int)$slabId);
                foreach ($cdump AS $keys => $arrVal) {
                    if (!is_array($arrVal)) continue;
                    foreach ($arrVal AS $k => $v) {
                        $check = strpos($k, $folder);
                        if ($check) {
                            echo $k . '<br>' . $check;
                            $memcache->delete($k);
                            pr($memcache->get($k));
                        }


                    }
                }
            }
        }

    }

}