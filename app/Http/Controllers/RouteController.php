<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Event;
use App\Models\About;
use App\Models\Award;
use App\Models\Media;
use App\Models\Team;
use App\Models\Info;


class RouteController extends Controller
{
    // Home
    public function index()
    {
        $info = Info::all();
        $teams = Team::all();
        $about = About::all();
        $awards = Award::all();
        $events = Event::all();
        $media = Media::all();

        return inertia('Home', [
            'info' => $info[0],
            'teams' => $teams,
            'about' => $about,
            'awards' => $awards,
            'events' => $events,
            'media' => $media,
        ]);
    }
}
