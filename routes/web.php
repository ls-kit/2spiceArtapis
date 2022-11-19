<?php

use App\Http\Controllers\TicketController;
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
| Middleware options can be located in `app/Http/Kernel.php`
|
*/

// Homepage Route
Route::group(['middleware' => ['web', 'checkblocked']], function () {
    Route::view('/', 'frontend.layout.app');
    Route::get('/', 'App\Http\Controllers\Frontend\HomeController@index')->name('home');
    // sort homepage
    Route::get('/sort-latest', 'App\Http\Controllers\Frontend\HomeController@getLatest')->name('home.latest');
    Route::get('/sort-view', 'App\Http\Controllers\Frontend\HomeController@getView')->name('home.view');
    Route::get('/sort-like', 'App\Http\Controllers\Frontend\HomeController@getLike')->name('home.like');

    Route::get('/single-content/{id}', 'App\Http\Controllers\Frontend\HomeController@singleVideo')->name('singleVideo');
    Route::get('/music', 'App\Http\Controllers\Frontend\HomeController@music')->name('music');
    Route::get('/comedy', 'App\Http\Controllers\Frontend\HomeController@comedy')->name('comedy');
    Route::get('/talent', 'App\Http\Controllers\Frontend\HomeController@talent')->name('talent');
    Route::get('/contact', 'App\Http\Controllers\Frontend\ContactController@index')->name('contactPage');
    Route::post('/send-message', 'App\Http\Controllers\Frontend\ContactController@sendEmail')->name('sendmail');
});

// Authentication Routes
Auth::routes();

// Public Routes
Route::group(['middleware' => ['web', 'activity', 'checkblocked']], function () {

    // Activation Routes
    Route::get('/activate', ['as' => 'activate', 'uses' => 'App\Http\Controllers\Auth\ActivateController@initial']);

    Route::get('/activate/{token}', ['as' => 'authenticated.activate', 'uses' => 'App\Http\Controllers\Auth\ActivateController@activate']);
    Route::get('/activation', ['as' => 'authenticated.activation-resend', 'uses' => 'App\Http\Controllers\Auth\ActivateController@resend']);
    Route::get('/exceeded', ['as' => 'exceeded', 'uses' => 'App\Http\Controllers\Auth\ActivateController@exceeded']);

    // Socialite Register Routes
    Route::get('/social/redirect/{provider}', ['as' => 'social.redirect', 'uses' => 'App\Http\Controllers\Auth\SocialController@getSocialRedirect']);
    Route::get('/social/handle/{provider}', ['as' => 'social.handle', 'uses' => 'App\Http\Controllers\Auth\SocialController@getSocialHandle']);

    // Route to for user to reactivate their user deleted account.
    Route::get('/re-activate/{token}', ['as' => 'user.reactivate', 'uses' => 'App\Http\Controllers\RestoreUserController@userReActivate']);
});

// Registered and Activated User Routes
Route::group(['middleware' => ['auth', 'activated', 'activity', 'checkblocked']], function () {

    // Activation Routes
    Route::get('/activation-required', ['uses' => 'App\Http\Controllers\Auth\ActivateController@activationRequired'])->name('activation-required');
    Route::get('/logout', ['uses' => 'App\Http\Controllers\Auth\LoginController@logout'])->name('logout');
});

// Registered and Activated User Routes
Route::group(['prefix' => 'admin', 'middleware' => ['auth', 'activated', 'activity', 'twostep', 'checkblocked']], function () {

    //  Dashboard Route - Redirect based on user role is in controller.
    Route::get('/home', ['as' => 'public.home',   'uses' => 'App\Http\Controllers\UserController@index']);
    //region Routes.
    // Route::get('region', [
    //     'as'   => 'public.region',
    //     'uses' => 'App\Http\Controllers\RegionController@index',
    // ]);

    // Upload Routes.
    Route::get('upload/index', [
        'as'   => 'public.upload.index',
        'uses' => 'App\Http\Controllers\UploadController@index',
    ]);
    Route::get('upload', [
        'as'   => 'public.upload',
        'uses' => 'App\Http\Controllers\UploadController@create',
    ]);
    Route::post('upload-store', [
        'as'   => 'public.upload.store',
        'uses' => 'App\Http\Controllers\UploadController@store',
    ]);
    Route::get('upload-edit/{id}', [
        'as'   => 'public.upload.edit',
        'uses' => 'App\Http\Controllers\UploadController@edit',
    ]);
    Route::put('upload-update/{id}', [
        'as'   => 'public.upload.update',
        'uses' => 'App\Http\Controllers\UploadController@update',
    ]);
    Route::get('upload-destroy/{id}', [
        'as'   => 'public.upload.destroy',
        'uses' => 'App\Http\Controllers\UploadController@destroy',
    ]);

    // Menu Routes.
    Route::get('menu', [
        'as'   => 'public.menu.index',
        'uses' => 'App\Http\Controllers\MenuController@index',
    ]);
    Route::get('menu-create', [
        'as'   => 'public.menu.create',
        'uses' => 'App\Http\Controllers\MenuController@create',
    ]);
    Route::post('menu-store', [
        'as'   => 'public.menu.store',
        'uses' => 'App\Http\Controllers\MenuController@store',
    ]);
    Route::get('menu-edit/{id}', [
        'as'   => 'public.menu.edit',
        'uses' => 'App\Http\Controllers\MenuController@edit',
    ]);
    Route::put('menu-update/{id}', [
        'as'   => 'public.menu.update',
        'uses' => 'App\Http\Controllers\MenuController@update',
    ]);
    Route::get('menu-destroy/{id}', [
        'as'   => 'public.menu.destroy',
        'uses' => 'App\Http\Controllers\MenuController@destroy',
    ]);

    //category wise view
    Route::get('music', [
        'as'   => 'public.music',
        'uses' => 'App\Http\Controllers\UploadController@getMusic',
    ]);
    Route::get('comedy', [
        'as'   => 'public.comedy',
        'uses' => 'App\Http\Controllers\UploadController@comedy',
    ]);
    Route::get('talent', [
        'as'   => 'public.talent',
        'uses' => 'App\Http\Controllers\UploadController@talent',
    ]);

    //category
    Route::resource('category', \App\Http\Controllers\CategoryController::class, [
        'names' => [
            'index'   => 'categories',
            'create'   => 'categories.create',
            'store'   => 'categories.store',
            'edit'   => 'categories.edit',
            'update'   => 'categories.update',
            'destroy' => 'categories.destroy',

        ],
        'except' => [
            'deleted',
        ],
    ]);

    //Comments Route:
    Route::post('/comment/store', [
        'as'   => 'comment.add',
        'uses' => 'App\Http\Controllers\CommentController@store',
    ]);

    //like Route
    Route::get('like/{id}', [
        'as'   => 'like',
        'uses' => 'App\Http\Controllers\LikeController@store',
    ]);
    Route::get('unlike/{id}', [
        'as'   => 'unlike',
        'uses' => 'App\Http\Controllers\LikeController@unlike',
    ]);
    //follow Route
    Route::get('follow/{id}', [
        'as'   => 'public.follow',
        'uses' => 'App\Http\Controllers\LikeController@follow',
    ]);
    Route::get('unfollow/{id}', [
        'as'   => 'public.unfollow',
        'uses' => 'App\Http\Controllers\LikeController@unfollow',
    ]);

    // Show users profile - viewable by other users.
    Route::get('profile/{username}', [
        'as'   => '{username}',
        'uses' => 'App\Http\Controllers\ProfilesController@show',
    ]);
    // Ticket
    Route::resource('ticket', TicketController::class);
    Route::post('ticket/reply/{id}', 'App\Http\Controllers\TicketReplyController@store')->name('adminticket.reply.store');
    // Referral System
    Route::get('referral', 'App\Http\Controllers\ReferralController@index')->name('referrallist');
});
// Referral redirect link
Route::get('/referrel-redirect/link', 'App\Http\Controllers\ReferralController@refereellink')->name('refereellink')->middleware('referral');

// Registered, activated, and is current user routes.
Route::group(['middleware' => ['auth', 'activated', 'currentUser', 'activity', 'twostep', 'checkblocked']], function () {

    // User Profile and Account Routes
    Route::resource(
        'profile',
        \App\Http\Controllers\ProfilesController::class,
        [
            'only' => [
                'show',
                'edit',
                'update',
                'create',
            ],
        ]
    );
    Route::put('profile/{username}/updateUserAccount', [
        'as'   => '{username}',
        'uses' => 'App\Http\Controllers\ProfilesController@updateUserAccount',
    ]);
    Route::put('profile/{username}/updateUserPassword', [
        'as'   => '{username}',
        'uses' => 'App\Http\Controllers\ProfilesController@updateUserPassword',
    ]);
    Route::delete('profile/{username}/deleteUserAccount', [
        'as'   => '{username}',
        'uses' => 'App\Http\Controllers\ProfilesController@deleteUserAccount',
    ]);

    // Route to show user avatar
    Route::get('images/profile/{id}/avatar/{image}', [
        'uses' => 'App\Http\Controllers\ProfilesController@userProfileAvatar',
    ]);

    // Route to upload user avatar.
    Route::post('avatar/upload', ['as' => 'avatar.upload', 'uses' => 'App\Http\Controllers\ProfilesController@upload']);
    // Ticket in user label
    Route::get('ticket/create', 'App\Http\Controllers\Frontend\UserticketController@create')->name('user.ticket.create');
    Route::post('ticket/create', 'App\Http\Controllers\Frontend\UserticketController@store')->name('user.ticket.store');
    Route::get('tickets', 'App\Http\Controllers\Frontend\UserticketController@index')->name('user.ticket.index');
    Route::get('ticket/{id}', 'App\Http\Controllers\Frontend\UserticketController@show')->name('user.ticket.show');
    Route::post('ticket/reply/{id}', 'App\Http\Controllers\Frontend\UserticketController@replyStore')->name('user.ticket.reply.store');
    // Sell Music
    Route::get('sell-list', 'App\Http\Controllers\Frontend\UsersellController@sellsList')->name('user.sellslist');
});

// Registered, activated, and is admin routes.
Route::group(['middleware' => ['auth', 'activated', 'role:admin', 'activity', 'twostep', 'checkblocked']], function () {
    Route::resource('/users/deleted', \App\Http\Controllers\SoftDeletesController::class, [
        'only' => [
            'index', 'show', 'update', 'destroy',
        ],
    ]);

    Route::resource('users', \App\Http\Controllers\UsersManagementController::class, [
        'names' => [
            'index'   => 'users',
            'destroy' => 'user.destroy',
        ],
        'except' => [
            'deleted',
        ],
    ]);

    Route::post('search-users', 'App\Http\Controllers\UsersManagementController@search')->name('search-users');

    Route::resource('themes', \App\Http\Controllers\ThemesManagementController::class, [
        'names' => [
            'index'   => 'themes',
            'destroy' => 'themes.destroy',
        ],
    ]);

    // Site Settings Route.
    Route::get('site/settings', [
        'as'   => 'site.settings',
        'uses' => 'App\Http\Controllers\SiteSettingController@index',
    ]);
    Route::post('site/settings', [
        'as'   => 'site.settings.store',
        'uses' => 'App\Http\Controllers\SiteSettingController@store',
    ]);


    Route::get('logs', '\Rap2hpoutre\LaravelLogViewer\LogViewerController@index');
    Route::get('routes', 'App\Http\Controllers\AdminDetailsController@listRoutes');
    Route::get('active-users', 'App\Http\Controllers\AdminDetailsController@activeUsers');
});
Auth::routes();
Route::redirect('/php', '/phpinfo', 301);
// For Get Location/Region
Route::get('/location/get-location', 'App\Http\Controllers\Frontend\LocationController@getLocation')->name('getlocation');
Route::get('/search', 'App\Http\Controllers\Frontend\SearchController@index')->name('search');
Route::get('/ajax/search/{keyword}', 'App\Http\Controllers\Frontend\SearchController@ajaxSearch')->name('search.ajax');
Route::get('/ajax/autoplay', 'App\Http\Controllers\Frontend\HomeController@autoplayChange')->name('autoplay');
// Buy Now
Route::get('buy-now/{id}', 'App\Http\Controllers\Frontend\UserbuyController@buyNowPage')->name('user.buynow')->middleware('auth');
Route::post('buy-now/{id}', 'App\Http\Controllers\Frontend\UserbuyController@buyNow')->name('user.buynow.store')->middleware('auth');
// Download
Route::get('download/{id}', 'App\Http\Controllers\Frontend\HomeController@download')->name('user.download')->middleware('auth');
// Like/Unlike
Route::get('video/like/{id}', 'App\Http\Controllers\Frontend\SinglevideoController@like')->name('user.like');
// Follow/Unlfollow
Route::get('/author/follow/{id}', 'App\Http\Controllers\Frontend\SinglevideoController@follow')->name('user.follow');
// Store Comment
Route::post('/comment-store/', 'App\Http\Controllers\CommentController@storeComment')->name('comment.store');
Route::post('/comment-store-reply/', 'App\Http\Controllers\CommentController@replyStoreComment')->name('comment.replyStoreComment');
// Get Comment
Route::get('/get-comment/{id}', 'App\Http\Controllers\CommentController@getComment')->name('comment.get');
// Delete Comment
Route::get('/comment-delete/{id}', 'App\Http\Controllers\CommentController@delComment')->name('comment.delete');
// Channel content
Route::get('channel/{id}', 'App\Http\Controllers\Frontend\ChannelpageController@channelpage')->name('channelpage');

Auth::routes();

Route::get('admin/home', 'HomeController@index')->name('home');
