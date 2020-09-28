<?php
/*
 * These frontend controllers require the user to be logged in
 * All route names are prefixed with 'frontend.'
 */
Route::group(['namespace' => 'Family', 'middleware' => ['admin', 'activeuser']], function () {
    // All Family View - add - edit
    Route::resource('family', 'FamilyController')->except(['show']);
    //For Datatable
    Route::post('family/get', 'FamilyTableController')->name('family.get');

    // All Members List Routes
    Route::get('family/allmemberslist', 'FamilyController@allMembersListIndex')->name('family.allmemberslist');
    //For Datatable - All Members List
    Route::post('allmemberslist/get', 'AllMembersTableController')->name('allmembers.get');

    // Get Area List route from City Route
    Route::get('family/getarealist', 'FamilyController@getAreaListAjax')->name('family.getarealist');

    // Edit Family Details Page Route
    Route::get('family/editfamily/{id}', 'FamilyController@editFamilyDetails')->name('family.editfamily');

    // Delete Full Family Route
    Route::any('family/deletefullfamily/{id}', 'FamilyController@deleteFullFamily')->name('family.deletefullfamily');

    // Verify Family Member
    Route::any('family/verifymember/{id}', 'FamilyController@verifyMember')->name('family.verifymember');

    // Un-Verify Family Member
    Route::any('family/unverifymember/{id}', 'FamilyController@unVerifyMember')->name('family.unverifymember');

    // Main Member Expired Route
    Route::get('family/mainmemberexpired/{id}', 'FamilyController@mainMemberExpired')->name('family.mainmemberexpired');

    Route::post('family/mainmemberexpired/storenewrelation', 'FamilyController@storeNewRelationAndDelete')->name('family.storenewrelation');

    // Member Expired Route
    Route::post('family/mainmemberexpired/storememberexpired', 'FamilyController@storeMemberExpired')->name('family.storememberexpired');

    Route::get('family/creditpaymentmodal/{memberid}', 'FamilyController@creditPaymentModal')->name('family.addpaymentmodal');
});

Route::group(['namespace' => 'Events', 'middleware' => ['admin', 'activeuser']], function () {
    // Event Sub Categories - add - edit
    Route::resource('events/subcategories', 'CategoriesController',[
        'names' => 'eventsubcategories'
    ])->except(['show']);

    // Event Categories Routes
    Route::post('subcategoriesmanagement/get', 'CategoriesTableController')->name('subcategoriesmanagement.get');

    // Event Main Transaction - add - edit
    Route::resource('events/maintransactions', 'MainTransactionController',[
        'names' => 'maintransactions'
    ])->except(['show']);

    // Event Categories Routes
    Route::post('maintransactions/get', 'MainTransactionTableController')->name('maintransactions.get');

    // Get Area List route from City Route
    Route::get('maintransactions/getsubcategories', 'MainTransactionController@getSubCategoryList')->name('maintransactions.getsubcategorylist');

    Route::get('maintransactions/childtranslist/{id}', 'MainTransactionController@showChildTrans')->name('maintransactions.showchildtranslist');

    // Event Categories Routes
    Route::post('maintransactions/childtranslist/get', 'ChildTransactionListTableController')->name('childtranslist.get');

    // Delete Full Family Route
    Route::any('childtranslist/delete', 'MainTransactionController@deleteChildTransaction')->name('childtranslist.deletetrans');
    Route::any('childtranslist/deletecredited', 'MainTransactionController@deleteChildCreditedTransaction')->name('childtranslist.deletecreditedtrans');

    Route::any('childtranslist/creditpayment', 'MainTransactionController@creditPayment')->name('childtransactions.creditamount');
});