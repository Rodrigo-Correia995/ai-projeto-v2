<?php

namespace App\Policies;

use App\Models\User;

class UserPolicy
{
    /**
     * Create a new policy instance.
     */
    public function __construct()
    {
        //
    }

    public function before(?User $user, string $ability): bool|null
    {
        if ($user?->type === 'board') {
            return true;
        }
        return null;
    }

    // Apenas funcionários e administradores (board) podem ver a lista de utilizadores
    public function viewAny(User $user): bool
    {
        return in_array($user->type, ['employee', 'board']);
    }

    // Um utilizador pode ver o seu próprio perfil
    // Funcionários e administradores podem ver o perfil de qualquer um
    public function view(User $user, User $model): bool
    {
        return $user->id === $model->id || in_array($user->type, ['employee', 'board']);
    }

    // Apenas administradores podem criar novos utilizadores (ex: registar novo funcionário)
    //public function create(User $user): bool
    //{
     //   return $user->type === 'board';
    //}

    // Funcionários e administradores podem editar membros
    // Cada utilizador pode editar o seu próprio perfil (com limites definidos no Controller)
    public function update(User $user, User $model): bool
    {
        return $user->id === $model->id || $user->type === 'board';
    }

    public function delete(User $user, User $model): bool
    {
        return $user->type === 'board';
    }
}
