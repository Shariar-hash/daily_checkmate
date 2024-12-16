<?php

namespace App\Services;

use App\Models\Idea;
use Illuminate\Support\Facades\Auth;

class IdeaService
{
    public function create(array $data)
    {
        return Auth::user()->ideas()->create($data);
    }

    public function update(Idea $idea, array $data)
    {
        $idea->update($data);
        return $idea;
    }

    public function delete(Idea $idea)
    {
        return $idea->delete();
    }
}
