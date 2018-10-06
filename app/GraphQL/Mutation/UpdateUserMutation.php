<?php

namespace App\GraphQL\Mutation;

use GraphQL;
use GraphQL\Type\Definition\Type;
use Folklore\GraphQL\Support\Mutation;
use App\User;
use Illuminate\Validation\Rule;

class UpdateUserMutation extends Mutation
{
    protected $attributes = [
        'name' => 'updateUser'
    ];

    public function type()
    {
        return GraphQL::type('User');
    }

    public function args()
    {
        return [
            'id' => ['name' => 'id', 'type' => Type::string()],
            'name' => ['name' => 'name', 'type' => Type::string()],
            'email' => ['name' => 'email', 'type' => Type::string()],
            'password' => ['name' => 'password', 'type' => Type::string()]
        ];
    }

    public function rules()
    {
        $id = func_get_args()[1]["id"];

        return [
            'id' => ['required'],
            'name' => ['string'],
            'email' => ['email', Rule::unique('users')->ignore($id)],
            'password' => ['string']
        ];
    }

    public function resolve($root, $args)
    {
        $user = User::find($args['id']);

        if (!$user) {
            return null;
        }

        if (isset($args['name'])) $user->name = $args['name'];
        if (isset($args['email'])) $user->name = $args['email'];
        if (isset($args['password'])) $user->name = bcrypt($args['password']);

        $user->save();

        return $user;
    }
}