<?php

namespace App\GraphQL\Query;

use GraphQL;
use GraphQL\Type\Definition\Type;
use Folklore\GraphQL\Support\Query;
use App\User;
use GraphQL\Type\Definition\ResolveInfo;
use Illuminate\Support\Facades\Schema;

class UsersQuery extends Query
{
    protected $attributes = [
        'name' => 'users'
    ];

    public function type()
    {
        return Type::listOf(GraphQL::type('User'));
    }

    public function args()
    {
        return [
            'id' => ['name' => 'id', 'type' => Type::string()],
            'name' => ['name' => 'name', 'type' => Type::string()],
            'email' => ['name' => 'email', 'type' => Type::string()],
            'updated_at' => ['name' => 'updated_at', 'type' => Type::string()]
        ];
    }

    public function resolve($root, $args, $context, ResolveInfo $info)
    {
        $fields = $info->getFieldSelection($depth = 3);

        $users = User::query();

        foreach ($fields as $field => $keys) {
            if ($field === 'comments') {
                $users->with('comments');
            }

            if ($field === 'posts') {
                $users->with('posts');
            }
        }

        $tableFields = Schema::getColumnListing((new User())->getTable());
        foreach ($args as $key => $field) {
            if (in_array($key, $tableFields)) $users = $users->where($key, $args[$key]);
        }

        return $users->get();
    }
}