<?php
/*
 * These frontend controllers require the user to be logged in
 * All route names are prefixed with 'frontend.'
 */
Route::group(['namespace' => 'Family'], function () {
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
    Route::any('family/verifymember/{id}', 'FamilyController@verifyMember')->name('family.verifymember');
    Route::any('family/unverifymember/{id}', 'FamilyController@unVerifyMember')->name('family.unverifymember');
});