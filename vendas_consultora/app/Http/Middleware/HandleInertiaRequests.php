<?php

namespace App\Http\Middleware;

use Illuminate\Http\Request;
use Inertia\Middleware;

class HandleInertiaRequests extends Middleware
{
    /**
     * The root template that is loaded on the first page visit.
     *
     * @var string
     */
    // Ajustado para apontar para o seu layout personalizado dentro de resources/views/layouts/
    protected $rootView = 'layouts.inertia';

    /**
     * Determine the current asset version.
     */
    public function version(Request $request): ?string
    {
        return parent::version($request);
    }

    /**
     * Define the props that are shared by default.
     *
     * @return array<string, mixed>
     */
    public function share(Request $request): array
    {
        $user = $request->user();

        return [
            ...parent::share($request),
            'auth' => [
                // Filtramos os dados que vão para o Vue de forma segura
                'user' => $user ? [
                    'id'    => $user->id,
                    'nome'  => $user->nome, // Usando a propriedade 'nome' conforme seu banco
                    'cargo' => $user->cargo,
                ] : null,
            ],
        ];
    }
}