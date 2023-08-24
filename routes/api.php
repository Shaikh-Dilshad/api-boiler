<?php

use App\Http\Controllers\TicketController;
use Illuminate\Http\Request;
// use Illuminate\Routing\Route;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::get('me', 'MeController@me');

Route::get('count', 'HomeController@count');


Route::post('/register', 'Auth\RegisterController@register');
Route::post('/reset_password', 'Auth\ResetPasswordController@reset_password');
Route::post('login', 'Auth\LoginController@login');
Route::post('/logout', 'Auth\LoginController@logout');
Route::get('/logout', 'Auth\LoginController@logout');

Route::resource('versions', 'VersionsController');
Route::resource('roles', 'RolesController');
Route::resource('role_user', 'RoleUserController');

Route::resource('permissions', 'PermissionsController');
Route::resource('permission_role', 'PermissionRoleController');

Route::get('users/count', 'UsersController@countUsers');
Route::get('users/masters', 'UsersController@masters');
Route::get('users/search', 'UsersController@search');
Route::get('users/excel_export', 'UsersController@excelDownload');
Route::get('users/search_by_role', 'UsersController@searchByRole');
Route::patch('users/{user}/uniqueID', 'UsersController@checkOrUpdateUniqueID');
Route::resource('users', 'UsersController');

Route::resource('companies', 'CompaniesController');
Route::resource('company_user', 'CompanyUserController');

Route::post('sendEmail', 'SendEmailController@index');

Route::get('crude_users', 'CrudeUsersController@index');
Route::post('upload_user', 'CrudeUsersController@uploadUser');
Route::get('process_user', 'CrudeUsersController@processUser');
Route::get('truncate_users', 'CrudeUsersController@truncate');

Route::get('send_otp', 'SendSmsController@index');

// Value 
Route::resource('values', 'ValuesController');
//  Value List
Route::get('value_lists/masters', 'ValueListsController@masters');
Route::post('values/{value}/value_lists_multiple', 'ValueListsController@storeMultiple');
Route::resource('values/{value}/value_lists', 'ValueListsController');

// Upload Excell Values
Route::get('crud_value', 'CrudValuesController@index');
Route::post('upload_value', 'CrudValuesController@uploadValue');
Route::get('process_value', 'CrudValuesController@processValue');
Route::get('truncate_values', 'CrudValuesController@truncate');

// Upload Excell Value Lists
Route::get('crud_value_list', 'CrudValueListsController@index');
Route::post('upload_value_list', 'CrudValueListsController@uploadValueList');
Route::get('process_value_list', 'CrudValueListsController@processValueList');
Route::get('truncate_value_lists', 'CrudValueListsController@truncate');

Route::resource('tickets', 'TicketController');
Route::resource('ticketdetails', 'TicketDetailsController');
Route::resource('blogs', 'BlogController');
Route::resource('projects', 'ProjectController');
Route::resource('skus', 'SkuController');
Route::resource('notices', 'NoticeController');
Route::resource('classes', 'ClassController');
Route::resource('programs', 'ProgramController');
Route::resource('programposts', 'ProgramPostController');
Route::resource('programtasks', 'ProgramTaskController');
Route::resource('userprograms', 'UserProgramController');
Route::resource('userprogramposts', 'UserProgramPostController');
Route::resource('teachers', 'TeacherController');
Route::resource('jobs', 'JobController');
Route::resource('doctors', 'DoctorController');
Route::resource('develops', 'DevelopController');
Route::resource('papers', 'PaperController');
Route::resource('paperpages', 'PaperPageController');














