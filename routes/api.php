use App\Http\Controllers\CallbackController;

// URL-nya nanti jadi: namadomain.com/api/midtrans-callback
Route::post('/midtrans-callback', [CallbackController::class, 'midtransCallback']);