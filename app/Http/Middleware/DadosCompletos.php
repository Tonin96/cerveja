<?php

namespace App\Http\Middleware;

use App\Http\Services\PessoaService;
use Closure;
use Illuminate\Support\Facades\Auth;

class DadosCompletos {
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \Closure $next
     * @return mixed
     */

    private $pessoa_service;

    public function __construct(PessoaService $pessoa_service) {
        $this->pessoa_service = $pessoa_service;
    }

    public function handle($request, Closure $next) {

        $pessoa = $this->pessoa_service->getByUsuarioId(Auth::id());
        if (!empty($pessoa->email) && !empty($pessoa->cpf) && !empty($pessoa->telefone) && !empty($pessoa->data_nascimento)) {
            return $next($request);
        }

        return redirect(route("pessoa.meusDados"));
    }
}
