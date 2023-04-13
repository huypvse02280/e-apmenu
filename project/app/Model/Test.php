<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Test extends Model
{
    protected $table = 'wireless';
    protected $fillable = ['id', 'historyLogReason', 'confidenceFactor', 'currentlyTracked', 'macAddress', 'isGuestUser'];

    // protected $table = 'locationsXml';


    // protected $fillable = ['historyLogReason','confidenceFactor','currentlyTracked','macAddress','isGuestUser','floorRefId','mapHierarchyString','unit_Dimension', 'offsetY', 'offsetX', 'height', 'width', 'length', 'imageName', 'unit_MapCoordinate','y_MapCoordinate', 'x_MapCoordinate', 'lastLocatedTime', 'firstLocatedTime', 'currentServerTime'];


    public $timestamps = false;
}
