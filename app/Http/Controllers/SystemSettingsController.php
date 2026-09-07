<?php

namespace App\Http\Controllers;

use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use Illuminate\View\View;

class SystemSettingsController extends Controller
{
    public function index(): View
    {
        return view('admin.settings.index', [
            'user' => Auth::user(),
            'company' => Auth::user()->company,
            'phpVersion' => PHP_VERSION,
            'laravelVersion' => app()->version(),
            'environment' => app()->environment(),
            'debug' => config('app.debug'),
            'cacheStore' => config('cache.default'),
            'sessionDriver' => config('session.driver'),
            'queueConnection' => config('queue.default'),
        ]);
    }

    public function clear(string $type): RedirectResponse
    {
        $commands = [
            'optimize' => 'optimize:clear',
            'cache' => 'cache:clear',
            'config' => 'config:clear',
            'route' => 'route:clear',
            'view' => 'view:clear',
            'event' => 'event:clear',
        ];

        abort_unless(isset($commands[$type]), 404);

        Artisan::call($commands[$type]);

        return back()->with('success', match ($type) {
            'optimize' => 'Tous les caches Laravel ont été nettoyés.',
            'cache' => 'Le cache applicatif a été vidé.',
            'config' => 'Le cache de configuration a été vidé.',
            'route' => 'Le cache des routes a été vidé.',
            'view' => 'Le cache des vues a été vidé.',
            'event' => 'Le cache des événements a été vidé.',
        });
    }

    public function storageLink(): RedirectResponse
    {
        if (!is_link(public_path('storage')) && !File::exists(public_path('storage'))) {
            Artisan::call('storage:link');
            return back()->with('success', 'Le lien public/storage a été créé.');
        }

        return back()->with('success', 'Le lien public/storage existe déjà.');
    }
}
