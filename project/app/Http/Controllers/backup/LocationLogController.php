<?php

namespace App\Http\Controllers;

use App\Service\XMLDBSyncService;
use App\Model\Team;

use Illuminate\Http\Request;

use App\Http\Requests;

class LocationLogController extends Controller
{
    public function getInput(){
    	$filename = base_path()."/upload/xml/Wi-Fiアクセスログ.xml";
    	$xml_string = implode("", file($filename));
    	
		$xmlSrv = new XMLDBSyncService();
  		$xmlContent = $xmlSrv->sync($xml_string);

    }
}
