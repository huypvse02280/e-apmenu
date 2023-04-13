<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
//use Illuminate\Http\Request;
use Request;

use App\Service\XMLDBSyncService;
use App\Service\CSVDBSyncService;
use App\Http\Requests\UploadXMLRequest;
use App\Http\Requests\UploadCSVRequest;
use App\Model\LocationLog;
use Carbon\Carbon;

class UploadController extends Controller
{
    public function getXml() {
        $userCurrent = Auth::user()->role_id;
        if ($userCurrent != 1) {
            return redirect()->back()->with(['flash_level' => 'alert alert-danger', 'flash_message' => 'アップロードする権利はありません']);
        }

        $xmlSrv = new XMLDBSyncService();
        
        $limit = isset($_GET['limit']) ? $_GET['limit'] : null;
        $lastTime = $xmlSrv->lastTimeSynced();
        $synced = '';
        if ($lastTime) {
            $synced = $xmlSrv->lastDataSynced($limit, $lastTime->create_time);
            $agoTime = $lastTime->create_time->diffForHumans();

        }
        
        return view('admin.upload.xml', compact('synced', 'lastTime', 'agoTime'));

    }

    public function postXml(UploadXMLRequest $request) {
        $folder = "upload/xml/";
        if (Request::file('xml_file')) {
            $file = Request::file('xml_file');
            $file_name = $file->getClientOriginalName();
            $file->move($folder,$file_name);

            $filename = $folder.$file_name;
            $xml_string = implode("", file($filename));

            if (strpos($xml_string, '?xml') != false  && strpos($xml_string, 'version="1.0"') != false  && strpos($xml_string, 'encoding="UTF-8"') != false ) {
                $xmlSrv = new XMLDBSyncService();
                $beforeSync = $xmlSrv->lastDataSynced()->total(); 
                $xmlSrv->sync($xml_string);
                $afterSync = $xmlSrv->lastDataSynced()->total(); 
                $lastTimeSynced = $xmlSrv->lastTimeSynced();

                // last time - current time > 3p => synced results = 0
                if (!is_empty($afterSync) && !is_empty($beforeSync) && $afterSync > $beforeSync) {
                    $flash_message = 'アップしました。'.($afterSync - $beforeSync).'個を追加しました。';
                }else {
                    $flash_message = 'アップしました。0個を追加しました。';
                }
                
                return redirect()->route('admin.pias.upload.getXml')->with(['flash_level' => 'alert alert-info', 'flash_message' => isset($flash_message) ? $flash_message : null]);

            }  
            else {
                return redirect()->route('admin.pias.upload.getXml')->with(['flash_level' => 'alert alert-danger', 'flash_message' => '不正な形式です。']);
            }
           
        }
    }

    public function getCsv() {
        $csvSrv = new CSVDBSyncService();
        $limit = isset($_GET['limit']) ? $_GET['limit'] : null;
        $lastTime = $csvSrv->lastTimeSynced();
        $synced = '';
        if ($lastTime) {
            $agoTime = $lastTime->created_at->diffForHumans();
            $synced = $csvSrv->lastDataSynced($limit, $lastTime->created_at);
        }
        return view('admin.upload.csv', compact('synced', 'lastTime', 'agoTime'));
    }

    public function postCsv(UploadCSVRequest $request) {
        //$path = "upload/csv/mailPiasNotepade222.csv";
        $folder = "upload/csv/";
        if (Request::file('csv_file')) {
            $file = Request::file('csv_file');
            $file_name = $file->getClientOriginalName();
            $file->move($folder, $file_name);

            $path = $folder.$file_name;
            $csvSrv = new CSVDBSyncService();
            $beforeSync = $csvSrv->lastDataSynced()->total(); //die;
            $csvSrv->sync($path);
            $afterSync = $csvSrv->lastDataSynced()->total(); //die;

            if (!is_empty($afterSync) && !is_empty($beforeSync) && $afterSync > $beforeSync) {
                $flash_message = 'アップしました。'.($afterSync - $beforeSync).'個を追加しました。'; 
            }else {
                $flash_message = 'アップしました。0個を追加しました。';
            }
            return redirect()->route('admin.pias.upload.getCsv')->with(['flash_level' => 'alert alert-info', 'flash_message' => isset($flash_message) ? $flash_message : null]);
        }
    }


}
