<?php

namespace App\Http\Responses\Backend\Family;

use Illuminate\Contracts\Support\Responsable;

class EditResponse implements Responsable
{
    protected $family;

    protected $cityListArray;

    protected $areaListArray;

    protected $isMainMember;

    protected $mainMemberArray;

    public function __construct($family, $cityListArray, $areaListArray, $isMainMember, $mainMemberArray)
    {
        $this->family = $family;
        $this->cityListArray = $cityListArray;
        $this->areaListArray = $areaListArray;
        $this->isMainMember = $isMainMember;
        $this->mainMemberArray = $mainMemberArray;
    }

    public function toResponse($request)
    {
        return view('backend.family.edit')->with([
            'family'       => $this->family,
            'areaList'     => $this->areaListArray,
            'cityList'     => $this->cityListArray,
            'isMainMember' => $this->isMainMember,
            'mainMemberArray' => $this->mainMemberArray,
        ]);
    }
}
