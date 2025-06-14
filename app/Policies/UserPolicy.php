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
    //board e admin pode fazer tudo
    public function before(?User $user, string $ability): bool|null
    {
        if ($user?->type === 'board') {
            return true;
        }
        return null;
    }

    // lista de utilizadores só pod ser vista por emplyee e board
    public function viewAny(User $user): bool
    {
        return in_array($user->type, ['employee', 'board']);
    }

    // o tilizafor pode ver o seu próprio perfil
    // emplye e bord podem ver todos
    public function view(User $user, User $model): bool
    {
        return $user->id === $model->id || in_array($user->type, ['employee', 'board']);
    }

    // função daria permissão de criação de user ao admin mas no caso do trabalho não faz sentido a implementação
    //public function create(User $user): bool
    //{
     //   return $user->type === 'board';
    //}

    // o update apenas pode ser feito pelo proprio e pelo bord member
    public function update(User $user, User $model): bool
    {
        return $user->id === $model->id || $user->type === 'board';
    }
    // apenas o bord member pode fazer delete aos users
    public function delete(User $user, User $model): bool
    {
        return $user->type === 'board';
    }
}
