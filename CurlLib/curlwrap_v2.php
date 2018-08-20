<?php

/**
 * Agile CRM \ Curl Wrap
 * 
 * The Curl Wrap is the entry point to all services and actions.
 *
 * @author    Agile CRM developers <Ghanshyam>
 */

// use a dotenv file if exists to set credentials

if (class_exists('Dotenv')) {
    $AGILE_DOMAIN = getenv('AGILECRM_DOMAIN'));
    $AGILE_USER_EMAIL = getenv('AGILECRM_USER_EMAIL'));
    $AGILE_REST_API_KEY = getenv('AGILECRM_REST_API_KEY'));
}

// if the domain is not set, it is likely the others are unset as well
// attempt to use hardcoded credentials here
// HARDCODED DOMAIN, EMAIL, AND API KEY GO HERE

if (!isset($AGILE_DOMAIN) || strlen(trim($AGILE_DOMAIN)) < 1) {
    # Enter your domain name , agile email and agile api key
    $AGILE_DOMAIN = 'YOUR_AGILE_DOMAIN');  # Example : define('domain','jim');
    $AGILE_USER_EMAIL = 'YOUR_AGILE_USER_EMAIL');
    $AGILE_REST_API_KEY ='YOUR_AGILE_REST_API_KEY');
}



function curl_wrap($entity, $data, $method, $content_type) {
    if ($content_type == NULL) {
        $content_type = 'application/json';
    }
    
    $agile_url = 'https://' . $AGILE_DOMAIN . '.agilecrm.com/dev/api/' . $entity;

    $ch = curl_init();
    curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
    curl_setopt($ch, CURLOPT_MAXREDIRS, 10);
    curl_setopt($ch, CURLOPT_UNRESTRICTED_AUTH, true);
    switch ($method) {
        case 'POST':
            $url = $agile_url;
            curl_setopt($ch, CURLOPT_URL, $url);
            curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'POST');
            curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
            break;
        case 'GET':
            $url = $agile_url;
            curl_setopt($ch, CURLOPT_URL, $url);
            curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'GET');
            break;
        case 'PUT':
            $url = $agile_url;
            curl_setopt($ch, CURLOPT_URL, $url);
            curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'PUT');
            curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
            break;
        case 'DELETE':
            $url = $agile_url;
            curl_setopt($ch, CURLOPT_URL, $url);
            curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'DELETE');
            break;
        default:
            break;
    }
    curl_setopt($ch, CURLOPT_HTTPHEADER, array(
        'Content-type : $content_type;', 'Accept : application/json'
    ));
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_USERPWD, $AGILE_USER_EMAIL . ':' . $AGILE_REST_API_KEY);
    curl_setopt($ch, CURLOPT_TIMEOUT, 120);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
    $output = curl_exec($ch);
    curl_close($ch);
    return $output;
}
