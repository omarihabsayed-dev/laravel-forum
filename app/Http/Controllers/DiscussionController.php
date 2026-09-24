<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreDiscussionRequest;
use App\Http\Requests\UpdateDiscussionRequest;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;
use App\Models\Discussion;
use Illuminate\Support\Str;

class DiscussionController extends Controller implements HasMiddleware
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('discussion.index', ['discussions' => Discussion::with(['user', 'channel'])->latest()->paginate(3)]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('discussion.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreDiscussionRequest $request)
    {
        $request->user()->discussions()->create([
            ...$request->validated(),
            'slug' => Str::slug($request->title),
        ]);
        return redirect()->route('discussion.index')->with('success', 'Discussion created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Discussion $discussion)
    {
        $discussion->load(['user', 'channel']);
        return view('discussion.show', ['discussion' => $discussion]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Discussion $discussion)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateDiscussionRequest $request, Discussion $discussion)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Discussion $discussion)
    {
        //
    }

    public static function middleware(): array {
        return [
            new Middleware('auth', only: ['create', 'store']),
        ];
    }
}
