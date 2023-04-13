<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
         $this->call(WireLessSeeder::class);
    }
}


class LocationsXmlSeeder extends Seeder
{
	
	public function run(){
		DB::table('locationsXml')->insert([
			['historyLogReason' => 'NETWORK_STATUS_CHANGE','confidenceFactor' => '56.0','currentlyTracked' => '1', 'macAddress' => 'bc:5c:4c:31:ae:8f', 'isGuestUser' => '0', 'unit_Dimension' => 'FEET', 'offsetY' => '0.0' , 'offsetX' => '0.0' , 'height' => '9.84252', 'width' => '546.916' , 'length' => '385.82678', 'imageName' => 'domain_0_1444551474124.png', 'unit' => 'FEET', 'y_MapCoordinate' => '319.7', 'x_MapCoordinate' => '178.91','lastLocatedTime' => '2016-05-10 09:05:34', 'firstLocatedTime' => '2016-05-10 09:05:34', 'currentServerTime' => '2016-05-10 09:05:34'],
			['historyLogReason' => 'SECURITY_POLICY_CHANGE','confidenceFactor' => '752.0','currentlyTracked' => '1', 'macAddress' => 'e0:9d:31:54:40:98', 'isGuestUser' => '1', 'unit_Dimension' => 'FEET', 'offsetY' => '0.0' , 'offsetX' => '0.0' , 'height' => '9.84252', 'width' => '546.916' , 'length' => '385.82678' , 'imageName' => 'domain_0_1444386830190.png', 'unit' => 'FEET', 'y_MapCoordinate' => '170.21', 'x_MapCoordinate' => '437.72','lastLocatedTime' => '2016-05-10 09:05:34', 'firstLocatedTime' => '2016-05-10 09:05:34', 'currentServerTime' => '2016-05-10 09:05:34'],
			['historyLogReason' => 'NETWORK_STATUS_CHANGE','confidenceFactor' => '752.0','currentlyTracked' => '1', 'macAddress' => 'bc:5c:4c:31:ae:8f', 'isGuestUser' => '1', 'unit_Dimension' => 'FEET', 'offsetY' => '0.0' , 'offsetX' => '0.0' , 'height' => '9.84252', 'width' => '546.916' , 'length' => '385.82678', 'imageName' => 'domain_0_1444555684611.png', 'unit' => 'FEET', 'y_MapCoordinate' => '239.31', 'x_MapCoordinate' => '238.2','lastLocatedTime' => '2016-05-10 09:05:34', 'firstLocatedTime' => '2016-05-10 09:05:34', 'currentServerTime' => '2016-05-10 09:05:34'],
			['historyLogReason' => 'SECURITY_POLICY_CHANGE','confidenceFactor' => '56.0','currentlyTracked' => '1', 'macAddress' => 'e0:9d:31:54:40:98', 'isGuestUser' => '0', 'unit_Dimension' => 'FEET', 'offsetY' => '0.0' , 'offsetX' => '0.0' , 'height' => '9.84252', 'width' => '546.916' , 'length' => '385.82678', 'imageName' => 'domain_0_1444551474124.png', 'unit' => 'FEET', 'y_MapCoordinate' => '319.7', 'x_MapCoordinate' => '313.98','lastLocatedTime' => '2016-05-10 09:05:34', 'firstLocatedTime' => '2016-05-10 09:05:34', 'currentServerTime' => '2016-05-10 09:05:34'],
			['historyLogReason' => 'FLOOR_CHANGE','confidenceFactor' => '752.0','currentlyTracked' => '1', 'macAddress' => '84:89:ad:b0:9b:6d', 'isGuestUser' => '0', 'unit_Dimension' => 'FEET', 'offsetY' => '0.0' , 'offsetX' => '0.0' , 'height' => '9.84252', 'width' => '546.916' , 'length' => '385.82678' ,' imageName' => 'domain_0_1444551474124.png', 'unit' => 'FEET', 'y_MapCoordinate' => '181.17', 'x_MapCoordinate' => '178.91','lastLocatedTime' => '2016-05-10 09:05:34', 'firstLocatedTime' => '2016-05-10 09:05:34', 'currentServerTime' => '2016-05-10 09:05:34'],

			]);
	}
}
class WireLessSeeder extends Seeder
{
	
	public function run(){
		DB::table('wireless')->insert([
			['historyLogReason' => 'NETWORK_STATUS_CHANGE','confidenceFactor' => '56.0','currentlyTracked' => '1', 'macAddress' => 'bc:5c:4c:31:ae:8f', 'isGuestUser' => '0'],
			['historyLogReason' => 'SECURITY_POLICY_CHANGE','confidenceFactor' => '752.0','currentlyTracked' => '1', 'macAddress' => 'e0:9d:31:54:40:98', 'isGuestUser' => '1'],
			['historyLogReason' => 'NETWORK_STATUS_CHANGE','confidenceFactor' => '752.0','currentlyTracked' => '1', 'macAddress' => 'bc:5c:4c:31:ae:8f', 'isGuestUser' => '1'],
			['historyLogReason' => 'SECURITY_POLICY_CHANGE','confidenceFactor' => '56.0','currentlyTracked' => '1', 'macAddress' => 'e0:9d:31:54:40:98', 'isGuestUser' => '0'],
			['historyLogReason' => 'FLOOR_CHANGE','confidenceFactor' => '752.0','currentlyTracked' => '1', 'macAddress' => '84:89:ad:b0:9b:6d', 'isGuestUser' => '0'],

		]);
	}
}

class MapInfoSeeder extends Seeder
{
	public function run(){
		DB::table('mapinfo')->insert([
			['floorRefId' => '-4564257338822754054', 'wireless_id' => 1, 'mapHierarchyString' => 'KAGAYA-Group-KAGAYA-KAGAYA-01F'],
			['floorRefId' => '-4564257338822754020', 'wireless_id' => 2,'mapHierarchyString' => 'KAGAYA-Group-KAGAYA-KAGAYA-11F'],
			['floorRefId' => '-4564257338822754054', 'wireless_id' => 3, 'mapHierarchyString' => 'KAGAYA-Group-KAGAYA-KAGAYA-01F'],
			['floorRefId' => '-4564257338822754054', 'wireless_id' => 1,'mapHierarchyString' => 'KAGAYA-Group-KAGAYA-KAGAYA-03F'],
			['floorRefId' => '-4564257338822754054', 'wireless_id' => 4,'mapHierarchyString' => 'KAGAYA-Group-KAGAYA-KAGAYA-01F'],

			]);
	}
}


class MapCoordinateSeeder extends Seeder
{
	
	public function run(){
		DB::table('mapcoordinate')->insert([
			['unit' => 'FEET' ,'wireless_id' => 1, 'y' => '319.7' , 'x' => '178.91'],
			['unit' => 'FEET' ,'wireless_id' => 3, 'y' => '170.21' , 'x' => '437.72'],
			['unit' => 'FEET' ,'wireless_id' => 2, 'y' => '319.7' , 'x' => '313.98'],
			['unit' => 'FEET' ,'wireless_id' => 4, 'y' => '181.17' , 'x' => '178.91'],
			['unit' => 'FEET' ,'wireless_id' => 1, 'y' => '239.31' , 'x' => '238.2'],

			]);
	}
}


class ImageSeeder extends Seeder
{
	
	public function run(){
		DB::table('image')->insert([
			['imageName' => 'domain_0_1444551474124.png', 'mapinfo_id' => 1],
			['imageName' => 'domain_0_1444386830190.png', 'mapinfo_id' => 2],
			['imageName' => 'domain_0_1444555684611.png', 'mapinfo_id' => 3],
			['imageName' => 'domain_0_1444551474124.png', 'mapinfo_id' => 4],

			]);
	}
}

class StatisticsSeeder extends Seeder
{
	public function run(){
		DB::table('statistics')->insert([
			['wireless_id' => 1,'lastLocatedTime' => '2016-05-10 09:05:34', 'firstLocatedTime' => '2016-05-10 09:05:34', 'currentServerTime' => '2016-05-10 09:05:34'],
			['wireless_id' => 2,'lastLocatedTime' => '2016-05-10 09:05:34', 'firstLocatedTime' => '2016-05-10 09:05:34', 'currentServerTime' => '2016-05-10 09:05:34'],
			['wireless_id' => 4,'lastLocatedTime' => '2016-05-10 09:05:34', 'firstLocatedTime' => '2016-05-10 09:05:34', 'currentServerTime' => '2016-05-10 09:05:34'],
			['wireless_id' => 3,'lastLocatedTime' => '2016-05-10 09:05:34', 'firstLocatedTime' => '2016-05-10 09:05:34', 'currentServerTime' => '2016-05-10 09:05:34']
			]);
	}
}


class DimensionSeeder extends Seeder
{
	
	public function run(){
		DB::table('dimension')->insert([
			 ['mapinfo_id' => 1,'unit' => 'FEET', 'offsetY' => '0.0' , 'offsetX' => '0.0' , 'height' => '9.84252', 'width' => '546.916' , 'length' => '385.82678'],
			 ['mapinfo_id' => 2,'unit' => 'FEET', 'offsetY' => '0.0' , 'offsetX' => '0.0' , 'height' => '9.84252', 'width' => '546.916' , 'length' => '385.82678'],
			 ['mapinfo_id' => 3,'unit' => 'FEET', 'offsetY' => '0.0' , 'offsetX' => '0.0' , 'height' => '9.84252', 'width' => '546.916' , 'length' => '385.82678'],
			 ['mapinfo_id' => 4,'unit' => 'FEET', 'offsetY' => '0.0' , 'offsetX' => '0.0' , 'height' => '9.84252', 'width' => '546.916' , 'length' => '385.82678'],
			 ['mapinfo_id' => 1,'unit' => 'FEET', 'offsetY' => '0.0' , 'offsetX' => '0.0' , 'height' => '9.84252', 'width' => '546.916' , 'length' => '385.82678']
			]);
	}
}