<?php

use Laravel\Lumen\Testing\DatabaseMigrations;
use Laravel\Lumen\Testing\DatabaseTransactions;
use App\Models\User;

class UserControllerTest extends TestCase
{
    use DatabaseMigrations;

    /**
     * Test user index
     *
     * @return void
     */
    public function testUserIntex()
    {
        User::factory('App\User')->times(10)->create();
        $this->get('/user');
        $this->seeStatusCode(200);

        $this->seeJsonStructure([
            '*' =>
                [
                    'name',
                    'email',
                    'created_at',
                    'updated_at',
                ]
            ]);
    }

    /**
     * Test user store
     *
     * @return void
     */
    public function testUserStore()
    {
        // Test missing required field.
        $this->post('/user', [
            'name' => 'Test1',
        ]);
        $this->seeStatusCode(422);
        $this->seeJson(['email' => ['The email field is required.']]);

        $this->post('/user', [
            'name' => 'Test1',
            'email' => 'test1@example.com'
        ]);
        $this->seeJson(['name' => 'Test1']);
        $this->seeStatusCode(201);

        // Test insert email already exists.
        $this->post('/user', [
            'name' => 'Test2',
            'email' => 'test1@example.com'
        ]);
        $this->seeStatusCode(422);
        $this->seeJson(['email' => ['The email has already been taken.']]);
    }

    /**
     * Test user show
     *
     * @return void
     */
    public function testUserShow()
    {
        User::factory('App\User')->times(10)->create();
        // Test missing required field.
        $this->get('/user/1');
        $this->seeStatusCode(200);
        $this->seeJsonStructure(
                [
                    'name',
                    'email',
                    'created_at',
                    'updated_at',
                ]
            );
        
        // Test non-exist user.
        $this->get('/user/11');
        $this->seeStatusCode(404);
        $this->seeJson(['error' => 'User does not exist']);
    }

    /**
     * Test user update
     *
     * @return void
     */
    public function testUserUpdate()
    {
        $this->post('/user', [
            'name' => 'Test1',
            'email' => 'test1@example.com'
        ]);
        $this->seeInDatabase('users', ['email' => 'test1@example.com']);

        $this->put('/user/update/1', [
            'name' => 'Test2',
            'email' => 'test2@example.com'
        ]);
        $this->seeStatusCode(200);
        $this->seeInDatabase('users', ['name' => 'Test2']);
        $this->seeInDatabase('users', ['email' => 'test2@example.com']);
        $this->notSeeInDatabase('users', ['email' => 'test1@example.com']);

        $this->patch('/user/update/1', [
            'name' => 'Test2',
            'email' => 'test3@example.com'
        ]);
        $this->seeStatusCode(200);
        $this->seeInDatabase('users', ['email' => 'test3@example.com']);

        // Update non-exist user.
        $this->put('/user/update/2', [
            'name' => 'Test1',
            'email' => 'test1@example.com'
        ]);
        $this->seeStatusCode(404);
        $this->seeJson(['error' => 'User does not exist']);

        // Should allow updating name only.
        $this->patch('/user/update/1', [
            'name' => 'Test3',
            'email' => 'test3@example.com'
        ]);
        $this->seeStatusCode(200);
        $this->seeInDatabase('users', ['email' => 'test3@example.com']);
        $this->seeInDatabase('users', ['name' => 'Test3']);
    }

    /**
     * Test user delete
     *
     * @return void
     */
    public function testUserDelete()
    {
        User::factory('App\User')->times(10)->create();

        $this->delete('/user/delete/1');
        $this->seeStatusCode(202);
        $this->notSeeInDatabase('users', ['id' => 1]);
        $this->seeJsonStructure(
                [
                    'name',
                    'email',
                    'created_at',
                    'updated_at',
                ]
            );

        // Delete non-exist user.
        $this->delete('/user/delete/11');
        $this->seeStatusCode(404);
        $this->seeJson(['error' => 'User does not exist']);
    }
}
