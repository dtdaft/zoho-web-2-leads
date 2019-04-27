<?php
//API 1 Zoho Auth Token - To generate -> https://accounts.zoho.com/apiauthtoken/nb/create?SCOPE=ZohoCRM/crmapi&EMAIL_ID=[YOUR_EMAIL]&PASSWORD=[YOUR_PASSWORD]&DISPLAY_NAME=Leads
$auth = "[YOUR_KEY]";

//Mandatory
$Company= $_GET['company'];
$LN= $_GET['ln'];
//Optionnal
$FN= $_GET['fn'];
$Email= $_GET['email'];
$Phone= $_GET['phone'];
$Source= $_GET['source'];
$Website= $_GET['website']; 
$City= $_GET['city']; 
$Industry= $_GET['industry'];
$Lead_owner= $_GET['lo'];
$Designation= $_GET['designation']; 
$Fax= $_GET['fax']; 
$Mobile= $_GET['mobile']; 
$Lead_statut= $_GET['ls']; 
$Employees= $_GET['ne']; 
$Annual_Revenue= $_GET['ar']; 
$Email_Opt_Out= $_GET['eoo']; 
$Skype= $_GET['skype']; 
$Salutation= $_GET['salutation']; 
$Street= $_GET['street']; 
$State= $_GET['state']; 
$Zip= $_GET['zip']; 
$Country= $_GET['country']; 
$Description= $_GET['description'];
$Rating= $_GET['rating'];
$SEmail= $_GET['semail'];
$Title= $_GET['title'];

ignore_user_abort(true);

// turn off gzip compression
if ( function_exists( 'apache_setenv' ) ) {
  apache_setenv( 'no-gzip', 1 );
}

ini_set('zlib.output_compression', 0);

// turn on output buffering if necessary
if (ob_get_level() == 0) {
  ob_start();
}

// removing any content encoding like gzip etc.
header('Content-encoding: none', true);

// Create XML
$xml = "
    <Leads>
        <row no=\"1\">
        <FL val=\"Company\">".$Company."</FL>
        <FL val=\"Last Name\">".$LN."</FL>
        <FL val=\"First Name\">".$FN."</FL>
        <FL val=\"Email\">".$Email."</FL>
        <FL val=\"Phone\">".$Phone."</FL>
        <FL val=\"Lead Source\">".$Source."</FL>
        <FL val=\"Website\">".$Website."</FL>
        <FL val=\"City\">".$City."</FL>
        <FL val=\"Industry\">".$Industry."</FL>
        <FL val=\"Lead Owner\">". $Lead_owner ."</FL>
        <FL val=\"Designation\">". $Designation ."</FL>
        <FL val=\"Fax\">". $Fax ."</FL>
        <FL val=\"Mobile\">". $Mobile ."</FL>
        <FL val=\"Lead Status\">". $Lead_statut ."</FL>
        <FL val=\"No of Employees\">". $Employees ."</FL>
        <FL val=\"Annual Revenue\">". $Annual_Revenue ."</FL>
        <FL val=\"Email Opt Out\">". $Email_Opt_Out ."</FL>
        <FL val=\"Skype ID\">". $Skype ."</FL>
        <FL val=\"Salutation\">". $Salutation ."</FL>
        <FL val=\"Street\">". $Street ."</FL>
        <FL val=\"State\">". $State ."</FL>
        <FL val=\"Zip Code\">". $Zip ."</FL>
        <FL val=\"Country\">". $Country ."</FL>
        <FL val=\"Description\">". $Description ."</FL>
        <FL val=\"Rating\">". $Rating ."</FL>
        <FL val=\"Secondary Email\">".$SEmail."</FL>
        <FL val=\"Title\">".$Title."</FL>
        
        </row>
    </Leads>
";


$result = insert($auth,$xml);

//print_r($result);

    //Begin the header output
    header( 'Content-Type: image/png' );
 //Now actually output the image requested, while disregarding if the database was affected
    header( 'Pragma: public' );
    header( 'Expires: 0' );
    header( 'Cache-Control: must-revalidate, post-check=0, pre-check=0' );
    header( 'Cache-Control: private',false );
    header( 'Content-Disposition: attachment; filename="blank.png"' );
    header( 'Content-Transfer-Encoding: binary' );

    die("\x89\x50\x4e\x47\x0d\x0a\x1a\x0a\x00\x00\x00\x0d\x49\x48\x44\x52\x00\x00\x00\x01\x00\x00\x00\x01\x01\x03\x00\x00\x00\x25\xdb\x56\xca\x00\x00\x00\x03\x50\x4c\x54\x45\x00\x00\x00\xa7\x7a\x3d\xda\x00\x00\x00\x01\x74\x52\x4e\x53\x00\x40\xe6\xd8\x66\x00\x00\x00\x0a\x49\x44\x41\x54\x08\xd7\x63\x60\x00\x00\x00\x02\x00\x01\xe2\x21\xbc\x33\x00\x00\x00\x00\x49\x45\x4e\x44\xae\x42\x60\x82");
    
    //All done, get out!
    exit;

function insert($auth,$xml)
{
    $curl_url = "https://crm.zoho.com/crm/private/xml/Leads/insertRecords";
    $curl_post_fields = "authtoken=". $auth ."&wfTrigger=false&duplicateCheck=1&scope=crmapi&xmlData=". $xml ."";
    $ch = curl_init();
    curl_setopt($ch,CURLOPT_URL, $curl_url);
    curl_setopt($ch,CURLOPT_FOLLOWLOCATION, true);
    curl_setopt($ch,CURLOPT_TIMEOUT, 60);
    curl_setopt($ch,CURLOPT_POST,1);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, true);
    curl_setopt($ch,CURLOPT_POSTFIELDS, $curl_post_fields);
    $response = curl_exec($ch);
    curl_close($ch);
    return $response;
}


// flush all output buffers. No reason to make the user wait for OWA.
ob_flush();
flush();
ob_end_flush();
?>
