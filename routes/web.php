<?php

use App\Http\Controllers\AccountAccessController;
use App\Http\Controllers\AccountantPortalController;
use App\Http\Controllers\AnneescolaireController;
use App\Http\Controllers\ClasseController;
use App\Http\Controllers\CompanyController;
use App\Http\Controllers\EmploidutempsController;
use App\Http\Controllers\EtudiantController;
use App\Http\Controllers\EvaluationController;
use App\Http\Controllers\InscriptionController;
use App\Http\Controllers\MatierecoeficienController;
use App\Http\Controllers\MatiereController;
use App\Http\Controllers\NoteController;
use App\Http\Controllers\ParentPortalController;
use App\Http\Controllers\ProfesseurController;
use App\Http\Controllers\StudentPortalController;
use App\Http\Controllers\SystemSettingsController;
use App\Http\Controllers\TeacherPortalController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

Route::get('/', [UserController::class, 'loginform'])->name('login');
Route::post('/login', [UserController::class, 'loginstore'])->name('login.store');
Route::get('/register', [UserController::class, 'create'])->name('create.user');
Route::post('/register', [UserController::class, 'store'])->name('register.store');
Route::post('/logout', [UserController::class, 'logout'])->name('logout');

Route::middleware(['auth', 'role:professeur'])->prefix('professeur')->group(function () {
    Route::get('/dashboard', [TeacherPortalController::class, 'index'])->name('teacher.dashboard');
    Route::get('/evaluations/{evaluation}/notes', [TeacherPortalController::class, 'grades'])->name('teacher.grades');
    Route::post('/evaluations/{evaluation}/notes', [TeacherPortalController::class, 'saveGrades'])->name('teacher.grades.save');
});

Route::middleware(['auth', 'role:etudiant'])->group(function () {
    Route::get('/etudiant/dashboard', [StudentPortalController::class, 'index'])->name('student.dashboard');
});


Route::middleware(['auth', 'role:parent'])->prefix('parent')->group(function () {
    Route::get('/dashboard', [ParentPortalController::class, 'index'])->name('parent.dashboard');
    Route::get('/enfants/{etudiant}', [ParentPortalController::class, 'child'])
        ->whereNumber('etudiant')
        ->name('parent.child');
});

Route::middleware(['auth', 'role:comptable'])->prefix('comptable')->group(function () {
    Route::get('/dashboard', [AccountantPortalController::class, 'index'])->name('accountant.dashboard');
    Route::post('/paiements', [AccountantPortalController::class, 'storePayment'])->name('accountant.payment.store');
});

Route::middleware(['auth', 'role:admin'])->group(function () {
    Route::get('/dashboard', [UserController::class, 'dashboard'])->name('admin.dashboard');

    Route::get('/company', [CompanyController::class, 'edit'])->name('company.edit');
    Route::put('/company', [CompanyController::class, 'update'])->name('company.update');

    Route::get('/settings', [SystemSettingsController::class, 'index'])->name('settings.index');
    Route::post('/settings/clear/{type}', [SystemSettingsController::class, 'clear'])->name('settings.clear');
    Route::post('/settings/storage-link', [SystemSettingsController::class, 'storageLink'])->name('settings.storage-link');

    Route::get('/users', [UserController::class, 'index'])->name('users.index');
    Route::get('/users/create', [UserController::class, 'createAdmin'])->name('users.create');
    Route::post('/users', [UserController::class, 'storeAdmin'])->name('users.store');
    Route::get('/users/{user}', [UserController::class, 'show'])->whereNumber('user')->name('users.show');
    Route::get('/users/{user}/edit', [UserController::class, 'edit'])->whereNumber('user')->name('users.edit');
    Route::put('/users/{user}', [UserController::class, 'update'])->whereNumber('user')->name('users.update');
    Route::delete('/users/{user}', [UserController::class, 'destroy'])->whereNumber('user')->name('users.destroy');

    Route::get('/professeurs/{professeur}/compte', [AccountAccessController::class, 'professorForm'])->name('professeurs.account');
    Route::post('/professeurs/{professeur}/compte', [AccountAccessController::class, 'professorStore'])->name('professeurs.account.store');

    Route::get('/etudiants/{etudiant}/compte', [AccountAccessController::class, 'studentForm'])->name('etudiants.account');
    Route::post('/etudiants/{etudiant}/compte', [AccountAccessController::class, 'studentStore'])->name('etudiants.account.store');

    Route::resource('matieres', MatiereController::class);
    Route::resource('etudiants', EtudiantController::class);
    Route::resource('classes', ClasseController::class);
    Route::resource('evaluations', EvaluationController::class);
    Route::resource('notes', NoteController::class);

    Route::get('bulletin', [NoteController::class, 'bulletin'])->name('notes.bulletin');
    Route::get('bulletin/afficher', [NoteController::class, 'bulletinAfficher'])->name('notes.bulletin.afficher');

    Route::resource('emploi_du_temps', EmploidutempsController::class);
    Route::resource('professeurs', ProfesseurController::class);
    Route::resource('anneescolaire', AnneescolaireController::class);
    Route::resource('matiere_coeficients', MatierecoeficienController::class);

    Route::get('/inscriptions/create/{etudiant}', [InscriptionController::class, 'create'])->name('inscriptions.create');
    Route::post('/inscriptions', [InscriptionController::class, 'store'])->name('inscriptions.store');
    Route::get('/inscriptions', [InscriptionController::class, 'index'])->name('inscriptions.index');
    Route::delete('/inscriptions/{inscription}', [InscriptionController::class, 'destroy'])->name('inscriptions.destroy');
    Route::get('/inscriptions/{inscription}', [InscriptionController::class, 'show'])->name('inscriptions.show');
    Route::get('/inscriptions/{inscription}/edit', [InscriptionController::class, 'edit'])->name('inscriptions.edit');
    Route::put('/inscriptions/{inscription}', [InscriptionController::class, 'update'])->name('inscriptions.update');

    Route::get('emplois/fiche', [EmploidutempsController::class, 'fiche'])->name('emplois.fiche');
    Route::get('emplois/fiche/imprimer', [EmploidutempsController::class, 'imprimer'])->name('emplois.fiche.imprimer');
    Route::resource('emplois', EmploidutempsController::class);
});
