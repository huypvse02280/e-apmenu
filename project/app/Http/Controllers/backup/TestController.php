<?php

namespace App\Http\Controllers;

use App\Test;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Requests\TestRequest;
use App\Service\XMLDBSyncService;
use App\Http\Controllers\Controller;
use App\Model\UserModel;
use App\Model\TeamModel;

class TestController extends Controller
{
	public function manyTeam() {
		//$user = TeamModel::find(1)->user()->orderBy('id', 'ASC')->get();
		//$user = TeamModel::find(1)->user()->detach(5); // xóa đi record là user id =5 và team = 1 đã thêm 
		//$user = TeamModel::find(1)->user()->attach(5); // thêm vào  user = 5 ở table  team có id = 1 
		$team = UserModel::find(1);
		//$team->user()->sync([1,2,3]);
		//$team->user()->attach(2, ['color' => '#000', 'address' => 'VNN']);
		foreach ($team->team as $key => $value) {
			echo $value->email.'<br>';
		}
		dd($team->team);
	}

	public function index() {
		return view('test.index');
	}

    public function index2(){
    	echo 'Đây là trang test <br />';
    	$myXMLData = 
			'<WirelessClientLocation historyLogReason="NETWORK_STATUS_CHANGE" confidenceFactor="56.0" currentlyTracked="true" macAddress="bc:5c:4c:31:ae:8f" isGuestUser="false">


			<MapInfo floorRefId="-4564257338822754054" mapHierarchyString="KAGAYA-Group>KAGAYA>KAGAYA-01F">

			<Dimension unit="FEET" offsetY="0.0" offsetX="0.0" height="9.84252" width="546.916" length="385.82678"/>

			<Image imageName="domain_0_1444386830190.png"/>

			</MapInfo>

			<MapCoordinate unit="FEET" y="319.7" x="178.91"/>

			<Statistics lastLocatedTime="2016-05-10T08:30:23.168+0900" firstLocatedTime="2016-05-10T04:58:54.029+0900" currentServerTime="2016-05-10T10:33:41.903+0900"/>

			</WirelessClientLocation>';

		$xml_1=simplexml_load_string($myXMLData) or die("Error: Cannot create object");
		echo '<pre>';
		print_r($xml_1->MapInfo->Dimension['unit']);
		echo '</pre>';
//
		$xml_2=simplexml_load_string(
			'<?xml version="1.0" encoding="UTF-8"?>
			<note>
			  <to>Tove</to>
			  <from>Jani</from>
			  <heading>Reminder</heading>
			  <body>Don"t forget me this weekend!</body>
			</note>') or die("Error: Cannot create object");
		echo '<pre>';
		print_r($xml_2);
		echo '</pre>';
		// dd(get_defined_constants());
		//dd(base_path()."/public/xml/test.xml");
//
		$xml_3 = simplexml_load_file(base_path()."/public/xml/test.xml");
		echo '<pre>';
		print_r($xml_3);
		echo '</pre>';
//
		$xml = \XmlParser::load(base_path()."/public/xml/test.xml");
		//dd($xml);
		echo '<pre>';
		print_r($xml);
		echo '</pre>';
		return view('test.index');
    }

    public function testXml(){
  //   	if(\DB::connection()->getDatabaseName())
		// {
		//    echo "Yes! successfully connected to the DB: " . \DB::connection()->getDatabaseName();
		// }
		// die;
    	$xmlLoad = simplexml_load_file(base_path()."/public/xml/pias.xml");

    	$xmlSrv = new XMLDBSyncService();
    	$xmlContent = $xmlSrv->sync($xmlLoad);
    	//return redirect()->route('app.testXml')->with(['flash_level'=>'success','flash_message'=>'Thêm mới thành công']);
  		//echo '<pre>';
		// print_r($xmlContent);
		// echo '</pre>';
		
		// // locations :
		// $locationsInfo['nextResourceURI'] = $xmlContent['nextResourceURI'];
		// $locationsInfo['pageSize'] = $xmlContent['pageSize'];
		// $locationsInfo['currentPage'] = $xmlContent['currentPage'];
		// $locationsInfo['totalPages'] = $xmlContent['totalPages'];

		// $arrInfo = [];

		// foreach ($xmlContent->WirelessClientLocation as $key => $val) {

		// 	// wireless location :
		// 	$historyLogReason = $val['WirelessClientLocation'];
		// 	$confidenceFactor = $val['confidenceFactor'];
		// 	$currentlyTracked = $val['currentlyTracked'];
		// 	$macAddress 	  = $val['macAddress'];
		// 	$isGuestUser      = $val['isGuestUser'];
		// 	// map info :
		// 	$floorRefId = $val->MapInfo['floorRefId'];
		// 	$mapHierarchyString = $val->MapInfo['mapHierarchyString'];

		// 	// dimension :
		// 	$unit_Dimension = $val->MapInfo->Dimension['unit'];
		// 	$offsetY = $val->MapInfo->Dimension['offsetY'];
		// 	$offsetX = $val->MapInfo->Dimension['offsetX'];
		// 	$height = $val->MapInfo->Dimension['height'];
		// 	$width = $val->MapInfo->Dimension['width'];
		// 	$length = $val->MapInfo->Dimension['length'];
		// 	// image :
		// 	$imageName = $val->MapInfo->Image['imageName'];

		// 	//MapCoordinate :
		// 	$unit_MapCoordinate = $val->MapCoordinate['unit'];
		// 	$y_MapCoordinate = $val->MapCoordinate['y'];
		// 	$x_MapCoordinate = $val->MapCoordinate['x'];
		// 	//Statistics :
		// 	$lastLocatedTime = $val->Statistics['lastLocatedTime'];
		// 	$firstLocatedTime = $val->Statistics['firstLocatedTime'];
		// 	$currentServerTime = $val->Statistics['currentServerTime'];
			
		// 	$arrInfo['historyLogReason'] = $historyLogReason;
		// 	$arrInfo['confidenceFactor'] = $confidenceFactor;
		// 	$arrInfo['currentlyTracked'] = $currentlyTracked;
		// 	$arrInfo['macAddress'] = $macAddress;
		// 	$arrInfo['isGuestUser'] = $isGuestUser;
		// 	$arrInfo['floorRefId'] = $floorRefId;
		// 	$arrInfo['mapHierarchyString'] = $mapHierarchyString;
		// 	$arrInfo['unit_Dimension'] = $unit_Dimension;
		// 	$arrInfo['offsetY'] = $offsetY;
		// 	$arrInfo['offsetX'] = $offsetX;
		// 	$arrInfo['height'] = $height;
		// 	$arrInfo['width'] = $width;
		// 	$arrInfo['length'] = $length;
		// 	$arrInfo['imageName'] = $imageName;
		// 	$arrInfo['unit_MapCoordinate'] = $unit_MapCoordinate;
		// 	$arrInfo['y_MapCoordinate'] = $y_MapCoordinate;
		// 	$arrInfo['x_MapCoordinate'] = $x_MapCoordinate;
		// 	$arrInfo['lastLocatedTime'] = $lastLocatedTime;
		// 	$arrInfo['firstLocatedTime'] = $firstLocatedTime;
		// 	$arrInfo['currentServerTime'] = $currentServerTime;

		// print_r(count($val));
		// // Mang cac thong tin lay ra :
		// echo '<pre>';
		// print_r($arrInfo);
		// echo '</pre>';
		// }// end foreach $xmlContent

		// $test = Test::select('historyLogReason','confidenceFactor','currentlyTracked','macAddress')->get()->toArray();
		// echo '<pre>';
		// print_r($test);
		// echo '</pre>';
		return view('test.testXml');
		
    }

    public function success(){
    	$str = "IT's \"good\"";
    	echo addslashes($str);

    	$emp_name = addslashes ('POST[\'emp_name\']');
		$emp_address = addslashes ('POST[\'emp_name\']'); // in nguyên cả chuỗi .
		echo $emp_address;echo '<br>';

		$foo = 'bar';
		echo '$foo\'' . "$foo\'";echo '<br>';

		$str = 'val1,val2,,val4,';
		echo count(explode(',', $str)); echo '<br>';
// break ; dừng khi điều kiện đúng .
// continue ; bỏ qua thực thi khi điều đúng .

// Mảng :
	// sort() : sắp tăng dần theo value , key thay đổi .(ngược lại giảm dần là rsort())
	// asort() : sắp tăng dần theo value , key giữ nguyên .(ngược lại giảm dần là arsort())
	// ksort() : sắp tăng theo key .(ngược lại là krsort() , ko có kasort() vì đang sắp theo key rồi .)
	// nasort() hoặc nacasesort() : sắp tăng theo value (xử lý với value có tên chuỗi và số )

	// array_merge() : gộp 2 mảng lại , nếu có key trùng nhau -> value ở mảng 2 được gán cho value của key tương ứng ở mảng 1.
	// array_combine() : nhận vào 2 mảng cùng số phần tử : key của mảng là value mảng 1 , giá trị phần tử mảng là value mảng 2 .
	// array_intersect() : lấy vào 2 mảng và trả về phần tử chung , key là key của mảng 1 .
	// array_search() : tìm kiếm phần tử trong mảng .
	// strrchr() : tìm kiếm và lấy ra một chuỗi từ vị trí đó đến cuối chuỗi .
	// substr() : cắt 1 chuỗi xác định từ vị trí cắt và số phần tử cắt 
	// str_len() : đếm ký tự trong 1 chuỗi .
	// str_replace() : tìm ký tự hoặc chuỗi thay thế bởi 1 chuỗi , ký tự khác . Kết quả là 1 chuỗi mới , chuỗi cũ vẫn giữ nguyên .
	// implode() : ghép các ptu của mảng thành chuỗi .
	// explode() : cắt 1 chuỗi thành mảng .
	// array_slice() : lấy ra 1 mảng có số phần tử xác định từ vị trí cắt xác định

		$x =25;
		while($x<10){
			$x--;
		}
		printf($x);echo '<br>';

		switch (1) {
			case 1:printf('val1');//break;
			case 2:printf('val2');//break;
			case 3:printf('val3');//break;
			case 4:printf('val4');//break;

			
			default:printf('default');break;
		}
		echo '<br>';
		
		echo '<br>';

		$str_abc = 'toi muon cat chuoi nay';
		$arr_abc = array('toi','muon','cat','chuoi','nay');
		echo substr($str_abc, 4);
		print_r(array_slice($arr_abc, 1,-3)) ;


		echo '<br>';
	//chuyển đổi tất cả các chữ cái trong chuỗi thành chữ hoa  
		print(strtoupper("strtoupper - chuyen chu thuong thanh in hoa."))."<br>";  
		//chuyển đổi tất cả các chữ cái trong chuỗi thành chữ thường 
		print(strtolower("strtolower - CHUYEN CHU IN HOA THANH CHU THUONG."))."<br>";  
		//chuyển đổi chữ cái đầu tiên của chuỗi thành chữ hoa 
		print(ucfirst("ucfirst - chuyển đổi chữ cái đầu tiên của chuỗi thành chữ hoa."))."<br>";  
		//chuyển đổi chữ cái đầu tiên của tất cả các từ trong chuỗi thành chữ hoa
		print(ucwords("ucwords - chuyển đổi chữ cái đầu tiên của tất cả các từ trong chuỗi thành chữ hoa."))."<br>";
		echo '<br>';

    	return view('test.success');
    }

    public function getAdd(){
    	// print_r(url('/test'));
    	return view('test.add');
    }
    public function postAdd(TestRequest $request){
    	if ($request->isMethod('post')) {
    		echo 'post<br>';
    		echo $request->input('name').'<br />';
    		print_r($request->all());
    	}else{
    		echo 'get';
    	}
    	echo '<br />';
    	echo 'method: '.$request->method();
    }
}
