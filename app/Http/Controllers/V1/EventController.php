<?php

namespace App\Http\Controllers\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\V1\StoreEventRequest;

class EventController extends Controller
{
    public function store(StoreEventRequest $request)
    {
        $type = $request->validated('type');
        $validated = collect($request->except('type'));

        // implement event handling
    }
}
