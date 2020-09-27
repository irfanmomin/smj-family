<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Labels Language Lines
    |--------------------------------------------------------------------------
    |
    | The following language lines are used in labels throughout the system.
    | Regardless where it is placed, a label can be listed here so it is easily
    | found in a intuitive way.
    |
    */

    'general' => [
        'all'     => 'All',
        'yes'     => 'Yes',
        'no'      => 'No',
        'custom'  => 'Custom',
        'actions' => 'Actions',
        'active'  => 'Active',
        'buttons' => [
            'save'   => 'Save',
            'update' => 'Update',
        ],
        'hide'              => 'Hide',
        'inactive'          => 'Inactive',
        'none'              => 'None',
        'show'              => 'Show',
        'toggle_navigation' => 'Toggle Navigation',
    ],

    'backend' => [
        'events-subcategory' => [
            'management'        => 'All Event Sub Categories',
            'newmanagement'     => 'SMJ Family',
            'advance_search'    => 'Advanced Search FIlter',
            'verified'          => 'Verified',
            'unverified'        => 'Un-Verified',
            'close'             => 'Close',
            'category_id'       => 'Main Category',
            'event_group_id'    => 'Event Group',
            'sub_category_name' => 'Name',
            'new' => 'New Sub Category',
            'edit' => 'Edit Sub Category',
            'validation' => [
                'sub_category_name' => 'Sub Category Name',
                'category_id'       => 'Main Category',
                'event_group_id'    => 'Event Group',
                'sub_category_name_ph'    => 'Relief 2020',
                'receipt_no'    => 'Receipt Number',
                'notes'    => 'Notes',
            ],
            'table' => [
                'sub_category_name' => 'Name',
                'event_group_id'    => 'Event Group',
                'category_id'       => 'Main Category',
            ],
            'buttons' => [
                'create' => 'Create',
                'submit' => 'Submit'
            ],
        ],
        'childtranslist' => [
            'management'        => 'Child Transactions',
            'newmanagement'     => 'SMJ Family',
            'advance_search'    => 'Advanced Search FIlter',
            'verified'          => 'Verified',
            'unverified'        => 'Un-Verified',
            'close'             => 'Close',
            'category_id'       => 'Main Category',
            'event_group_id'    => 'Event Group',
            'sub_category_name' => 'Name',
            'new' => 'Create Main Transaction',
            'edit' => 'Edit Main Transaction',
            'validation' => [
                'category_id'          => 'Main Category',
                'event_group_id'       => 'Event Group',
                'sub_category_name_ph' => 'Relief 2020',
                'sub_category_id'      => 'Sub Category Name',
                'amount'               => 'Debit Amount',
                'amount_ph'            => 'Debit Amount',
                'event_group'            => 'Event Group',
            ],
            'table' => [
                'member_name'       => 'Memeber Name',
                'sub_category_name' => 'Sub Category Name',
                'amount'            => 'Amount',
                'created_at'        => 'Created At',
                'transaction_date'  => 'Transaction Date',
                'event_group_name'  => 'Event Group',
            ],
            'buttons' => [
                'create' => 'Create'
            ],
        ],
        'eventmaintrans' => [
            'management'        => 'Main Transactions',
            'newmanagement'     => 'SMJ Family',
            'advance_search'    => 'Advanced Search FIlter',
            'verified'          => 'Verified',
            'unverified'        => 'Un-Verified',
            'close'             => 'Close',
            'category_id'       => 'Main Category',
            'event_group_id'    => 'Event Group',
            'sub_category_name' => 'Name',
            'new' => 'Create Main Transaction',
            'edit' => 'Edit Main Transaction',
            'validation' => [
                'category_id'          => 'Main Category',
                'event_group_id'       => 'Event Group',
                'sub_category_name_ph' => 'Relief 2020',
                'sub_category_id'      => 'Sub Category Name',
                'amount'               => 'Debit Amount',
                'amount_ph'            => 'Debit Amount',
                'event_group'            => 'Event Group',
                'creditamount'            => 'Credit Amount',
            ],
            'table' => [
                'category_name'     => 'Category Name',
                'sub_category_name' => 'Sub Category Name',
                'amount'            => 'Amount',
                'created_at'            => 'Created At',
                'event_group_name'  => 'Event Group',
            ],
            'buttons' => [
                'create' => 'Create'
            ],
        ],
        'allmembers' => [
            'management'      => 'All Members List',
            'newmanagement'   => 'SMJ Family',
            'advance_search'  => 'Advanced Search Filter',
            'verified'        => 'Verified',
            'unverified'      => 'Un-Verified',
            'agelessthan'     => 'Age Less than',
            'agegreaterthan'  => 'Age Greater than',
            'male'            => 'Male',
            'female'          => 'Female',
            'onlymainmembers' => 'Only Main Members',
            'expired'         => 'Expired Members',
            'deleted'         => 'Deleted Members',
            'agenumber'         => 'Age',
            'age_on'         => 'On',
            'verifiedstatus'         => 'Verified Status',
            'gender'         => 'Gender',
            'close'         => 'Close',
        ],
        'family' => [
            'management' => 'All Family View',
            'newmanagement' => 'SMJ Family',
            //'new' => 'નવું કુટુંબ ઉમેરો',
            'new' => 'કુટુંબ ના મુખ્ય વ્યક્તિ ની વિગત',
            'edit' => 'Edit Member Details',
            'editfamily' => 'કુટુંબ ના સભ્યો ની વિગત',
            'selectmainmember' => 'મુખ્ય વ્યક્તિ પસંદ કરો',
            'mainmemberselect' => 'મુખ્ય વ્યક્તિ પસંદ કરો',
            'memberexpired' => 'Select Date of Expired',
            'table' => [
                'fullname' => 'Full Name',
                'firstname' => 'Full Name',
                'area' => 'Area',
                'city' => 'City',
                'created_by' => 'Created By',
                'created_at' => 'Created At',
                'is_main' => 'Is Main Member',
                'is_main_ph' => '1 / 0',
                'areacity' => 'Area / City',
                'is_verified' => 'Status',
                'pending_amount' => 'Pending Amount',
            ],
            'validation' => [
                'surname' => 'અટક',
                'firstname' => 'કુટુંબ ના મુખ્ય વ્યક્તિ નું નામ (અંગ્રેજી માં)',
                'lastname' => 'પિતા / પતિ નું નામ (અંગ્રેજી માં)',
                'surnameholder' => 'પસંદ કરો',
                'firstnameholder' => 'MOHAMMADALI',
                'lastnameholder' => 'GULAMHUSEN',
                'gender' => 'જાતિ',
                'genderholder' => 'પસંદ કરો',
                'mobile' => 'મોબાઈલ નંબર',
                'mobileholder' => '9999999999',
                'dob' => 'જન્મ તારીખ',
                'city' => 'શહેર',
                'area' => 'વિસ્તાર',
                'areaholder' => 'પસંદ કરો',
                'malegender' => 'પુરુષ',
                'femalegender' => 'સ્ત્રી',
                'aadhar_id' => 'આધાર નંબર',
                'election_id' => 'ડોકયુમેંટ નું નામ તથા નંબર',
                'aadharidph' => '0000-0000-0000',
                'radioaadhar' => 'આધાર કાર્ડ',
                'radioelection' => 'Other',
                'doc_type' => 'ડોકયુમેંટ',
                'education' => 'શિક્ષણ',
                'occupation' => 'વ્યવસાય',
                'date_of_death' => 'Date of Expired',
                'transaction_date' => 'Cash collected on',
            ],
            'validationedit' => [
                'surname' => 'અટક',
                'firstname' => 'વ્યક્તિ નું નામ (અંગ્રેજી માં)',
                'lastname' => 'પિતા / પતિ નું નામ (અંગ્રેજી માં)',
                'surnameholder' => 'પસંદ કરો',
                'firstnameholder' => 'MOHAMMADALI',
                'lastnameholder' => 'GULAMHUSEN',
                'gender' => 'જાતિ',
                'genderholder' => 'પસંદ કરો',
                'mobile' => 'મોબાઈલ નંબર',
                'mobileholder' => '9999999999',
                'dob' => 'જન્મ તારીખ',
                'city' => 'શહેર',
                'area' => 'વિસ્તાર',
                'areaholder' => 'પસંદ કરો',
                'relation' => 'મુખ્ય વ્યક્તિ સાથે સંબંધ',
                'relationholder' => 'સંબંધ',
                'mainmembername' => 'કુટુંબ ના મુખ્ય વ્યક્તિ નું નામ',
            ],
            'memberslist' => [
                'action' => 'Action',
                'name' => 'સભ્ય નું નામ',
                'dob' => 'જન્મ તારીખ',
                'relation' => 'સંબંધ',
                'gender' => 'જાતિ',
                'mobile' => 'મોબાઈલ નંબર',
                'area' => 'વિસ્તાર',
                'city' => 'સ્થળ',
                'aadhar_id' => 'આધાર',
                'election_id' => 'Other',
                'verify' => 'Verify',
            ],
            'buttons' => [
                'create' => 'SUBMIT',
                'update' => 'UPDATE'
            ],
            'title' => [
                'newmember' => 'નવો સભ્ય ઉમેરો'
            ]

        ],
        'profile_updated' => 'Your profile has been updated.',
        'access'          => [
            'roles' => [
                'create'     => 'Create Role',
                'edit'       => 'Edit Role',
                'management' => 'Role Management',

                'table' => [
                    'number_of_users' => 'Number of Users',
                    'permissions'     => 'Permissions',
                    'role'            => 'Role',
                    'sort'            => 'Sort',
                    'total'           => 'role total|roles total',
                ],
            ],

            'permissions' => [
                'create'     => 'Create Permission',
                'edit'       => 'Edit Permission',
                'management' => 'Permission Management',

                'table' => [
                    'permission'   => 'Permission',
                    'display_name' => 'Display Name',
                    'sort'         => 'Sort',
                    'status'       => 'Status',
                    'total'        => 'role total|roles total',
                ],
            ],

            'users' => [
                'active'              => 'Active Users',
                'all_permissions'     => 'All Permissions',
                'change_password'     => 'Change Password',
                'change_password_for' => 'Change Password for :user',
                'create'              => 'Create User',
                'deactivated'         => 'Deactivated Users',
                'deleted'             => 'Deleted Users',
                'edit'                => 'Edit User',
                'edit-profile'        => 'Edit Profile',
                'management'          => 'User Management',
                'no_permissions'      => 'No Permissions',
                'no_roles'            => 'No Roles to set.',
                'permissions'         => 'Permissions',

                'table' => [
                    'confirmed'      => 'Confirmed',
                    'created'        => 'Created',
                    'email'          => 'E-mail',
                    'id'             => 'ID',
                    'last_updated'   => 'Last Updated',
                    'first_name'     => 'First Name',
                    'last_name'      => 'Last Name',
                    'no_deactivated' => 'No Deactivated Users',
                    'no_deleted'     => 'No Deleted Users',
                    'roles'          => 'Roles',
                    'total'          => 'user total|users total',
                ],

                'tabs' => [
                    'titles' => [
                        'overview' => 'Overview',
                        'history'  => 'History',
                    ],

                    'content' => [
                        'overview' => [
                            'avatar'       => 'Avatar',
                            'confirmed'    => 'Confirmed',
                            'created_at'   => 'Created At',
                            'deleted_at'   => 'Deleted At',
                            'email'        => 'E-mail',
                            'last_updated' => 'Last Updated',
                            'name'         => 'Name',
                            'status'       => 'Status',
                        ],
                    ],
                ],

                'view' => 'View User',
            ],
        ],

        'pages' => [
            'create'     => 'Create Page',
            'edit'       => 'Edit Page',
            'management' => 'Page Management',
            'title'      => 'Pages',

            'table' => [
                'title'     => 'Title',
                'status'    => 'Status',
                'createdat' => 'Created At',
                'updatedat' => 'Updated At',
                'createdby' => 'Created By',
                'all'       => 'All',
            ],
        ],

        'blogcategories' => [
            'create'     => 'Create Blog Category',
            'edit'       => 'Edit Blog Category',
            'management' => 'Blog Category Management',
            'title'      => 'Blog Category',

            'table' => [
                'title'     => 'Blog Category',
                'status'    => 'Status',
                'createdat' => 'Created At',
                'createdby' => 'Created By',
                'all'       => 'All',
            ],
        ],

        'blogtags' => [
            'create'     => 'Create Blog Tag',
            'edit'       => 'Edit Blog Tag',
            'management' => 'Blog Tag Management',
            'title'      => 'Blog Tags',

            'table' => [
                'title'     => 'Blog Tag',
                'status'    => 'Status',
                'createdat' => 'Created At',
                'createdby' => 'Created By',
                'all'       => 'All',
            ],
        ],

        'blogs' => [
            'create'     => 'Create Blog',
            'edit'       => 'Edit Blog',
            'management' => 'Blog Management',
            'title'      => 'Blogs',

            'table' => [
                'title'     => 'Blog',
                'publish'   => 'PublishDateTime',
                'status'    => 'Status',
                'createdat' => 'Created At',
                'createdby' => 'Created By',
                'all'       => 'All',
            ],
        ],

        'settings' => [
            'edit'           => 'Edit Settings',
            'management'     => 'Settings Management',
            'title'          => 'Settings',
            'seo'            => 'SEO Settings',
            'companydetails' => 'Company Contact Details',
            'mail'           => 'Mail Settings',
            'footer'         => 'Footer Settings',
            'terms'          => 'Terms and Condition Settings',
            'google'         => 'Google Analytics Track Code',
            'smj_settings'   => 'SMJ Settings',
        ],

        'faqs' => [
            'create'     => 'Create FAQ',
            'edit'       => 'Edit FAQ',
            'management' => 'FAQ Management',
            'title'      => 'FAQ',

            'table' => [
                'title'     => 'FAQs',
                'publish'   => 'PublishDateTime',
                'status'    => 'Status',
                'createdat' => 'Created At',
                'createdby' => 'Created By',
                'answer'    => 'Answer',
                'question'  => 'Question',
                'updatedat' => 'Updated At',
                'all'       => 'All',
            ],
        ],

        'menus' => [
            'create'     => 'Create Menu',
            'edit'       => 'Edit Menu',
            'management' => 'Menu Management',
            'title'      => 'Menus',

            'table' => [
                'name'      => 'Name',
                'type'      => 'Type',
                'createdat' => 'Created At',
                'createdby' => 'Created By',
                'all'       => 'All',
            ],
            'field' => [
                'name'      => 'Name',
                'type'      => 'Type',
                'items'     => 'Menu Items',
                'url'       => 'URL',
                'url_type'  => 'URL Type',
                'url_types' => [
                  'route'  => 'Route',
                  'static' => 'Static',
                ],
                'open_in_new_tab'    => 'Open URL in new tab',
                'view_permission_id' => 'Permission',
                'icon'               => 'Icon Class',
                'icon_title'         => 'Font Awesome Class. eg. fa-edit',
            ],
        ],

        'modules' => [
            'create'     => 'Create Module',
            'management' => 'Module Management',
            'title'      => 'Module',
            'edit'       => 'Edit Module',

            'table' => [
                'name'               => 'Module Name',
                'url'                => 'Module View Route',
                'view_permission_id' => 'View Permission',
                'created_by'         => 'Created By',
            ],

            'form' => [
                'name'                  => 'Module Name',
                'url'                   => 'View Route',
                'view_permission_id'    => 'View Permission',
                'directory_name'        => 'Directory Name',
                'namespace'             => 'Namespace',
                'model_name'            => 'Model Name',
                'controller_name'       => 'Controller &nbsp;Name',
                'resource_controller'   => 'Resourceful Controller',
                'table_controller_name' => 'Controller &nbsp;Name',
                'table_name'            => 'Table Name',
                'route_name'            => 'Route Name',
                'route_controller_name' => 'Controller &nbsp;Name',
                'resource_route'        => 'Resourceful Routes',
                'views_directory'       => 'Directory &nbsp;&nbsp;&nbsp;Name',
                'index_file'            => 'Index',
                'create_file'           => 'Create',
                'edit_file'             => 'Edit',
                'form_file'             => 'Form',
                'repo_name'             => 'Repository Name',
                'event'                 => 'Event Name',
            ],
        ],
    ],

    'frontend' => [

        'auth' => [
            'login_box_title'    => 'Login',
            'login_button'       => 'Login',
            'login_with'         => 'Login with :social_media',
            'register_box_title' => 'Register',
            'register_button'    => 'Register',
            'remember_me'        => 'Remember Me',
        ],

        'passwords' => [
            'forgot_password'                 => 'Forgot Your Password?',
            'reset_password_box_title'        => 'Reset Password',
            'reset_password_button'           => 'Reset Password',
            'send_password_reset_link_button' => 'Send Password Reset Link',
        ],

        'macros' => [
            'country' => [
                'alpha'   => 'Country Alpha Codes',
                'alpha2'  => 'Country Alpha 2 Codes',
                'alpha3'  => 'Country Alpha 3 Codes',
                'numeric' => 'Country Numeric Codes',
            ],

            'macro_examples' => 'Macro Examples',

            'state' => [
                'mexico' => 'Mexico State List',
                'us'     => [
                    'us'       => 'US States',
                    'outlying' => 'US Outlying Territories',
                    'armed'    => 'US Armed Forces',
                ],
            ],

            'territories' => [
                'canada' => 'Canada Province & Territories List',
            ],

            'timezone' => 'Timezone',
        ],

        'user' => [
            'passwords' => [
                'change' => 'Change Password',
            ],

            'profile' => [
                'avatar'             => 'Avatar',
                'created_at'         => 'Created At',
                'edit_information'   => 'Edit Information',
                'email'              => 'E-mail',
                'last_updated'       => 'Last Updated',
                'first_name'         => 'First Name',
                'last_name'          => 'Last Name',
                'address'            => 'Address',
                'state'              => 'State',
                'city'               => 'City',
                'zipcode'            => 'Zip Code',
                'ssn'                => 'SSN',
                'update_information' => 'Update Information',
            ],
        ],

    ],
];
