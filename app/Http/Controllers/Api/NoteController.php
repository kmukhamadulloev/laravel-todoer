<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreNoteRequest;
use App\Http\Requests\UpdateNoteRequest;
use App\Http\Resources\NoteResource;
use Illuminate\Support\Facades\Auth;
use App\Models\Note;

class NoteController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $user = Auth::user();
        return $this->sendResponse("Request done.", new NoteResource($user));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreNoteRequest $request)
    {
        $user = Auth::user();
        $note = $user->notes()->create($request->validated());
        return $this->sendResponse("Note created successfully.", [
            'note' => $note
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function show(Note $note)
    {
        $this->authorize('view', $note);
        return $this->sendResponse("Request done successfully.", $note);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateNoteRequest $request, Note $note)
    {
        $this->authorize('update', $note);
        $note->update($request->validated());
        return $this->sendResponse("Task updated successfully.");
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Note $note)
    {
        $this->authorize('update', $note);
        $note->delete();
        return $this->sendResponse("Note deleted successfully.");
    }
}
