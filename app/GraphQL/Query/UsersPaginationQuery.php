<?php

namespace App\GraphQL\Query;

use App\User;
use GraphQL;
use GraphQL\Type\Definition\Type;
use Folklore\GraphQL\Support\Query;
use GraphQL\Type\Definition\ResolveInfo;

class UsersPaginationQuery extends Query
{
    protected $attributes = [
        'name' => 'usersPagination'
    ];

    public function type()
    {
        return GraphQL::pagination(GraphQL::type('User'));
    }

    public function args()
    {
        return [
            'limit' => ['type' => Type::nonNull(Type::int())],
            'page' => ['type' => Type::nonNull(Type::int())],
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

        return $users->paginate($args['limit'], ['*'], 'page', $args['page']);
    }
}