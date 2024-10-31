<?php

use App\Http\Controllers\ClassifierController;
use App\Http\Controllers\GroupsController;
use App\Http\Controllers\LdapController;
use App\Http\Controllers\MaterialController;
use App\Http\Controllers\NoteEntriesController;
use App\Http\Controllers\NoteRequestController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\SupplierController;
use App\Http\Controllers\TypeController;
use App\Http\Controllers\UserLdapController;
use Illuminate\Support\Facades\Route;

Route::group([
    'middleware' => 'api',
    'prefix' => 'auth'
], function () {
    //Rutas Abiertas
    Route::post('/login', [App\Http\Controllers\Auth\AuthController::class, 'login']);
    Route::get('/index', [App\Http\Controllers\Auth\AuthController::class, 'index']);
    Route::get('/pva_list_material', [MaterialController::class, 'list_materials_pva']);

    Route::get('/list_ldap', [LdapController::class, 'list_persons_ldap']);
    Route::get('/prueba_note', [NoteEntriesController::class, 'services_note']);
    //Notas de Solicitud
    Route::get('/noteRequest', [NoteRequestController::class, 'list_note_request']);
    Route::get('/noteRequestPettyCash', [NoteRequestController::class, 'list_note_request_petty_cash']);
    Route::get('/noteRequest/{id_user}', [NoteRequestController::class, 'listUserNoteRequests']);
    Route::post('/createNoteRequest', [NoteRequestController::class, 'create_note_request']);
    Route::get('/printRequest/{note_request}', [NoteRequestController::class, 'print_request']);


    Route::group(['middleware' => ['auth:sanctum']], function () {
        Route::resource('classifiers', ClassifierController::class);
        Route::resource('groups', GroupsController::class);
        Route::get('/listgroup/{id_classifier}', [GroupsController::class, 'list_groups']);
        Route::resource('suppliers', SupplierController::class);
        Route::resource('materials', MaterialController::class);
        Route::patch('/updateName/{material}/', [MaterialController::class, 'updateName']);
        Route::resource('types', TypeController::class);
        //Nota de entrada
        Route::get('/notes', [App\Http\Controllers\NoteEntriesController::class, 'list_note_entries']);
        Route::post('/createNoteEntry', [App\Http\Controllers\NoteEntriesController::class, 'create_note']);
        Route::get('/materialslist', [MaterialController::class, 'materialslist']);
        Route::delete('/deleteNoteEntry/{note_entry}/', [NoteEntriesController::class, 'destroy']);
        Route::get('/printNoteEntry/{note_entry}/', [NoteEntriesController::class, 'print_note_entry']);
        //Notas de Solicitud
        Route::post('/delivered_material', [NoteRequestController::class, 'delivered_of_material']);
        Route::get('/print_post_request/{note_request}', [NoteRequestController::class, 'print_post_request']);
        //Dashboard
        Route::get('/dataDashboard', [ReportController::class, 'dashboard_data']);
        Route::get('/dataTableDashboard', [ReportController::class, 'kardexGeneral']);
        //Reportes
        Route::get('/ReportPrintKardex/{material}', [ReportController::class, 'kardex']);
        Route::get('/PrintKardex/{material}', [ReportController::class, 'print_kardex']);
        Route::get('/ReportPrintValuedPhysical', [ReportController::class, 'ValuedPhysical']);
        Route::get('/PrintValuedPhysical', [ReportController::class, 'PrintValuedPhysical']);
        Route::get('/ReportPrintValuedPhysicalConsolidated/{management}', [ReportController::class, 'consolidated_valued_physical_inventory']);
        Route::get('/PrintValuedPhysicalConsolidated/{management}', [ReportController::class, 'print_consolidated_valued_physical_inventory']);
        Route::get('/ManagementClosure', [ReportController::class, 'management_closure']);


        Route::get('/funcion/{material}', [ReportController::class, 'calculateMaterialCost']);

        Route::get('/listUser', [UserLdapController::class, 'list_users_rol']);
        Route::get('/listEmployees/{user}', [UserLdapController::class, 'list_users']);
        Route::get('/printListEmployee/{user}', [UserLdapController::class, 'list_users_print']);
        Route::get('/listEmployeesRequest', [UserLdapController::class, 'list_user_request']);
        Route::get('/listRequestDirections/{direction}', [UserLdapController::class, 'list_users_direction']);
        Route::get('/printListRequestDirections/{direction}', [UserLdapController::class, 'list_direction_print']);

        Route::get('/listManagement', [ReportController::class, 'list_mangement']);



        Route::get('/php-config', function () {
            return response()->json([
                'memory_limit' => ini_get('memory_limit'),
                'max_execution_time' => ini_get('max_execution_time'),
                'upload_max_filesize' => ini_get('upload_max_filesize'),
                'post_max_size' => ini_get('post_max_size'),
            ]);
        });
    });
});
