<?php

namespace App\Http\Controllers;

class BreakController extends Controller
{
    public function index()
    {
        $exercises = [
            [
                'title' => 'Box Breathing',
                'duration' => 4,
                'description' => 'Inhale 4s, Hold 4s, Exhale 4s, Hold 4s'
            ],
            [
                'title' => '4-7-8 Breathing',
                'duration' => 5,
                'description' => 'Inhale 4s, Hold 7s, Exhale 8s'
            ],
            [
                'title' => 'Deep Breathing',
                'duration' => 3,
                'description' => 'Inhale 3s, Exhale 3s'
            ]
        ];
        
        return view('breaks.index', compact('exercises'));
    }
}