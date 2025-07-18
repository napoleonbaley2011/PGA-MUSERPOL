<?php

use App\Http\Controllers\ClassifierController;
use App\Http\Controllers\GroupsController;
use App\Http\Controllers\LdapController;
use App\Http\Controllers\MaterialController;
use App\Http\Controllers\NoteEntriesController;
use App\Http\Controllers\NoteRequestController;
use App\Http\Controllers\PettycashController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\SupplierController;
use App\Http\Controllers\TypeController;
use App\Http\Controllers\UserLdapController;
use Illuminate\Support\Facades\Route;
use Laravel\Prompts\Note;

Route::group([
    'middleware' => 'api',
    'prefix' => 'auth'
], function () {
    //Rutas Abiertas
    Route::post('/login', [App\Http\Controllers\Auth\AuthController::class, 'login']);
    Route::get('/index', [App\Http\Controllers\Auth\AuthController::class, 'index']);
    Route::get('/pva_list_material', [MaterialController::class, 'list_materials_pva']);
    Route::get('/list_ldap', [LdapController::class, 'list_persons_ldap']);

    Route::get('/list_product', [ProductController::class, 'list_petty_cash']);
    Route::post('/createproduct', [ProductController::class, 'create_product']);
    Route::post('/createNotePettyCash', [ProductController::class, 'create_note']);
    Route::get('/notePettyCash/{id_user}', [ProductController::class, 'list_petty_cash_user']);
    Route::post('/verifyPettyCash', [ProductController::class, 'verify']);
    Route::get('/printPettCash/{notepettyCash}', [ProductController::class, 'print_Petty_Cash']);
    Route::get('/printPettCashDischarge/{notepettyCash}', [ProductController::class, 'print_Petty_Cash_discharge']);
    Route::get('/list_group', [ProductController::class, 'list_group']);
    Route::post('/savePettyCashDetails', [ProductController::class, 'save_petty_cash']);
    Route::post('/personal_transpor_tickets', [ProductController::class, 'create_note_tickets']);
    Route::get('/controlNote', [NoteEntriesController::class, 'controlNote']);


    Route::get('/AccountabilitySheet2', [PettycashController::class, 'Print_Accountability_sheet']);

    Route::get('/prueba_note', [NoteEntriesController::class, 'services_note']);
    //Notas de Solicitud
    Route::get('/noteRequest', [NoteRequestController::class, 'list_note_request']);
    Route::get('/noteRequestPettyCash', [NoteRequestController::class, 'list_note_request_petty_cash']);
    Route::get('/noteRequest/{id_user}', [NoteRequestController::class, 'listUserNoteRequests']);
    Route::post('/createNoteRequest', [NoteRequestController::class, 'create_note_request']);
    Route::get('/printRequest/{note_request}', [NoteRequestController::class, 'print_request']);

    Route::get('/materialCorrect', [MaterialController::class, 'NameMaterialCorrect']);




    Route::group(['middleware' => ['auth:sanctum']], function () {
        Route::resource('classifiers', ClassifierController::class);
        Route::resource('groups', GroupsController::class);
        Route::get('/listgroup/{id_classifier}', [GroupsController::class, 'list_groups']);
        Route::resource('suppliers', SupplierController::class);
        Route::resource('materials', MaterialController::class);
        Route::get('fixMaterialDuplicate', [MaterialController::class, 'fixDuplicatedCodes']);
        Route::patch('/updateName/{material}/', [MaterialController::class, 'updateName']);
        Route::resource('types', TypeController::class);
        //Nota de entrada
        Route::get('/notes', [App\Http\Controllers\NoteEntriesController::class, 'list_note_entries']);
        Route::get('/notesRevision', [App\Http\Controllers\NoteEntriesController::class, 'list_note_entries_revision']);
        Route::post('/createNoteEntry', [App\Http\Controllers\NoteEntriesController::class, 'create_note']);
        Route::post('/approvedNoteEntry', [App\Http\Controllers\NoteEntriesController::class, 'aprovedded_note']);
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
        Route::get('/PrintKardexExcel/{material}', [ReportController::class, 'print_kardex_excel']);
        Route::get('/ReportPrintValuedPhysical', [ReportController::class, 'ValuedPhysical']);


        Route::get('/ReportPrintValuedPhysicalConsolidated/{management}', [ReportController::class, 'consolidated_inventory']);


        Route::get('/PrintValuedPhysical', [ReportController::class, 'PrintValuedPhysical']);
        Route::get('/PrintValuedPhysicalExcel', [ReportController::class, 'exportValuedInventoryExcel']);

        Route::get('/PrintValuedPhysicalConsolidated/{management}', [ReportController::class, 'print_consolidated_valued_physical_inventory']);
        Route::get('/ManagementClosure', [ReportController::class, 'management_closure']);


        Route::get('/funcion/{material}', [ReportController::class, 'calculateMaterialCost']);

        Route::get('/listUser', [UserLdapController::class, 'list_users_rol']);
        Route::post('/newStoreUser', [UserLdapController::class, 'list_user_new']);
        Route::get('/listEmployees/{user}', [UserLdapController::class, 'list_users']);
        Route::get('/printListEmployee/{user}', [UserLdapController::class, 'list_users_print']);
        Route::get('/listEmployeesRequest', [UserLdapController::class, 'list_user_request']);
        Route::get('/listRequestDirections/{direction}', [UserLdapController::class, 'list_users_direction']);
        Route::get('/printListRequestDirections/{direction}', [UserLdapController::class, 'list_direction_print']);


        Route::get('/printAccountabilitySheet', [PettycashController::class, 'Accountability_sheet']);
        Route::get('/AccountabilitySheet', [PettycashController::class, 'Print_Accountability_sheet']);
        Route::get('/RecordBook', [PettycashController::class, 'Petty_Cash_Record_Book']);
        Route::get('/PrintRecordBook', [PettycashController::class, 'Print_Petty_Cash_Record_Book']);
        Route::get('/DatesPettyCash', [PettycashController::class, 'Petty_Cash_Record_Book_Dates']);
        Route::post('/fullDischarge', [PettycashController::class, 'FullDischarge']);
        Route::get('/paymentOrder', [PettycashController::class, 'PaymentOrder']);
        Route::get('/createDischarge', [PettycashController::class, 'CreateDischarge']);

        Route::get('/listManagement', [ReportController::class, 'list_mangement']);
    });
});
