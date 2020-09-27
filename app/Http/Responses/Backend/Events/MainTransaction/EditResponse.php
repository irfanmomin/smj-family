<?php

namespace App\Http\Responses\Backend\Events\MainTransaction;

use Illuminate\Contracts\Support\Responsable;

class EditResponse implements Responsable
{
    protected $maintransaction;

    protected $mainEventCategoriesList;

    protected $getEventGroupsList;

    public function __construct($maintransaction, $mainEventCategoriesList, $getEventGroupsList)
    {
        $this->maintransaction             = $maintransaction;
        $this->getEventGroupsList      = $getEventGroupsList;
        $this->mainEventCategoriesList = $mainEventCategoriesList;
    }

    public function toResponse($request)
    {
        return view('backend.events.subcategories.edit')->with([
            'maintransaction'             => $this->maintransaction,
            'getEventGroupsList'      => $this->getEventGroupsList,
            'mainEventCategoriesList' => $this->mainEventCategoriesList,
        ]);
    }
}
