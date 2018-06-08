<?php


$GLOBALS["user_role"]  = [
					'1' => 'Admin',
                    '2' => 'Staff',
                    '3' => 'Relative',
                    '4' => 'Patient',
                   // '0'=> 'Super Admin'
                   ];

$GLOBALS["user_role_codename"]  = [
					'admin' => 'Admin',
                    'staff' => 'Staff',
                    'relative' => 'Relative',
                    'patient' => 'Patient',
                    //'super_admin' =>  'Super Admin'
                   ];

$GLOBALS["user_status"]  = [
					'1' => 'Enabled',
                    '2' => 'Disabled'
                   ];

 $GLOBALS["provider_status"]  = [
					'0' => 'Enabled',
                    '1' => 'Disabled'
                   ];

$GLOBALS["menu_status"]  = [
					'y' => 'Enabled',
                    'n' => 'Disabled'
                   ];

$GLOBALS["yn_status"]  = [
					'y' => 'Enabled',
                    'n' => 'Disabled'
                   ];

$GLOBALS["order_status"]  = [
					'1' => 'Created',
                    '2' => 'Paid',
                    '3' => 'Processed',
                    '4' => 'Delivered',
                    '5' => 'Cancelled',
                   ];

$GLOBALS["document_types"]  = [
					'about_patient' => 'about_patient',
                    'implementation_plan' => 'implementation_plan',
                    'diary' => 'diary',
                    'billboard' => 'billboard',
                    'calendar' => 'calendar',
                    'newsletter' => 'newsletter',
                    'help_page' => 'help_page',
                    'orders_history' => 'orders_history',
                    'about_page' => 'about_page'
                   ];

$GLOBALS["menu_type"]  = [
					'product' => 'Product',
                    'doc-list' => 'Documents list',
                    'orders-list' => 'Orders list'
                   ];


$GLOBALS["big_menu_icons"]  = [
					'carelink-diary' => 'diary',
					'carelink-orders' => 'orders',
					'carelink-messages'  => 'messages',
					'ios-contact-outline'  => 'contact',
					'carelink-food' => 'food',
					'ios-paper-outline'  => 'paper-outline',
					'ios-calendar-outline'  => 'calendar',
					'ios-bookmarks-outline'  => 'bookmarks',
					'ios-contacts-outline'  => 'contacts',
					'carelink-accomp_order'  => 'accomp_order',
					'carelink-accomp_cancel'  => 'accomp_cancel',
					'carelink-medical'  => 'medical',
					'carelink-cancel_visit'  => 'cancel_visit',
					'carelink-footprint'  => 'footprint',
					'carelink-massage'  => 'massage',
					'carelink-care'  => 'care',
					'carelink-dogs'  => 'dogs',
					'carelink-cleaning'  => 'cleaning',
					'carelink-promenad'  => 'promenad',
					'carelink-snowman' => 'snowman',
					'carelink-sport'  => 'sport'
					];

$GLOBALS["product_type"]  = [
					'order_accompanier' => 'Order Accompanier',
					'cancel_accompanier' => 'Cancel Accompanier',
					'pharmacy' => 'Pharmacy',
					'cancel_visit' => 'Cancel Visit',
					'foot_care' => 'Foot Care',
					'massage' => 'Massage',
					'watching' => 'Watching',
					'pets' => 'Pets',
					'extra_cleaning' => 'Extra Cleaning',
					'promenade' => 'Promenade',
					'snow_cleaning' => 'Snow Cleaning',
					'gymnastics' => 'Gymnastics',
					'food_menu' => 'Food Menu',
					 ];


$GLOBALS["message_status"] = [
					'1' => 'New',
                    '2' => 'Read',
                     ];


return [
    'adminEmail' => 'admin@example.com',
    'BankID_apiKey' => "8356e98c6551b448f4fa6ea2f0b2f54b",
    'BankID_app_ServiceKey' => "42779263d8b44c88c8429829a8d2297d",
    'BankID_other_ServiceKey' => "26be125b484beb4b14db29697556ad78",
    'BankID_authenticateServiceKey' => "7658bea0424291f017211348606613c4",
    'BankID_endpoint' => 'https://client-test.grandid.com/json1.1/',
    'uploadPath'=>'/web/uploads/',
    'timeZone'=>'Europe/Stockholm',
];


