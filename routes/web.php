<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\Owner\OwnerController;
use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Secretary\SecretaryController;
use App\Http\Controllers\Garagist\GaragistController;
use App\Http\Controllers\Agencies\AgencyController;
use App\Http\Controllers\VehiculeController;
use App\Http\Controllers\Agencies\PickUpLocationController;
use App\Http\Controllers\BookingController;
use App\Models\PickUpLocation;
use App\Models\Secretary;
use App\Models\Vehicule;

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

Route::middleware(['guest:web', 'guest:owner', 'guest:admin', 'guest:secretary', 'guest:garagist', 'PreventBackHistory'])->group(function () {
  Route::view('/', 'guestHome')->name('guestHome');
});
Route::middleware(['guest:web', 'guest:owner', 'guest:admin', 'guest:secretary', 'guest:garagist', 'PreventBackHistory'])->group(function () {
  Route::view('/worker/login', 'workerLogin')->name('workerLogin');
});


// users
Route::prefix('user')->name('user.')->group(function () {
  Route::middleware(['guest:web', 'guest:owner', 'guest:admin', 'guest:secretary', 'guest:garagist', 'PreventBackHistory'])->group(function () {
    Route::get('/', function () {
      return redirect(route('user.login'));
    });
    Route::view('/login', 'users.login')->name('login');
    Route::view('/register', 'users.register')->name('register');
    Route::post('/create', [UserController::class, 'create'])->name('create');
    Route::post('/viewOffers', [VehiculeController::class, 'searchVehicules'])->name('getOffers');
  });
  Route::middleware(['auth:web', 'PreventBackHistory'])->group(function () {
    Route::view('/home', 'guestHome')->name('home');
    Route::post('/logout', [UserController::class, 'logout'])->name('logout');
  });
});

//owners
Route::prefix('owner')->name('owner.')->group(function () {
  Route::middleware(['guest:owner', 'guest:web', 'guest:admin', 'guest:secretary', 'guest:garagist', 'PreventBackHistory'])->group(function () {
    Route::get('/', function () {
      return redirect(route('workerLogin'));
    });
    Route::view('/register', 'owners.register')->name('register');
    Route::post('/create', [OwnerController::class, 'create'])->name('create');
    Route::post('/check', [OwnerController::class, 'check'])->name('check');
  });
  Route::middleware(['auth:owner', 'PreventBackHistory'])->group(function () {
    Route::get('/home', [OwnerController::class, 'home'])->name('home');
    Route::post('/logout', [OwnerController::class, 'logout'])->name('logout');
    Route::view('/createAgency', 'owners.addAgency')->name('createAgency');
    Route::post('/createAgency', [AgencyController::class, 'create'])->name('createAgencyPost');
    Route::get('/addEmployee', [OwnerController::class, 'addEmployeePage'])->name('addEmployee');
    Route::post('/addEmployee', [OwnerController::class, 'addEmployee'])->name('addEmployeePost');
    Route::get('/editProfile', [OwnerController::class, 'showProfile'])->name('showProfile');
    Route::post('/editProfile', [OwnerController::class, 'editProfile'])->name('editProfile');
    Route::get('/reclamations', [OwnerController::class, 'showReclamations'])->name('showReclamations');
    Route::get('/reclamations/{recid}', [OwnerController::class, 'reclamation'])->name('reclamation');
    Route::post('/answerReclamation/{recid}', [OwnerController::class, 'answerReclamation'])->name('answerReclamation');
    Route::get('/branches', [OwnerController::class, 'branches'])->name('showBranches');
    Route::post('/addbranch', [OwnerController::class, 'createBranch'])->name('addBranchePost');
    Route::get('/branche/{id}', [OwnerController::class, 'showBranch'])->name('showBranch');
    Route::post('/branche/{id}', [OwnerController::class, 'deleteBranch'])->name('deleteBranch');
    Route::get('/employees', [OwnerController::class, 'employeesList'])->name('employeesList');
    Route::get('/getSecUsername/{id}', [OwnerController::class, 'getSecUsername'])->name('getSecUsername');
    Route::get('/getGarUsername/{id}', [OwnerController::class, 'getGarUsername'])->name('getGarUsername');
    Route::post('/deleteSec', [OwnerController::class, 'deleteSec'])->name('deleteSecretary');
    Route::post('/deleteGar', [OwnerController::class, 'deleteGar'])->name('deleteGaragist');
    Route::get('/getSecTransfer/{id}', [OwnerController::class, 'getSecTransfer'])->name('getSecTransfer');
    Route::post('/secTransfer', [OwnerController::class, 'secTransfer'])->name('secTransfer');
    Route::get('/getGarTransfer/{id}', [OwnerController::class, 'getGarTransfer'])->name('getGarTransfer');
    Route::post('/garTransfer', [OwnerController::class, 'garTransfer'])->name('garTransfer');
    Route::get('/garages', [OwnerController::class, 'garages'])->name('showGarages');
    Route::get('/loadForm', [OwnerController::class, 'loadForm'])->name('loadForm');
    Route::get('/availableGaragists/{id}', [OwnerController::class, 'availableGaragists'])->name('availableGaragists');
    Route::post('/addGarage', [OwnerController::class, 'addGarage'])->name('addGarage');
    Route::get('/garageDetails/{id}', [OwnerController::class, 'garageDetails'])->name('garageDetails');
    Route::post('/garage/{id}', [OwnerController::class, 'deleteGarage'])->name('deleteGarage');
    Route::post('/changeManager', [OwnerController::class, 'changeManager'])->name('changeManager');
  });
});

//admins
Route::prefix('admin')->name('admin.')->group(function () {
  Route::middleware(['guest:web', 'guest:owner', 'guest:admin', 'guest:secretary', 'guest:garagist', 'PreventBackHistory'])->group(function () {
    Route::get('/', function () {
      return redirect(route('admin.login'));
    });
    Route::view('/login', 'admin.login')->name('login');
    Route::post('/check', [AdminController::class, 'check'])->name('check');
  });
  Route::middleware(['auth:admin', 'PreventBackHistory'])->group(function () {
    Route::view('/dashboard', 'admin.dashboard')->name('dashboard');
    Route::view('/joining-requests', 'admin.joiningRequests')->name('joiningRequests');
    Route::get('/joining-request', [AgencyController::class, 'getJoiningRequests'])->name('joiningRequests');
    Route::post('/accept-agency/{id}', [AgencyController::class, 'acceptAgency'])->name('acceptAgency');
    Route::post('/refuse-agency/{id}', [AgencyController::class, 'refuseAgency'])->name('refuseAgency');
    Route::view('/agencies-list', 'admin.agenciesList')->name('agenciesList');
    Route::get('/agencies-list', [AgencyController::class, 'getAgencies'])->name('getAgencies');
    Route::view('/users-list', 'admin.usersList')->name('usersList');
    Route::get('/users-list', [UserController::class, 'getUsersList'])->name('usersList');
    Route::view('/baned-users', 'admin.banedUsers')->name('banedUsers');
    Route::post('/logout', [AdminController::class, 'logout'])->name('logout');
  });
});
//secretaries
Route::prefix('secretary')->name('secretary.')->group(function(){
    Route::middleware(['guest:web','guest:owner','guest:admin','guest:secretary','guest:garagist','PreventBackHistory'])->group(function(){
        Route::get('/',function(){
            return redirect(route('workerLogin'));
        });
        Route::post('/check',[SecretaryController::class,'check'])->name('check');
        });
    Route::middleware(['auth:secretary','PreventBackHistory'])->group(function(){
        Route::view('/home','secretaries.secretaryHome')->name('home');
        Route::get('/vehicles',[SecretaryController::class,'showVehicules'])->name('showVehicules');
        Route::get('/vehicle/{id}',[SecretaryController::class,'vehiculeDetails'])->name('vehiculeDetails');
        Route::get('/editProfile',[SecretaryController::class,'showProfile'])->name('showProfile');
        Route::post('/editProfile',[SecretaryController::class,'editProfile'])->name('editProfile');
        Route::get('/addVehicule',[SecretaryController::class,'addVehiculePage'])->name('addVehicule');
        Route::post('/addVehicule',[SecretaryController::class,'addVehicule'])->name('addVehiculePost');
        Route::get('/pick-up-locations',[AgencyController::class,'getPickUpLocations'])->name('getPickUpLocations');
        Route::post('/pick-up-locations',[AgencyController::class,'addPickUpLoaction'])->name('addPickUpLocation');
        Route::post('/logout',[SecretaryController::class,'logout'])->name('logout');
        Route::get('/reservation-requests',[SecretaryController::class,'getReservationRequests'])->name('getReservationRequests');
        Route::get('/reservationDetails/{id}',[SecretaryController::class,'reservationDetails'])->name('reservationDetails');
        Route::post('/accept-booking/{id}',[BookingController::class, 'accept'])->name('acceptBooking');
        Route::post('/decline-booking/{id}',[BookingController::class, 'decline'])->name('declineBooking');
        Route::get('/history',[SecretaryController::class,"getHistory"])->name('history');
        Route::post('/setRating',[SecretaryController::class, 'setRating'])->name('setRating');
        Route::post('/banUser',[SecretaryController::class, 'banUser'])->name('banUser');
        Route::get('/testroute',[SecretaryController::class, 'test']);
    });
//     Route::post('/check', [SecretaryController::class, 'check'])->name('check');
//   });
//   Route::middleware(['auth:secretary', 'PreventBackHistory'])->group(function () {
//     Route::view('/home', 'secretaries.secretaryHome')->name('home');
//     Route::get('/vehicles', [SecretaryController::class, 'showVehicules'])->name('showVehicules');
//     Route::get('/vehicle/{id}', [SecretaryController::class, 'vehiculeDetails'])->name('vehiculeDetails');
//     Route::get('/editProfile', [SecretaryController::class, 'showProfile'])->name('showProfile');
//     Route::post('/editProfile', [SecretaryController::class, 'editProfile'])->name('editProfile');
//     Route::get('/addVehicule', [SecretaryController::class, 'addVehiculePage'])->name('addVehicule');
//     Route::post('/addVehicule', [SecretaryController::class, 'addVehicule'])->name('addVehiculePost');
//     Route::get('/pick-up-locations', [AgencyController::class, 'getPickUpLocations'])->name('getPickUpLocations');
//     Route::post('/pick-up-locations', [AgencyController::class, 'addPickUpLoaction'])->name('addPickUpLocation');
//     Route::post('/logout', [SecretaryController::class, 'logout'])->name('logout');
//     Route::get('/reservation-requests', [SecretaryController::class, 'getReservationRequests'])->name('getReservationRequests');
//     Route::get('/reservationDetails/{id}', [SecretaryController::class, 'reservationDetails'])->name('reservationDetails');
//     Route::post('/accept-booking/{id}', [BookingController::class, 'accept'])->name('acceptBooking');
//     Route::post('/decline-booking/{id}', [BookingController::class, 'decline'])->name('declineBooking');
//     Route::get('/history', [SecretaryController::class, "getHistory"])->name('history');
//   });
});
//garagists
Route::prefix('garagist')->name('garagist.')->group(function () {
  Route::middleware(['guest:web', 'guest:owner', 'guest:admin', 'guest:secretary', 'guest:garagist', 'PreventBackHistory'])->group(function () {
    Route::get('/', function () {
      return redirect(route('workerLogin'));
    });
    Route::post('/check', [GaragistController::class, 'check'])->name('check');
  });
  Route::middleware(['auth:garagist', 'PreventBackHistory'])->group(function () {
    Route::view('/home', 'garagists.garagistHome')->name('home');
    Route::post('/logout', [GaragistController::class, 'logout'])->name('logout');
  });
});
