<script>
  fblogged = 0;  
  fbid = 0;
  fbname = 'untitled';
  var initial_check = 0;
  // This is called with the results from from FB.getLoginStatus().
  function statusChangeCallback(response) {
      //for test penting - roy
    //console.log('statusChangeCallback');
    //console.log(response);
    
    // The response object is returned with a status field that lets the
    // app know the current login status of the person.
    // Full docs on the response object can be found in the documentation
    // for FB.getLoginStatus().
    if (response.status === 'connected') {
      // Logged into your app and Facebook.
      if(!initial_check)
      testAPI();
    } else if (response.status === 'not_authorized') {
      // The person is logged into Facebook, but not your app.
      document.getElementById('fbstatus').innerHTML = 'Please log ' +
        'into this app.';
    } else {
      // The person is not logged into Facebook, so we're not sure if
      // they are logged into this app or not.
      document.getElementById('fbstatus').innerHTML = 'Please log ' +
        'into Facebook.';
    }
  }

  // This function is called when someone finishes with the Login
  // Button.  See the onlogin handler attached to it in the sample
  // code below.
  function checkLoginState() {
      initial_check = 0;
    FB.getLoginStatus(function(response) {
      statusChangeCallback(response);
    });
  }
//1537844706479674
  window.fbAsyncInit = function() {
  FB.init({
    appId      : '<?=  Efiwebsetting::getData('fb_app_id');?>',
    cookie     : true,  // enable cookies to allow the server to access 
                        // the session
    xfbml      : true,  // parse social plugins on this page
    version    : 'v2.1' // use version 2.1
  });

  // Now that we've initialized the JavaScript SDK, we call 
  // FB.getLoginStatus().  This function gets the state of the
  // person visiting this page and can return one of three states to
  // the callback you provide.  They can be:
  //
  // 1. Logged into your app ('connected')
  // 2. Logged into Facebook, but not your app ('not_authorized')
  // 3. Not logged into Facebook and can't tell if they are logged into
  //    your app or not.
  //
  // These three cases are handled in the callback function.

  FB.getLoginStatus(function(response) {
      initial_check = 1;
    statusChangeCallback(response);
  });

  };

  // Load the SDK asynchronously
  (function(d, s, id) {
    var js, fjs = d.getElementsByTagName(s)[0];
    if (d.getElementById(id)) return;
    js = d.createElement(s); js.id = id;
    js.src = "//connect.facebook.net/en_US/sdk.js";
    fjs.parentNode.insertBefore(js, fjs);
  }(document, 'script', 'facebook-jssdk'));

  // Here we run a very simple test of the Graph API after login is
  // successful.  See statusChangeCallback() for when this call is made.
  function testAPI() {
      //for test penting - roy
    //console.log('Welcome!  Fetching your information.... ');
    FB.api('/me', function(response) {
        //for test penting - roy
      //console.log('Successful login for: ' + response.name);
      document.getElementById('fbstatus').innerHTML =
        '' + response.name + '';
        if (typeof jQuery === 'undefined') {
            $('fblogin').hide();
        }else{
            $('#fblogin').hide();
        }
        //for test penting - roy
        //console.log(response);
        saveFBUser(response);
        fblogged = 1;
        fbid = response.id;
        fbname = response.name;
        //alert(camp_id_active);
        //document.location = '<?=_SPPATH;?>questionaire?id='+camp_id_active;
    });
  }
  
  function saveFBUser(response){
        var occs = JSON.stringify(response);
        //for test penting - roy
        //console.log('in here');
        if (typeof jQuery === 'undefined') {
            // jQuery is NOT available
            //uses rightjs
            Xhr.load("<?=_SPPATH;?>saveFBUser",{
            params: { user : occs },
            method : 'post',
            onSuccess : function(e){
                       var hasil = e.responseText;
                       //alert(hasil);
                       var data = JSON.parse(hasil);
                       //saved = 1;
                       if(data.bool){
                            //alert('Login Successful');
                            document.location='<?=_SPPATH;?>suksesFB';
                        }else{
                            alert('Saving User Data Failed');
                        }
                    }
                });
            
          } else {
            // jQuery is available
            //uses jquery
            //for test penting - roy
            //console.log('in here jquery');
            $.post("<?=_SPPATH;?>saveFBUser",{ user : occs },function(data){
                //$("span").html(result);
                //console.log(data);
                if(data.bool){
                    $('#tungguSebentar').show();
                    //alert('Login Successful');
                    document.location='<?=_SPPATH;?>suksesFB';
                }else{
                    alert('Saving User Data Failed');
                    location.reload();
                }
            },'json');
          }

        
  }
  
  function my_fb_login() {
    FB.login( function() {testAPI();}, { scope: 'email,public_profile' } );
}
</script>