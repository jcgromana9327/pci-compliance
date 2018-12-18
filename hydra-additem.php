<?php

$items = [
	'replacementrepo282101atpitmanarm',
	'replacementrepo282101atpitmanarm',
	'replacementrepo282101atpitmanarm',
	'replacementrepo282101atpitmanarm',
	'replacementrepo282101inner',
	'replacementrepo282101passengerside',
	'replacementrepo282101-',
	'replacementrepg541301rear',
	'replacementrepc545302-',
	'replacementrepc545302driverside',
	'replacementrepc502504-',
	'replacementrepd401102-',
	'replacementrepf380801intakeorexhaust',
	'dashdesignsdshk245011tchfrontrow',
	'dashdesignsdshk0602406bkfrontrow',
	'dashdesignsdshk213010actfrontrow',
	'dashdesignsdshk0203906bkfrontrow',
	'dashdesignsdshk0204j06cbfrontrow',
	'dashdesignsdshk0206h06bkfrontrow',
	'dashdesignsdshk020k20ochfrontrow',
	'dashdesignsdshk0356306bkfrontrow',
	'dashdesignsdshk0510706chfrontrow',
	'dashdesignsdshk0531506cbfrontrow',
	'replacement20-1668-00passengerside',
	'replacement20-1669-00driverside',
	'replacement20-3520-80driverside',
	'replacement20-3519-80passengerside',
	'replacementc100146driverside',
	'replacementc100145passengerside',
	'replacement20-5500-00driverside',
	'replacement20-5499-00passengerside',
	'replacementrepch100101passengerside',
	'replacement3321181lasdriverside',
	'replacementrepb501511upper',
	'replacementrepb501505upper',
	'replacementrepb501503lower',
	'replacementrepb501502upper',
	'replacementrepb501504upper',
	'replacementrepb501506lower',
	'replacementrepb501507lower',
	'replacementrepb501508upper',
	'replacementrepb501509lower',
	'replacementkit1-012617-01-cupperandlower',
	'powerstopp15l4729front,driverside',
	'powerstopp15l4729rear,driverside',
	'powerstopp15l4728rear,passengerside',
	'powerstopp15l4728front,passengerside',
	'powerstopp15l4339front,passengerside',
	'powerstopp15s4299front,driverandpassengerside',
	'powerstopp15l4759front,driverside',
	'powerstopp15l4340front,driverside',
	'powerstopp15l4758front,passengerside',
	'powerstopp15l4757front,driverside',
	'universalkleinnhornskle6260-',
	'universalsmittybiltsmt2780-',
	'universalsmittybiltsmt2781-',
	'universalkleinnhornskle6120-',
	'universalkleinnhornskle6270-',
	'universalkleinnhornskle6275-',
	'universalkleinnhornskle6350-',
	'universalkleinnhornskle6450-',
	'universalkleinnhornskledd1-',
	'universalkleinnhornskle6260-',
	'universalpapagopg8s10dus-',
	'visionxvsxhil-dg-',
	'visionxvsxhil-slb-',
	'visionxvsxhil-dlf3r-',
	'visionxvsxhil-dr-',
	'visionxvsxhil-slg-',
	'visionxvsxhil-slr-',
	'visionxvsxhil-slw-',
	'universalkchilitesk131350-',
	'universalkchilitesk131351-',
	'universalkchilitesk131352-',
	'replacementreph670114-',
	'replacementarbf670111-',
	'replacementrept670112-',
	'replacementarbc670111-',
	'replacementrepf670107-',
	'replacementrepc670156-',
	'replacementc670162-',
	'replacementarbc670115-',
	'replacementarbf670119-',
	'replacementarbf670107-',
	'professionalpartsswedenw0133-1720301rear',
	'professionalpartsswedenw0133-1982891driverside',
	'professionalpartsswedenw0133-1982891-',
	'professionalpartsswedenw0133-2205034rear',
	'oesgenuinew0133-1629951upper',
	'oesgenuinew0133-1632425upper',
	'oesgenuinew0133-1632531upper',
	'oesgenuinew0133-1632863lower',
	'oesgenuinew0133-1637390lower',
	'hjsw0133-1847289frontorrear',
	'replacementp2370-',
	'replacementp2795-',
	'replacementp2988-',
	'replacementp1909-',
	'replacementp2423-',
	'replacementp2481-',
	'replacementp2173-',
	'replacementp2354-',
	'replacementp1826-',
	'replacementp2578-',
	'shiftpointetet280884-',
	'shiftpointetet415502-',
	'shiftpointetet160502-',
	'shiftpointetet163014-',
	'shiftpointetet151004-',

];

// $('#formbasket  div  ul > li:not(.cpp)').length

$order_id = '30125968';

$ctr = 0;

foreach ($items as $product_id) {

	$url = 'http://platform2.hydra.staging.usautoparts.com/v5.0/Order/'.$order_id.'/?op=insertItem&data={"order":{"coupon_option":"","user_id":""},"order_items":{"qty":"1","p_id":"'.$product_id.'","site":"autopartswarehouse.com","isEndeca":"","item_warranty_amount":"0","item_warranty_code":"0","http_referer":"https%3A%2F%2Fapw-prueca.usautoparts.com%2F"},"include_get":true,"overrides":{"price_level":"price","shipping_level":"shipping","handling_level":"handling","use_dynamic_shipping":"1","dsc_version":"2","free_shipping":"1","catalog_type":"Auto","catalog_source":"Endeca","coupon_option":"","restrictedZipCode":"1","apo_fpo":"1","po_box":"1","manager_channel_id":"1"}}';

	try {
	    $ch = curl_init($url);
	    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
	    $result = curl_exec($ch);
	    echo "\r".++$ctr;

	    if ($result === false) {
	    	throw new Exception(curl_error($ch), curl_errno($ch));
	    }

	} catch(Exception $e) {
	    echo $e->getCode().': '.$e->getMessage().PHP_EOL;
	    exit;
	}
}
