<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class TodoListControllerTest extends TestCase
{
    public function testTodoList()
    {
        $this->withSession([
            "user" => "ilham",
            "todolist" => [
                [
                    "id" => "1",
                    "todo" => "Budi"
                ],
                [
                    "id" => "2",
                    "todo" => "Utomo"
                ]
            ]
        ])->get('/todolist')
         ->assertSeeText("1")
         ->assertSeeText("Budi")
         ->assertSeeText("2")
         ->assertSeeText("Utomo");
    }
    public function testAddTodoFailed()
    {
        $this->withSession([
            "user" => "ilham"
        ])->post("/todolist", [])
         ->assertSeeText("Todo is Required");
    }

    public function testAddTodoSuccess()
    {
        $this->withSession([
            "user" => "ilham"
        ])->post("/todolist", [
            "todo" => "Ilham"
        ])->assertRedirect("/todolist");
    }
    public function testRemoveTodoList()
    {
        $this->withSession([
            "user" => "ilham",
            "todolist" => [
                [
                    "id" => "1",
                    "todo" => "Budi"
                ],
                [
                    "id" => "2",
                    "todo" => "Utomo"
                ]
            ]
        ])->post("/todolist/1/delete")
         ->assertRedirect("/todolist");
    }
}
