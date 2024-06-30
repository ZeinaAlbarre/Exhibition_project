<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\ExhibitionController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::controller(AuthController::class)->group(function(){
    Route::post('visitor_register','visitor_register')->name('visitor.register');
    Route::post('company_register','company_register')->name('company.register');
    Route::post('organizer_register','organizer_register')->name('organizer.register');
    Route::post('login','login')->name('user.login');

    Route::post('UserForgotPassword','UserForgotPassword');
    Route::post('UserCodeCheck','UserCodeCheck');
    Route::post('UserResetPassword/{id}','UserResetPassword');

    Route::post('code_check_verification/{id}','code_check_verification')->name(' code.check.verification');
    Route::get('refresh_code/{id}','refresh_code')->name('refresh.code');

});

Route::middleware('auth:sanctum')->group(function () {
    Route::get('logout',[AuthController::class,'logout']);
    Route::get('accept_company/{id}',[AuthController::class,'accept_company'])->middleware('can:accept.company');
    Route::get('reject_company/{id}',[AuthController::class,'reject_company'])->middleware('can:reject.company');
    Route::post('add_employee',[AuthController::class,'add_employee'])->name('add.employee')->middleware('can:add.employee');
    Route::get('delete_employee/{id}',[AuthController::class,'delete_employee'])->name('delete.employee')->middleware('can:delete.employee');
    Route::get('deleteAccount',[AuthController::class,'deleteAccount'])->name('delete.account')->middleware('can:delete.account');
    Route::get('showProfile',[AuthController::class,'showProfile'])->name('show.profile');
    Route::post('updateCompanyProfile',[AuthController::class,'updateCompanyProfile']);

    Route::post('addExhibition',[ExhibitionController::class,'addExhibition'])->name('add.exhibition')->middleware('can:add.exhibition');
    Route::get('showExhibitionRequest',[ExhibitionController::class,'showExhibitionRequest']);
    Route::get('acceptExhibition/{id}',[ExhibitionController::class,'acceptExhibition'])->name('accept.exhibition')->middleware('can:accept.exhibition');
    Route::get('rejectExhibition/{id}',[ExhibitionController::class,'rejectExhibition'])->name('reject.exhibition')->middleware('can:reject.exhibition');
    Route::get('deleteExhibition/{id}',[ExhibitionController::class,'deleteExhibition'])->name('delete.exhibition')->middleware('can:delete.exhibition');
    Route::post('updateExhibition/{id}',[ExhibitionController::class,'updateExhibition'])->name('update.exhibition')->middleware('can:update.exhibition');
    Route::get('showEmployeeExhibition',[ExhibitionController::class,'showEmployeeExhibition']);
    Route::post('searchExhibition',[ExhibitionController::class,'searchExhibition']);
    Route::get('showExhibition/{id}',[ExhibitionController::class,'showExhibition']);
    Route::get('showAvailableExhibition',[ExhibitionController::class,'showAvailableExhibition']);
    Route::get('showAvailableCompanyExhibition',[ExhibitionController::class,'showAvailableCompanyExhibition']);
    Route::post('changeExhibitionStatus/{id}',[ExhibitionController::class,'changeExhibitionStatus']);
    Route::post('addExhibitionSection/{id}',[ExhibitionController::class,'addExhibitionSection']);
    Route::get('showExhibitionSection/{section_id}',[ExhibitionController::class,'showExhibitionSection']);

});
