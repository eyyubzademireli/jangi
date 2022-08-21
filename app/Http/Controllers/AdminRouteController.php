<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use App\Models\Team;
use App\Models\Award;
use App\Models\Event;
use App\Models\Media;
use App\Models\Message;
use App\Models\Info;
use App\Models\About;
use Inertia\Inertia;
use Illuminate\Support\Facades\Storage;

class AdminRouteController extends Controller
{
    // Info starts
    public function composer($current = 'managers') {
        $managers = User::all();
        $teams = Team::all();
        $awards = Award::all();
        $events = Event::all();
        $media = Media::all();
        $messages = Message::all();
        $info = Info::all();
        $about = About::all();

        return Inertia::render('Dashboard', [
            'managers' => $managers,
            'teams' => $teams,
            'awards' => $awards,
            'events' => $events,
            'media' => $media,
            'messages' => $messages,
            'info' => $info,
            'about' => $about,
            'currentPage' => $current,
        ]);
    }

    // Update info
    public function updateInfo(Request $request) {
        try {
            $info = Info::find(1);
            $data = $request->all();
            $info->update([
                'address' => $data['info']['address'],
                'mobile' => $data['info']['mobile'],
                'phone' => $data['info']['phone'],
                'whatsapp' => $data['info']['whatsapp'],
                'facebook' => $data['info']['facebook'],
                'instagram' => $data['info']['instagram'],
                'youtube' => $data['info']['youtube'],
                'email' => $data['info']['email'],
            ]);

            return response()->json([
                'success' => true,
            ]);
        } catch (\Throwable $th) {
            return response()->json([
                'success' => false,
            ]);
        }
    }

    // Remove team member
    public function removeTeamMember(Request $request) {
        try {
            $team = Team::findOrFail($request->member);
            \File::delete(public_path($team->image));
            $team->delete();
            $teams = Team::all();
            return response()->json([
                'success' => true,
                'teams' => $teams
            ]);
        } catch (\Throwable $th) {
            return response()->json([
                'success' => false,
            ]);
        }
    }

    // Add team member
    public function addTeamMember(Request $request) {
        try {
            $team = Team::create([
                'name' => $request->name,
                'surname' => $request->surname,
                'group' => $request->group,
                'category' => $request->category,
                'image' => $request->image,
            ]);
            $teams = Team::all();
            return response()->json([
                'success' => true,
                'teams' => $teams
            ]);
        } catch (\Throwable $th) {
            return response()->json([
                'success' => false,
            ]);
        }
    }

    // Update team member
    public function updateTeamMember(Request $request) {
        try {
            $team = Team::findOrFail($request->id);

            $team->update([
                'name' => $request->name,
                'surname' => $request->surname,
                'group' => $request->group,
                'category' => $request->category,
                'image' => $request->image,
            ]);
            $teams = Team::all();
            return response()->json([
                'success' => true,
                'teams' => $teams
            ]);
        } catch (\Throwable $th) {
            return response()->json([
                'success' => false,
            ]);
        }
    }

    // Upload image
    public function uploadImage(Request $request) {
        $path = $request->file('file')->store('/public/site_images');

        return response()->json([
            'success' => true,
            'image' => Storage::url($path),
        ]);
    }


    // Remove event
    public function removeEvent(Request $request) {
        try {
            $event = Event::findOrFail($request->member);
            $event->delete();
            $events = Event::all();
            return response()->json([
                'success' => true,
                'teams' => $events
            ]);
        } catch (\Throwable $th) {
            return response()->json([
                'success' => false,
            ]);
        }
    }

    // Add event
    public function addEvent(Request $request) {
        try {
            $event = Event::create([
                'name' => $request->name,
                'day' => $request->day,
                'month' => $request->month,
                'address' => $request->address,
                'ticket_url' => $request->ticket_url,
                'status' => $request->status,
            ]);
            $events = Event::all();
            return response()->json([
                'success' => true,
                'teams' => $events
            ]);
        } catch (\Throwable $th) {
            return response()->json([
                'success' => false,
            ]);
        }
    }

    // Update event
    public function updateEvent(Request $request) {
        try {
            $event = Event::findOrFail($request->id);

            $event->update([
                'name' => $request->name,
                'day' => $request->day,
                'month' => $request->month,
                'address' => $request->address,
                'ticket_url' => $request->ticket_url,
                'status' => $request->status,
            ]);
            $events = Event::all();
            return response()->json([
                'success' => true,
                'teams' => $events
            ]);
        } catch (\Throwable $th) {
            return response()->json([
                'success' => false,
            ]);
        }
    }



    // Remove award
    public function removeAward(Request $request) {
        try {
            $award = Award::findOrFail($request->member);
            \File::delete(public_path($award->image));
            $award->delete();
            $awards = Award::all();
            return response()->json([
                'success' => true,
                'teams' => $awards
            ]);
        } catch (\Throwable $th) {
            return response()->json([
                'success' => false,
            ]);
        }
    }

    // Add award
    public function addAward(Request $request) {
        try {
            $award = Award::create([
                'title' => $request->title,
                'description' => $request->description,
                'image' => $request->image,
            ]);
            $awards = Award::all();
            return response()->json([
                'success' => true,
                'teams' => $awards
            ]);
        } catch (\Throwable $th) {
            return response()->json([
                'success' => false,
            ]);
        }
    }

    // Update award
    public function updateAward(Request $request) {
        try {
            $award = Award::findOrFail($request->id);

            $award->update([
                'title' => $request->title,
                'description' => $request->description,
                'image' => $request->image,
            ]);
            $awards = Award::all();
            return response()->json([
                'success' => true,
                'teams' => $awards
            ]);
        } catch (\Throwable $th) {
            return response()->json([
                'success' => false,
            ]);
        }
    }


    // Update about
    public function updateAbout(Request $request) {
        try {
            $award = About::findOrFail(1);
            $award1 = About::findOrFail(2);

            $award->update([
                'description' => $request->description,
                'image' => $request->image,
            ]);

            $award1->update([
                'description' => $request->description1,
                'image' => $request->image1,
            ]);

            $awards = About::all();
            return response()->json([
                'success' => true,
                'teams' => $awards
            ]);
        } catch (\Throwable $th) {
            return response()->json([
                'success' => false,
            ]);
        }
    }


    // Remove manager
    public function removeManager(Request $request) {
        try {
            $award = User::findOrFail($request->member);
            if($request->member !== 1) {
                $award->delete();
                $awards = User::all();
                $award->tokens()->delete();
                return response()->json([
                    'success' => true,
                    'teams' => $awards
                ]);
            }else {
                return response()->json([
                    'success' => false,
                ]);
            }

        } catch (\Throwable $th) {
            return response()->json([
                'success' => false,
            ]);
        }
    }

    // Add manager
    public function addManager(Request $request) {
        try {
            $award = User::create([
                'name' => $request->name,
                'email' => $request->email,
                'password' => Hash::make($request->password),
            ]);

            $awards = User::all();
            return response()->json([
                'success' => true,
                'teams' => $awards
            ]);
        } catch (\Throwable $th) {
            return response()->json([
                'success' => false,
            ]);
        }
    }

    // Update manager
    public function updateManager(Request $request) {
        try {
            if($request->user()->id !== 1 && $request->id === 1) {
                return response()->json([
                    'success' => false,
                ]);
            }else {
                $award = User::findOrFail($request->id);

                $award->update([
                    'name' => $request->name,
                    'email' => $request->email,
                    'password' => Hash::make($request->password),
                ]);
                $awards = User::all();
                return response()->json([
                    'success' => true,
                    'teams' => $awards
                ]);
            }
        } catch (\Throwable $th) {
            return response()->json([
                'success' => false,
            ]);
        }
    }


    // Remove media
    public function removeMedia(Request $request) {
        try {
            $award = Media::findOrFail($request->member);
            \File::delete(public_path($award->image));
            $award->delete();
            $awards = Media::all();
            return response()->json([
                'success' => true,
                'teams' => $awards
            ]);

        } catch (\Throwable $th) {
            return response()->json([
                'success' => false,
            ]);
        }
    }

    // Add media
    public function addMedia(Request $request) {
        try {
            $award = Media::create([
                'image' => $request->image,
                'group' => $request->group,
            ]);

            $awards = Media::all();
            return response()->json([
                'success' => true,
                'teams' => $awards
            ]);
        } catch (\Throwable $th) {
            return response()->json([
                'success' => false,
            ]);
        }
    }

    // Update media
    public function updateMedia(Request $request) {
        try {
            $award = Media::findOrFail($request->id);
            $award->update([
                'image' => $request->image,
                'group' => $request->group,
            ]);
            $awards = Media::all();
            return response()->json([
                'success' => true,
                'teams' => $awards
            ]);
        } catch (\Throwable $th) {
            return response()->json([
                'success' => false,
            ]);
        }
    }


    // Remove message
    public function removeMessage(Request $request) {
        try {
            $award = Message::findOrFail($request->member);
            $award->delete();
            $awards = Message::all();
            return response()->json([
                'success' => true,
                'teams' => $awards
            ]);
        } catch (\Throwable $th) {
            return response()->json([
                'success' => false,
            ]);
        }
    }

    // Add message
    public function sendMessage(Request $request) {
        $message = Message::create([
            'name' => $request->name,
            'surname' => $request->surname,
            'email' => $request->email,
            'message' => $request->message,
        ]);
        return response()->json([
            'success' => true,
        ]);
    }
}
