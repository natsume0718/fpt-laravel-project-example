<?php

namespace Tests\Unit\Models;

use App\Models\Role;
use App\Models\User;
use Tests\ModelTestCase;

class RoleTest extends ModelTestCase
{

    public function testModelConfiguration()
    {
        $this->runConfigurationAssertions(new Role(), [
            'name',
            'display_name',
            'description'
        ], ['id' => 'int'], ['created_at', 'updated_at']);
    }

    public function testRelation()
    {
        $model = new Role();
        $relation = $model->users();

        $this->assertBelongsToManyRelation(
            $relation,
            $model,
            new User(),
            'role_id',
            'user_id'
        );
    }
}
