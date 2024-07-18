<?php

namespace App\Http\Controllers;

use App\Http\Requests\Chats\StoreChatRequest;
use App\Http\Requests\Chats\UpdateChatRequest;
use App\Models\Chat;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Gate;

class ChatController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(): View
    {
        return view('chats.index', [
            'chats' => Chat::with('user')->latest()->paginate('10'),

        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreChatRequest $request): RedirectResponse
    {
        $validated = $request->validated();

        $request->user()->chats()->create($validated);

        return redirect(route('chats.index'));
    }

    /**
     * Display the specified resource.
     */
    public function show(Chat $chat)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Chat $chat): View
    {
        Gate::authorize('update', $chat);

        return view('chats.edit', [
            'chat' => $chat,
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateChatRequest $request, Chat $chat): RedirectResponse
    {
        Gate::authorize('update', $chat);

        $validated = $request->validated();

        $chat->update($validated);

        return redirect(route('chats.index'));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Chat $chat): RedirectResponse
    {
        Gate::authorize('delete', $chat);

        $chat->delete();

        return redirect(route('chats.index'));
    }
}
