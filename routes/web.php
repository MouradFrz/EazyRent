<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\Owner\OwnerController;
use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Secretary\SecretaryController;
use App\Http\Controllers\Garagist\GaragistController;
use App\Http\Controllers\Agencies\AgencyController;
use App\Http\Controllers\VehiculeController;

use App\Http\Controllers\BookingController;
use App\Http\Controllers\GoogleController;

use Illuminate\Foundation\Auth\EmailVerificationRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password;
use Illuminate\Auth\Events\PasswordReset;
use Illuminate\Support\Str;

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


//// EMail verification routes
Route::prefix('email')->name('verification.')->group(function () {
// dd(Auth::guard());
  Route::middleware('PreventBackHistory')->group(function(){
    Route::get('/verify', function () {
      return view('users.verifyEmail');
    })->middleware('auth')->name('notice');


    Route::get('/verify/{id}/{hash}', function (EmailVerificationRequest $request) {
      $request->fulfill();
      return redirect()->route('user.home');
    })->middleware(['auth', 'signed'])->name('verify');

    Route::post('/verification-notification', function (Request $request) {
      $request->user()->sendEmailVerificationNotification();

      return back()->with('message', 'Verification link sent!');
    })->middleware(['auth', 'throttle:6,1'])->name('send');
  });

});
////////////////////////////////////////////////////////////////////////////////
//////// password reset routes
Route::get('/forgot-password', function () {
  return view('users.forgot-password');
})->middleware(['guest:web', 'guest:owner', 'guest:admin', 'guest:secretary', 'guest:garagist'])->name('password.request');

Route::post('/forgot-password', function (Request $request) {
    $request->validate(['email' => 'required|email']);
    $status = Password::sendResetLink(
        $request->only('email')
    );

    return $status === Password::RESET_LINK_SENT
                ? back()->with(['status' => __($status)])
                : back()->withErrors(['email' => __($status)]);
})->middleware(['guest:web', 'guest:owner', 'guest:admin', 'guest:secretary', 'guest:garagist'])->name('password.email');



Route::get('/reset-password/{token}', function ($token) {
  return view('users.reset-password', ['token' => $token]);
})->middleware(['guest:web', 'guest:owner', 'guest:admin', 'guest:secretary', 'guest:garagist'])->name('password.reset');


Route::post('/reset-password', function (Request $request) {
  $request->validate([
      'token' => 'required',
      'email' => 'required|email',
      'password' => 'required|min:6|regex:/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d).+$/|confirmed',
      // don't remove this it works just for developing i wanna make it easy so we use the line above
      // 'password' => ['required', Illuminate\Validation\Rules\Password::min(8)->mixedCase()->numbers()->uncompromised(),'confirmed'],
      'password_confirmation' => 'required|same:password'
  ]);

  $status = Password::reset(
      $request->only('email', 'password', 'password_confirmation', 'token'),
      function ($user, $password) {
          $user->forceFill([
              'password' => Hash::make($password)
          ])->setRememberToken(Str::random(60));

          $user->save();

          event(new PasswordReset($user));
      }
  );

  return $status === Password::PASSWORD_RESET
              ? redirect()->route('user.login')->with('status', __($status))
              : back()->withErrors(['email' => [__($status)]]);
})->middleware(['guest:web', 'guest:owner', 'guest:admin', 'guest:secretary', 'guest:garagist'])->name('password.update');



// users
Route::prefix('user')->name('user.')->group(function () {
  Route::middleware(['guest:web', 'guest:owner', 'guest:admin', 'guest:secretary', 'guest:garagist', 'PreventBackHistory'])->group(function () {
    Route::get('/', function () {return redirect(route('user.login'));});
    Route::view('/login', 'users.login')->name('login');
    Route::view('/register', 'users.register')->name('register');
    Route::post('/create', [UserController::class, 'create'])->name('create');
    Route::post('/check', [UserController::class, 'check'])->name('check');
    Route::get('/google', [GoogleController::class, 'loginWithGoogle'])->name('loginWithGoogle');
    Route::any('/google/login', [GoogleController::class, 'callbackFromGoogle'])->name('callback');
  });
  Route::middleware(['guest:owner', 'guest:admin', 'guest:secretary', 'guest:garagist', 'PreventBackHistory'])->group(function () {
    Route::get('/viewOffers', [VehiculeController::class, 'searchVehicules'])->name('viewOffers');
    Route::get('/offer/{plateNb}', [VehiculeController::class, 'viewOfferDetails'])->name('viewOfferDetails');
    Route::get('/filterVehicules',[VehiculeController::class,'filterVehicules'])->name('filterVehicules');
  });
  Route::middleware(['auth:web','verified', 'PreventBackHistory'])->group(function () {
    Route::view('/home', 'guestHome')->name('home');
    Route::post('/logout', [UserController::class, 'logout'])->name('logout');
    Route::post('/book', [VehiculeController::class, 'book'])->name('book');
    Route::get('/checkFace/{id}', [UserController::class, 'checkFace'])->name('checkFace');
    Route::get('/history', [UserController::class, 'getHistory'])->name('history');
    Route::get('/booking-details/{id}', [UserController::class, 'getBookingDetails'])->name('bookingDetails');
    Route::get('/download/{id}', [UserController::class, 'downloadPdf'])->name('downloadPdf');
    Route::post('/signContract/{id}', [UserController::class, 'signContract'])->name('signContract');
    Route::post('/declineContract/{id}', [UserController::class, 'declineContract'])->name('declineContract');
    Route::get('/loadNotifications', [UserController::class, 'loadNotifications'])->name('loadNotifications');
    Route::get('/editProfile',[UserController::class,'editProfile'])->name('editProfile');
    Route::post('/editProfile',[UserController::class,'editProfilePost'])->name('editProfilePost');
    Route::post('/checkPassword',[UserController::class,'checkPassword'])->name('checkPassword');
    Route::post('/changeImage',[UserController::class, 'changeImage'])->name('changeImage');
    Route::post('/setGoing',[UserController::class,'setGoing'])->name('setGoing');
    Route::post('/setFailed',[UserController::class,'setFailed'])->name('setFailed');
    Route::post('/sendComplaint',[UserController::class,'sendComplaint'])->name('sendComplaint');
    Route::post('/rateVehicle',[UserController::class,'rateVehicle'])->name('rateVehicle');
    Route::post('/rateAgency',[UserController::class,'rateAgency'])->name('rateAgency');
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
    Route::post('/changeImage',[OwnerController::class, 'changeImage'])->name('changeImage');
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
    Route::get('/dashboard',  function(){return redirect()->route('admin.joiningRequests');})->name('dashboard');
    Route::view('/joining-requests', 'admin.joiningRequests')->name('joiningRequests');
    Route::get('/joining-request', [AgencyController::class, 'getJoiningRequests'])->name('joiningRequests');
    Route::post('/accept-agency/{id}', [AgencyController::class, 'acceptAgency'])->name('acceptAgency');
    Route::post('/refuse-agency/{id}', [AgencyController::class, 'refuseAgency'])->name('refuseAgency');
    Route::view('/agencies-list', 'admin.agenciesList')->name('agenciesList');
    Route::get('/agencies-list', [AgencyController::class, 'getAgencies'])->name('getAgencies');
    Route::view('/users-list', 'admin.usersList')->name('usersList');
    Route::get('/users-list', [UserController::class, 'getUsersList'])->name('usersList');
    Route::get('/bans', [AdminController::class, 'loadBans'])->name('loadBans');
    Route::post('/logout', [AdminController::class, 'logout'])->name('logout');
    Route::post('/ban', [AdminController::class, 'banUser'])->name('ban');
    Route::post('/unban', [AdminController::class, 'unbanUser'])->name('unban');
  });
});
//secretaries
Route::prefix('secretary')->name('secretary.')->group(function () {
  Route::middleware(['guest:web', 'guest:owner', 'guest:admin', 'guest:secretary', 'guest:garagist', 'PreventBackHistory'])->group(function () {
    Route::get('/', function () {
      return redirect(route('workerLogin'));
    });
    Route::post('/check', [SecretaryController::class, 'check'])->name('check');
  });
  Route::middleware(['auth:secretary', 'PreventBackHistory'])->group(function () {
    Route::get('/home', function(){return redirect()->route('secretary.getReservationRequests');})->name('home');
    Route::get('/vehicles', [SecretaryController::class, 'showVehicules'])->name('showVehicules');
    Route::get('/editProfile', [SecretaryController::class, 'showProfile'])->name('showProfile');
    Route::post('/editProfile', [SecretaryController::class, 'editProfile'])->name('editProfile');
    Route::get('/addVehicule', [SecretaryController::class, 'addVehiculePage'])->name('addVehicule');
    Route::post('/addVehicule', [SecretaryController::class, 'addVehicule'])->name('addVehiculePost');
    Route::get('/vehicle/{id}', [SecretaryController::class, 'vehiculeDetails'])->name('vehiculeDetails');
    Route::post('/vehicle/{id}', [SecretaryController::class, 'deleteVehicule'])->name('deleteVehicule');
    Route::post('/vehicle1/{id}', [SecretaryController::class, 'updateState'])->name('updateState');
    Route::post('/vehicle-transfer/{id}', [SecretaryController::class, 'transferVehicle'])->name('transferVehicle');
    Route::get('/pick-up-locations', [AgencyController::class, 'getPickUpLocations'])->name('getPickUpLocations');
    Route::post('/pick-up-locations', [AgencyController::class, 'addPickUpLoaction'])->name('addPickUpLocation');
    Route::post('/logout', [SecretaryController::class, 'logout'])->name('logout');
    Route::get('/reservation-requests', [SecretaryController::class, 'getReservationRequests'])->name('getReservationRequests');
    Route::get('/reservationDetails/{id}', [SecretaryController::class, 'reservationDetails'])->name('reservationDetails');
    Route::post('/accept-booking/{id}', [BookingController::class, 'accept'])->name('acceptBooking');
    Route::post('/decline-booking/{id}', [BookingController::class, 'decline'])->name('declineBooking');
    Route::get('/history', [SecretaryController::class, "getHistory"])->name('history');
    Route::post('/setRating', [SecretaryController::class, 'setRating'])->name('setRating');
    Route::post('/banUser', [SecretaryController::class, 'banUser'])->name('banUser');
    Route::get('/testroute', [SecretaryController::class, 'test']);
    Route::post('/changeImage',[SecretaryController::class, 'changeImage'])->name('changeImage');
    Route::post('/setSeen',[SecretaryController::class, 'setSeen'])->name('setSeen');
  });
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
    Route::get('/home',  [GaragistController::class, 'home'])->name('home');
    Route::post('/logout', [GaragistController::class, 'logout'])->name('logout');
    Route::get('/editProfile', [GaragistController::class, 'showProfile'])->name('showProfile');
    Route::post('/editProfile', [GaragistController::class, 'editProfile'])->name('editProfile');
    Route::get('/vehicles', [GaragistController::class, 'showVehicles'])->name('vehicles');
    Route::get('/manageVehicle/{id}', [GaragistController::class, 'manageVehicle'])->name('manageVehicle');
    Route::post('/set-condition/{id}', [GaragistController::class, 'setCondition'])->name('setCondition');
    Route::get('/reservation', [GaragistController::class, 'getReservations'])->name('getReservations');
    Route::post('/changeImage',[GaragistController::class, 'changeImage'])->name('changeImage');
    Route::post('/validateReturn',[GaragistController::class, 'validateReturn'])->name('validateReturn');
  });
});

Route::any('{x}',function(){return "PAge doesnt exist";});