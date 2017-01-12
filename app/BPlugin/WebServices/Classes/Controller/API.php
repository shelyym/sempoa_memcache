<?php
/**
 * Created by PhpStorm.
 * User: elroy
 * Date: 12/8/15
 * Time: 10:20 AM
 */

class API extends WebService{

    function getHomePage(){

        APIVerify::verify();

        APICampaign::getHome();
    }

    function searchProduct(){

    }

    function getProductList(){

    }

    function getCampaignDetails(){

    }

    function getProductDetails(){

    }

    function getReviewsByPage(){

    }

    function submitReview(){

    }
    function checkout(){

    }
    function facebookLogin(){

    }

    function getAllTransactions(){

    }

    function getReceiptByOrder(){

    }
} 