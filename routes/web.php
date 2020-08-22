<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return redirect('/login');
});

Route::group(['middleware' => ['auth', 'status']], function () {

    Route::group(['prefix' => 'admin', 'middleware' => 'adminRole'], function () {

        Route::post('/set-admin-to-transaction', 'TransactionController@setAdminToTransaction');


        Route::get('/', function () {
            return view('admin', ['component' => '<dashboard-component></dashboard-component>']);
        })->name('admin');

        Route::group(['prefix' => 'general-categories'], function () {

            Route::get('/', 'CategoriesController@general')->name('general.categories');

            Route::post('/get-general-categories', 'CategoriesController@getGeneralCategories');
            Route::post('/add-edit-general-categories', 'CategoriesController@addEditGeneralCategories');
            Route::post('/delete-general-categories', 'CategoriesController@destroyGeneral');

        });

        Route::group(['prefix' => 'managers'], function () {

            Route::get('/', 'ManagerOptionsController@index')->name('managers');

            Route::post('/get-managers', 'ManagerOptionsController@getManagerOptions');
            Route::post('/add-edit-managers', 'ManagerOptionsController@addEditManagerOptions');
            Route::post('/delete-managers', 'ManagerOptionsController@destroy');

        });

        Route::group(['prefix' => 'categories'], function () {

            Route::get('/', 'CategoriesController@index')->name('categories');
            Route::get('/{params}', 'CategoriesController@addEditCategories');

            Route::post('/get-categories/{id?}', 'CategoriesController@getCategories');
            Route::post('/add-edit-categories', 'CategoriesController@addEditCategories');
            Route::post('/delete-categories', 'CategoriesController@destroy');

        });

        Route::group(['prefix' => 'services'], function () {

            Route::get('/', 'ServicesController@index')->name('services');
            Route::get('/{params}', 'ServicesController@addEditServices');

            Route::post('/get-services/{id?}', 'ServicesController@getServices');
            Route::post('/add-edit-services', 'ServicesController@addEditServices');
            Route::post('/change-status-options-services', 'ServicesController@changeStatusOptionsServices');
            Route::post('/delete-services', 'ServicesController@destroy');

            Route::group(['namespace' => 'ServicesReload'], function(){
                Route::get('services_reload/all', 'ServicesReloadController@index');
                Route::get('services_reload/{services_reload}', 'ServicesReloadController@show');
                Route::post('services_reload', 'ServicesReloadController@store');
                Route::post('services_reload/edit/{services_reload}', 'ServicesReloadController@update');
                Route::delete('services_reload/delete/{services_reload}', 'ServicesReloadController@destroy');
            });

            Route::group(['namespace' => 'FixedServices'], function(){
                Route::get('fixed_services/all', 'FixedServicesController@index');
                Route::get('fixed_service/{fixed_service}', 'FixedServicesController@show');
                Route::post('fixed_service', 'FixedServicesController@store');
                Route::post('fixed_service/edit/{fixed_service}', 'FixedServicesController@update');
                Route::delete('fixed_service/{fixed_service}', 'FixedServicesController@destroy');
            });

            Route::group(['namespace' => 'AcqTransaction'], function(){
                Route::post('asq_service', 'AcqTransactionController@store');
            });
            Route::group(['namespace' => 'NipTransaction'], function(){
                Route::post('nip_service', 'NipTransactionController@store');
            });
        });

        Route::group(['prefix' => 'agent'], function () {
            Route::get('/', 'UserController@agent')->name('admin.agent');
            Route::get('/{params}', 'UserController@addEditAgent');

            Route::post('/get-agent/{id?}', 'UserController@getAgent');
            Route::post('/add-edit-agent', 'UserController@addEditAgent');
            Route::post('/change-agent-role', 'UserController@changeRoleAgent');
            Route::post('/delete-agent', 'UserController@destroyAgent');


        });

        Route::group(['prefix' => 'clients'], function () {
            Route::get('/', 'ClientController@index')->name('client');
            Route::get('/{params}', 'ClientController@addEditClient');

            Route::post('/get-clients/{id?}', 'ClientController@getClient');
            Route::post('/add-edit-clients', 'ClientController@addEditClient');
            Route::post('/delete-clients', 'ClientController@destroy');
            Route::post('/tax-code', 'ClientController@taxCode');

        });

        Route::group(['prefix' => 'transaction'], function () {

            Route::get('/', 'TransactionController@index')->name('trasaction');

            Route::post('/get-transaction', 'TransactionController@getTransaction');
            Route::post('/asignto-admin', 'TransactionController@asigntoAdmin');
            Route::post('/delete-transaction', 'TransactionController@destroy');
            Route::post('/change-options-transaction', 'TransactionController@changeStatusOptionsServices');
            Route::post('/update-transaction', 'TransactionController@updateTransaction');

        });
    });

    Route::group(['prefix' => 'agent'], function () {

        Route::group(['prefix' => 'transaction'], function () {

            Route::get('/', 'TransactionController@transaction')->name('agent.trasaction');

            Route::post('/get-transaction', 'TransactionController@getTransaction');

        });
        Route::get('fixed_services', 'ServicesController@getFixedServices')->name('agent.fixed.services');

        Route::group(['namespace' => 'ServicesReloadConfirm'], function(){
            Route::post('services_reload_confirm', 'ServicesReloadConfirmController@store');
            Route::get('services_reloads', 'ServicesReloadConfirmController@index')->name('agent.ricarica');
        });

        Route::group(['namespace' => 'NipTransaction'], function(){
            Route::post('nip_transaction', 'NipTransactionController@store');
        });

        Route::group(['namespace' => 'AcqTransaction'], function(){
            Route::post('acq_transaction', 'AcqTransactionController@store');
        });

        Route::group(['namespace' => 'ConversionTransaction'], function(){
            Route::post('conversion_transaction', 'ConversionTransactionController@store');
        });

        Route::group(['namespace' => 'UllTransaction'], function(){
            Route::post('ull_transaction', 'UllTransactionController@store');
        });

        Route::group(['namespace' => 'MnpTransaction'], function(){
            Route::post('mnp_transaction', 'MnpServiceController@store');
        });

        Route::get('/', 'AgentController@index')->name('agent');
        Route::get('/general/{id}', 'AgentController@index');
        Route::get('/general/{id}/category/{category_id}', 'AgentController@index');
        Route::post('/add-client', 'ClientController@addClient');
        Route::post('/get-managers', 'ManagerOptionsController@getManagerOptions');
        Route::post('/tax-code', 'ClientController@taxCode');

    });




});

/*Test*/

Route::get('/test', 'TestsController@index');
Route::get('/logout', 'Auth\LoginController@logout');
/*Testend*/

Auth::routes(['register' => false, 'reset' => false, 'verify' => false,]);

Route::get('/home', 'HomeController@index')->name('home');

Route::get('/transaction/downloadPDF/{id}','TransactionController@downloadPDF');

//set-admin-to-transaction

