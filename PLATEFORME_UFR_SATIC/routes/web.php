<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\Public\AccueilController;
use App\Http\Controllers\Public\PresentationController;
use App\Http\Controllers\Public\DepartementController;
use App\Http\Controllers\Public\PersonnelController;
use App\Http\Controllers\Public\ActualiteController;
use App\Http\Controllers\Public\ContactController;

// ── Pages publiques ───────────────────────────────────────────
Route::get('/', [AccueilController::class, 'index'])->name('accueil');
Route::get('/presentation', [PresentationController::class, 'index'])->name('presentation');
Route::get('/departements', [DepartementController::class, 'index'])->name('departements');
Route::get('/departements/{slug}', [DepartementController::class, 'show'])->name('departements.show');
Route::get('/personnel', [PersonnelController::class, 'index'])->name('personnel');
Route::get('/actualites', [ActualiteController::class, 'index'])->name('actualites');
Route::get('/actualites/{slug}', [ActualiteController::class, 'show'])->name('actualites.show');
Route::get('/contact', [ContactController::class, 'index'])->name('contact');
Route::post('/contact', [ContactController::class, 'store'])->name('contact.store');

// ── Authentification ──────────────────────────────────────────
Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthenticatedSessionController::class, 'create'])->name('login');
    Route::post('/login', [AuthenticatedSessionController::class, 'store']);
});

Route::post('/logout', [AuthenticatedSessionController::class, 'destroy'])
     ->middleware('auth')->name('logout');

// ── Espace Administrateur ─────────────────────────────────────
Route::middleware(['auth', 'role:administrateur', 'etat.compte'])
     ->prefix('admin')->name('admin.')
     ->group(function () {
         Route::get('/dashboard', function () {
             return view('admin.dashboard');
         })->name('dashboard');
     });

// ── Espace Enseignant ─────────────────────────────────────────
Route::middleware(['auth', 'role:enseignant', 'etat.compte'])
     ->prefix('enseignant')->name('enseignant.')
     ->group(function () {
         Route::get('/dashboard', [App\Http\Controllers\Enseignant\DashboardController::class, 'index'])->name('dashboard');
         Route::get('/cours', [App\Http\Controllers\Enseignant\CoursController::class, 'index'])->name('cours');
         Route::get('/cours/creer', [App\Http\Controllers\Enseignant\CoursController::class, 'create'])->name('cours.create');
         Route::post('/cours', [App\Http\Controllers\Enseignant\CoursController::class, 'store'])->name('cours.store');
         Route::get('/cours/{id}/modifier', [App\Http\Controllers\Enseignant\CoursController::class, 'edit'])->name('cours.edit');
         Route::put('/cours/{id}', [App\Http\Controllers\Enseignant\CoursController::class, 'update'])->name('cours.update');
         Route::post('/cours/{id}/publier', [App\Http\Controllers\Enseignant\CoursController::class, 'publier'])->name('cours.publier');
         Route::post('/cours/{id}/archiver', [App\Http\Controllers\Enseignant\CoursController::class, 'archiver'])->name('cours.archiver');
         Route::delete('/cours/{id}', [App\Http\Controllers\Enseignant\CoursController::class, 'destroy'])->name('cours.destroy');
         Route::get('/profil', [App\Http\Controllers\Enseignant\ProfilController::class, 'index'])->name('profil');
         Route::put('/profil', [App\Http\Controllers\Enseignant\ProfilController::class, 'update'])->name('profil.update');
     });

// ── Espace PATS ───────────────────────────────────────────────
Route::middleware(['auth', 'role:pats', 'etat.compte'])
     ->prefix('pats')->name('pats.')
     ->group(function () {
         Route::get('/dashboard', [App\Http\Controllers\Pats\DashboardController::class, 'index'])->name('dashboard');
         Route::get('/demandes', [App\Http\Controllers\Pats\DemandeController::class, 'index'])->name('demandes');
         Route::get('/demandes/{id}', [App\Http\Controllers\Pats\DemandeController::class, 'show'])->name('demandes.show');
         Route::post('/demandes/{id}/traiter', [App\Http\Controllers\Pats\DemandeController::class, 'traiter'])->name('demandes.traiter');
         Route::post('/demandes/{id}/valider', [App\Http\Controllers\Pats\DemandeController::class, 'valider'])->name('demandes.valider');
         Route::post('/demandes/{id}/rejeter', [App\Http\Controllers\Pats\DemandeController::class, 'rejeter'])->name('demandes.rejeter');
         Route::get('/demandes/{id}/pdf', [App\Http\Controllers\Pats\DemandeController::class, 'genererPdf'])->name('demandes.pdf');
         Route::get('/profil', [App\Http\Controllers\Pats\ProfilController::class, 'index'])->name('profil');
         Route::put('/profil', [App\Http\Controllers\Pats\ProfilController::class, 'update'])->name('profil.update');
     });

// ── Espace Étudiant ───────────────────────────────────────────
Route::middleware(['auth', 'role:etudiant', 'etat.compte'])
     ->prefix('etudiant')->name('etudiant.')
     ->group(function () {
         Route::get('/dashboard', [App\Http\Controllers\Etudiant\DashboardController::class, 'index'])->name('dashboard');
         Route::get('/cours', [App\Http\Controllers\Etudiant\CoursController::class, 'index'])->name('cours');
         Route::get('/cours/{id}/telecharger', [App\Http\Controllers\Etudiant\CoursController::class, 'telecharger'])->name('cours.telecharger');
         Route::get('/emploi-du-temps', [App\Http\Controllers\Etudiant\EmploiDuTempsController::class, 'index'])->name('emploi-du-temps');
         Route::get('/demandes', [App\Http\Controllers\Etudiant\DemandeController::class, 'index'])->name('demandes');
         Route::get('/demandes/creer', [App\Http\Controllers\Etudiant\DemandeController::class, 'create'])->name('demandes.create');
         Route::post('/demandes', [App\Http\Controllers\Etudiant\DemandeController::class, 'store'])->name('demandes.store');
         Route::get('/demandes/{id}', [App\Http\Controllers\Etudiant\DemandeController::class, 'show'])->name('demandes.show');
         Route::get('/notifications', [App\Http\Controllers\Etudiant\NotificationController::class, 'index'])->name('notifications');
         Route::post('/notifications/{id}/lire', [App\Http\Controllers\Etudiant\NotificationController::class, 'marquerLue'])->name('notifications.lire');
         Route::get('/profil', [App\Http\Controllers\Etudiant\ProfilController::class, 'index'])->name('profil');
         Route::put('/profil', [App\Http\Controllers\Etudiant\ProfilController::class, 'update'])->name('profil.update');
     });