<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ListItem;

class TodoListController extends Controller
{   

    // When loading the index page, request all items from Todo List and pass them to the "listItems" variable
    public function index() {
        return view('welcome', ['listItems' => ListItem::all()]);
    }

    // Request is everything we are passing through the form to the endpoint
    public function saveItem(Request $request) {
        // \Log::info(json_encode($request->all()));

        $newListItem = new ListItem;
        $newListItem->name = $request->listItem;
        $newListItem->is_complete = 0;
        $newListItem->save();

        return view('welcome', ['listItems' => ListItem::all()]);
    }
}
