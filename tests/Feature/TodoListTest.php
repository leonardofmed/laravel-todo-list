<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\ListItem;


class TodoListTest extends TestCase
{
    // The RefreshDatabase trait rolls back all database transactions at the end of each test, which means that any data inserted/updated will be erased.
    // The purpose of this trait is to provide a clean slate for each test, so that the tests are not dependent on the state of the database from previous tests.
    // ! WARNING: This trait should not be used in production environments. All DB data will be erased !
    use RefreshDatabase;

    public function test_todo_list_functionality()
    {
        if (config('app.env') !== 'testing') {
            echo "This test method should only be run in the testing environment!";
            return;
        }
    
        // Create a new list item by sending a POST request to the saveItem route with a listItem parameter
        $response = $this->post(route('saveItem'), ['listItem' => 'Test Item']);

        // Assert that the response is a redirect to the root URL
        $response->assertRedirect('/');

        // Assert that the new item was created in the database
        $this->assertDatabaseHas('list_items', [
            'name' => 'Test Item',
            'is_complete' => 0,
        ]);

        // Mark the new item as complete by sending a POST request to the markComplete route
        $listItem = ListItem::where('name', 'Test Item')->first();
        $response = $this->post(route('markComplete', ['id' => $listItem->id]));

        // Assert that the response is a redirect to the root URL
        $response->assertRedirect('/');

        // Assert that the item was marked as complete in the database
        $this->assertDatabaseHas('list_items', [
            'id' => $listItem->id,
            'name' => 'Test Item',
            'is_complete' => 1,
        ]);

        // Assert that the completed item is not displayed on the index page
        $response = $this->get("/");
        $response->assertStatus(200);
        $response->assertDontSee('Test Item');
    }
}
