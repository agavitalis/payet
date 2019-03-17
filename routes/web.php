<?php



Route::get('/', function () {
    return view('welcome');
});

Auth::routes();


//Admin routes begins here
Route::get('/admin_index', 'AdminController@index')->name('admin.index');
Route::get('/admin_users', 'AdminController@users')->name('admin.users');
Route::get('/admin_approve_org/{id?}', 'AdminController@approve_org')->name('admin.approve_org');
Route::get('/admin_manage_org/{id?}', 'AdminController@manage_org')->name('admin.manage_org');
Route::match(['get','post'],'/admin_view_profile', 'AdminController@profile')->name('admin_profile');
Route::match(['get','post'],'/admin_edit_profile', 'AdminController@edit_profile')->name('admin_edit_profile');
Route::match(['get','post'],'/admin_transactions', 'AdminController@admin_transactions')->name('admin_transactions');
Route::match(['get','post'],'/admin_withdraws', 'AdminController@admin_withdraws')->name('admin_withdraws');


//User routes begins here
Route::get('/user_index', 'UserController@index')->name('user.index');
Route::match(['get','post'],'/create_org', 'UserController@create_org')->name('create_org');
Route::get('/manage_org/{id?}', 'UserController@manage_org')->name('user.manage_org');
Route::match(['get','post'],'/edit_org/{id?}', 'UserController@edit_org')->name('edit_org');
Route::match(['get','post'],'/my_wallet', 'UserController@my_wallet')->name('my_wallet');
Route::match(['get','post'],'/other_wallets', 'UserController@other_wallets')->name('other_wallets');
Route::match(['get','post'],'/profile', 'UserController@profile')->name('profile');
Route::match(['get','post'],'/edit_profile', 'UserController@edit_profile')->name('edit_profile');



//transaction  controller beginds
Route::match(['get','post'],'/make_payment', 'TransactionController@payments')->name('make_payment');
Route::get('/get_receipt/{id?}', 'TransactionController@receipt')->name('get_receipt');
Route::get('/transactions/{id?}', 'TransactionController@transactions')->name('transactions');
Route::match(['get','post'],'/print_receipts', 'TransactionController@print_receipts')->name('print_receipts');
Route::match(['get','post'],'/log_cash', 'TransactionController@log_cash')->name('log_cash');
Route::match(['get','post'],'/request_withdrawal', 'TransactionController@request_withdrawal')->name('request_withdrawal');
Route::match(['get','post'],'/view_withdrawal', 'TransactionController@view_withdrawal')->name('view_withdrawal');