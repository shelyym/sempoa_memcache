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
    function getMemcacheKeys()
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
                        echo $k .'<br>';
                        pr($memcache->get($k));

                    }
                }
            }
        }



//        $reg = new RegisterGuru();
//        $reg->isInvoiceCreated(50);
//        pr($reg);
        echo "end";

//
//
//
//
//        $biaya = Generic::getBiayaByJenis(KEY::$BIAYA_PENDAFTARAN_GURU, AccessRight::getMyOrgID());
//        $guru = new SempoaGuruModel();
//        $guru->getByID(45);
//        pr($biaya);




        die();
        pr("Memcache");
        pr($memcache->get("localhost:8888/sempoa_memcached//MatrixNilaiModel_c__2"));
        $id =
        $murid = $memcache->get("localhost:8888/sempoa_memcached//MuridModel_c__831");
        pr($murid);
//        pr($murid['nama_siswa']);
        pr("Model");
        $muridModel = new MuridModel();
        $muridModel->getByID(831);

        pr($muridModel);
//        pr(get_called_class);
    }

    function printMemcacheKey(){


        $m = new Memcached();
        $m->addServer('localhost', 11211);
        $keys = $m->getAllKeys();
        foreach ($keys as $index => $key) {
            pr($key);
//            if (strpos($key,$prefix) !== 0) {
//                unset($keys[$index]);
//            } else {
////                $m->delete($key);
//            }
        }
        return $keys;

    }

    function deletekeysbyindex() {
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
                        echo $k .'<br>';

                        $memcache->delete($k);
                        pr($memcache->get($k));

                    }
                }
            }
        }
    }
}