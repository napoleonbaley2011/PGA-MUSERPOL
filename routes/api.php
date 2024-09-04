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
use App\Models\Material;
use App\Models\Note_Entrie;
use App\Models\NoteRequest;
use Illuminate\Http\Request;
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
        Route::get('/ReportPrintValuedPhysicalConsolidated', [ReportController::class, 'consolidated_valued_physical_inventory']);
        Route::get('/ManagementClosure', [ReportController::class, 'management_closure']);

        Route::get('/funcion', [ReportController::class, 'getNotesByDateRange']);
    });
});
