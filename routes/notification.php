<?php 

use App\Http\Controllers\NotificationController;
use Illuminate\Support\Facades\Route;

Route::get('/notifications', [NotificationController::class, 'index'])->name('notifications.index');
Route::patch('/notifications/{id}/read', [NotificationController::class, 'markAsRead'])->name('notifications.read');
//  Tambahkan baris ini untuk notifikasi dropdown AJAX
Route::get('/notifications/latest', [NotificationController::class, 'latest'])->name('notifications.latest');

?>
