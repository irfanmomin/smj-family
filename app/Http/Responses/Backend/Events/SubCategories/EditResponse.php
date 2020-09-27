<?php

namespace App\Http\Responses\Backend\Events\SubCategories;

use Illuminate\Contracts\Support\Responsable;

class EditResponse implements Responsable
{
    protected $subcategory;

    protected $mainEventCategoriesList;

    protected $getEventGroupsList;

    public function __construct($subcategory, $mainEventCategoriesList, $getEventGroupsList)
    {
        $this->subcategory             = $subcategory;
        $this->getEventGroupsList      = $getEventGroupsList;
        $this->mainEventCategoriesList = $mainEventCategoriesList;
    }

    public function toResponse($request)
    {
        return view('backend.events.subcategories.edit')->with([
            'subcategory'             => $this->subcategory,
            'getEventGroupsList'      => $this->getEventGroupsList,
            'mainEventCategoriesList' => $this->mainEventCategoriesList,
        ]);
    }
}
