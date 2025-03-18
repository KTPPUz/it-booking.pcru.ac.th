<?php

use App\Http\Controllers\EquipmentGroupController;
use Illuminate\Support\Facades\Route;
use Carbon\Carbon;

use App\Http\Controllers\BookingController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\RoomController;
use App\Http\Controllers\BookingRoomController;
use App\Http\Controllers\SectsController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\StaffUsersController;
use App\Http\Controllers\ReviewController;
use App\Http\Controllers\AssetTypeController;
use App\Http\Controllers\AssetGroupController;
use App\Http\Controllers\AssetController;
use App\Http\Controllers\AssetLocationController;
use App\Http\Controllers\ImageController;
use App\Http\Controllers\UserBookingController;
// use App\Http\Controllers\LoginController;
use App\Http\Controllers\GoogleCalendarController;


use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Response;

Route::get('/', function () {
    $events = HomeController::fetchEvent();

    $schedules = BookingRoomController::showcalendar();
    $rooms = RoomController::searchroom();
    return view('welcome', ['events' => $events, 'schedules' => $schedules , 'rooms' => $rooms]);
})->name('welcome');

// Route::get('/bookingroom/{id}', function ($id) {
//     $schedules = BookingRoomController::showcalendar($id);
//     // $rooms = RoomController::searchroom();

//     return view('bookingroom.modalcalender', ['schedules' => $schedules  ]);
// })->name('bookingroom.show');


Auth::routes();

// Authentication Routes
Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('/login', [LoginController::class, 'login'])->name('login.submit');
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');
Route::post('/staff/logout', [LoginController::class, 'staffLogout'])->name('staff.logout');

// Home Routes
Route::get('/home', [HomeController::class, 'index'])->name('home');
Route::get('/fetch-event', [HomeController::class, 'fetchEvent'])->name('fetch.event');
// Route::get('/check-available-rooms', [RoomController::class, 'checkAvailableRooms'])->name('rooms.checkAvailable');


Route::get('img/{filename}', function ($filename) {
    $path = public_path('img/' . $filename);

    if (!File::exists($path)) {
        abort(404); // ถ้าไฟล์ไม่พบ ให้แสดง 404
    }

    $file = File::get($path);
    $type = File::mimeType($path);

    return response($file, 200)->header("Content-Type", $type);
});

Route::get('/images/{filename}', [RoomController::class, 'showImageRoom'])->name('room.image');
Route::get('/images/{filename}', [RoomController::class, 'showImage'])->name('room.image');
Route::get('/rooms/search', [RoomController::class, 'search'])->name('rooms.search');
Route::get('/room/show', [RoomController::class, 'show'])->name('rooms.show');
Route::get('/room/detail/{id}', [RoomController::class, 'detail'])->name('rooms.detail');
Route::get('/room/check-available-rooms', [RoomController::class, 'checkAvailableRooms'])->name('rooms.checkAvailable');


// Staff Routes
Route::middleware('auth:staff')->group(function () {
    Route::get('/staff', [StaffUsersController::class, 'index'])->name('staff.index');
    Route::get('/staff/homestaff', [StaffUsersController::class, 'homestaff'])->name('staff.homestaff');
    Route::get('/staff/create', [StaffUsersController::class, 'create'])->name('staff.create');
    Route::post('/staff/store', [StaffUsersController::class, 'store'])->name('staff.store');
    Route::get('/staff/{id}/edit', [StaffUsersController::class, 'edit'])->name('staff.edit');
    Route::put('/staff/{id}', [StaffUsersController::class, 'update'])->name('staff.update');
    Route::delete('/staff/{id}', [StaffUsersController::class, 'destroy'])->name('staff.destroy');
    // Route::get('/staff/review', [ReviewController::class, 'index_pending'])->name('staff.review');
    Route::get('/staff/bookingall', [StaffUsersController::class, 'index_all'])->name('staff.bookingall');

    Route::get('/staff/statistics', [StaffUsersController::class, 'statistics'])->name('staff.statistics');

});

// Booking Routes
Route::middleware('auth')->group(function () {
    Route::get('/booking', [BookingController::class, 'index'])->name('bookings');
    Route::get('/booking/create', [BookingController::class, 'create'])->name('bcreate');
    Route::post('/booking/store', [BookingController::class, 'store'])->name('bstore');
    Route::get('/booking/{id}/edit', [BookingController::class, 'edit'])->name('booking.edit');
    Route::put('/booking/{id}', [BookingController::class, 'update'])->name('bupdate');
    Route::delete('/booking/{id}', [BookingController::class, 'destroy'])->name('bdestroy');

    // Booking POST Routes
    Route::post('/booking/send', [BookingController::class, 'send'])->name('booking.send');
    Route::post('/booking/unsent', [BookingController::class, 'unsent'])->name('booking.unsent');
    Route::patch('/booking/{id}/cancel', [BookingController::class, 'cancel'])->name('booking.cancel');

});

// Staff Routes
Route::middleware('auth:staff')->group(function () {
    Route::get('/room', [RoomController::class, 'index'])->name('rooms');
    Route::get('/room/create', [RoomController::class, 'create'])->name('rooms.create');
    Route::post('/room/store', [RoomController::class, 'store'])->name('rooms.store');
    Route::get('/room/{id}/edit', [RoomController::class, 'edit'])->name('rooms.edit');
    Route::put('/room/{id}', [RoomController::class, 'update'])->name('rooms.update');
    Route::delete('/room/{id}', [RoomController::class, 'destroy'])->name('roomsdestroy');
    Route::get('/room/roomasset/{id}', [RoomController::class, 'roomasset'])->name('room.roomasset');

    Route::get('/review/index', [ReviewController::class, 'index_pending'])->name('review.index');
    Route::get('/review/indexsuccess', [ReviewController::class, 'index_success'])->name('review.indexsuccess');
    Route::patch('/booking/review/{id}', [BookingController::class, 'review'])->name('booking.review');

    Route::resource('assettype', AssetTypeController::class);
    Route::resource('assetgroup', AssetGroupController::class);
    Route::resource('assets', AssetController::class);
    Route::resource('assetlocation', AssetLocationController::class);

    Route::get('/asset', [AssetController::class, 'index'])->name('assets.index');

    Route::get('/equipmentgroup', [EquipmentGroupController::class, 'index'])->name('equipment_groups.index');
});

// Booking Room Routes
Route::get('/bookingroom', [BookingRoomController::class, 'index'])->name('bookingroomm');

Route::middleware('auth:web')->group(function () {
    Route::get('/bookingroom', [BookingRoomController::class, 'index'])->name('bookingroom');
    Route::get('/bookingroom/create', [BookingRoomController::class, 'create'])->name('bookingroom.create');
    Route::post('/bookingroom/{id}/store', [BookingRoomController::class, 'store'])->name('bookingroom.store');
    Route::get('/bookingroom/{id}/edit', [BookingRoomController::class, 'edit'])->name('bookingroom.edit');
    Route::put('/bookingroom/{id}', [BookingRoomController::class, 'update'])->name('bookingroom.update');
    Route::delete('/booking/{booking_id}/{no}/destroy', [BookingRoomController::class, 'destroy'])->name('bkdestroy');

    Route::get('/bookingroom/newcreate/{booking_id}', [BookingController::class, 'newcreate'])->name('br.newcreate');
    Route::get('/booking/newbooking/{room_id}/{id?}', [BookingController::class, 'newbooking'])->name('br.newbooking');
    Route::get('/booking/newbookingc/{id?}', [BookingController::class, 'newbookingc'])->name('br.newbookingc');
    Route::put('/booking', [BookingController::class, 'newupdate'])->name('br.newupdate');
    Route::get('/booking/bookingalluser', [BookingController::class, 'indexuser'])->name('br.bookingalluser');

    // Route::get('/bookingroom/newbooking/{booking_id}', [BookingRoomController::class, 'newbooking'])->name('br.newbooking');
    // Route::get('/bookingroom/newbookingrooms', [BookingRoomController::class, 'newbookingrooms'])->name('br.newbookingrooms');

    // UserBookingController
    Route::get('/userbooking/show', [UserBookingController::class, 'show'])->name('userbooking.show');
    Route::post('/userbooking/{roomId}/add-to-booking', [UserBookingController::class, 'addToBooking'])->name('userbooking.addToBooking');
    Route::delete('/userbooking/{roomId}/remove-from-booking', [UserBookingController::class, 'removeFromBooking'])->name('userbooking.removeFromBooking');
    Route::post('/userbooking/confirm-booking', [UserBookingController::class, 'confirmBooking'])->name('userbooking.confirm');
});

Route::get('/calendar', function () {
    return view('calendar');
});

// Sects Routes
Route::get('/get-sects/{department_code}', [SectsController::class, 'getSects'])->name('getSects');
Route::post('/fetch-sects/{department_code}', [AssetLocationController::class, 'getSects'])->name('assetlocation.fetch');

// // Keycloak Routes
// Route::get('sso', 'App\Http\Controllers\LoginController@redirectToKeycloak')->name('login.keycloak');
// Route::get('sso/callback', 'App\Http\Controllers\LoginController@handleKeycloakCallback')->name('login.keycloak');

Route::get('sso', function () {
    return Socialite::driver('keycloak')->redirect();
})->name('login.keycloak');

Route::get('sso/callback', function () {
    $user = Socialite::driver('keycloak')->user();
    if ($user) {
        $q = User::where('user_code', $user->user['preferred_username'])->first();
        if ($q) {
            Auth::login($q);
            return redirect()->route('welcome');
        }
        echo 'User not found';
        // return redirect()->route('login.keycloak', ['error' => 'User not found']);
    }
    return redirect()->route('login.keycloak', ['error' => 'User not found']);
});


Route::get('/sync-calendar', [GoogleCalendarController::class, 'syncRoomScheduleToGoogleCalendar']);
Route::get('/get-calendar-events', [GoogleCalendarController::class, 'getEventsFromGoogleCalendar']);

Route::get('/test-google-calendar', function () {
    $client = new \Google_Client();
    $client->setAuthConfig(storage_path('app/google-calendar/service-account-credentials.json'));
    $client->addScope(\Google_Service_Calendar::CALENDAR);

    $service = new \Google_Service_Calendar($client);

    $event = new \Google_Service_Calendar_Event([
        'summary' => 'ทดสอบการเชื่อมต่อ Google Calendar',
        'start' => ['dateTime' => Carbon::now()->addHour()->toRfc3339String()],
        'end' => ['dateTime' => Carbon::now()->addHours(2)->toRfc3339String()],
    ]);

    $calendarId = 'primary';
    $event = $service->events->insert($calendarId, $event);

    return "Event ถูกเพิ่มใน Google Calendar แล้ว!";
});