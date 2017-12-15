<?php

namespace App\Http\Controllers\Auth;


use App\Http\Controllers\Controller;
use App\Http\Services\PessoaService;
use App\Models\Pessoa;
use App\User;
use Illuminate\Support\Facades\Auth;

;

use Laravel\Socialite\Facades\Socialite;


class AuthController extends Controller {
    // Some methods which were generated with the app

    private $redirectTo = '/';
    private $pessoa_service;

    public function __construct(PessoaService $pessoa_service) {
        $this->pessoa_service = $pessoa_service;
    }

    /**
     * Redirect the user to the OAuth Provider.
     *
     * @return Response
     */
    public function redirectToProvider($provider) {
        return Socialite::driver($provider)->redirect();
    }

    /**
     * Obtain the user information from provider.  Check if the user already exists in our
     * database by looking up their provider_id in the database.
     * If the user exists, log them in. Otherwise, create a new user then log them in. After that
     * redirect them to the authenticated users homepage.
     *
     * @return Response
     */
    public function handleProviderCallback($provider) {
        $user = Socialite::driver($provider)->user();

        $authUser = $this->findOrCreateUser($user, $provider);
        Auth::login($authUser, true);
        session(['admin' => $authUser->administrador]);
        session(['image_profile' => $user['image']['url']]);
        session(['primeiro_nome' => $user['name']['givenName']]);
        session(['pessoa_id' => $this->pessoa_service->getByUsuarioId($authUser->id)->id]);
        return redirect($this->redirectTo);
    }

    /**
     * If a user has registered before using social auth, return the user
     * else, create a new user object.
     * @param  $user Socialite user object
     * @param $provider Social auth provider
     * @return  User
     */
    public function findOrCreateUser($user, $provider) {
        $authUser = User::where('provider_id', $user->id)->first();
        if ($authUser) {
            return $authUser;
        }

        $usuario = User::create([
            'email' => $user->email,
            'provider' => $provider,
            'provider_id' => $user->id
        ]);

        Pessoa::create([
           'nome' => $user->name,
            'email' => $user->email,
            'usuario_id' => $usuario->id
        ]);

        return $usuario;
    }
}