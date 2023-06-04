<?php

namespace App\Http\Controllers;

use App\Models\Audio;
use App\Models\Movie;
use App\Models\MovieGenres;
use App\Models\Schedule;
use App\Models\Subtitle;
use App\Models\Theater;
use Carbon\Carbon;
use Illuminate\Http\Request;

class SchedulesController extends Controller
{
    //Schedule Movie
    public function schedule(Request $request)
    {

        $schedules = Schedule::all();
        $theaters = Theater::all();
        $movies = Movie::all();
        $audios = Audio::all();
        $subtitles = Subtitle::all();
        if (isset($request->theater) && isset($request->date)) {
            $date_cur = $request->date;
            $theater_cur = Theater::find($request->theater);
        } else {
            $date_cur = Carbon::today()->format('y-m-d');
            $theater_cur = Theater::find(1);
        }
        return view('admin.schedules.list', [
            'theaters' => $theaters,
            'date_cur' => $date_cur,
            'theater_cur' => $theater_cur,
            'schedules' => $schedules,
            'movies' => $movies,
            'audios' => $audios,
            'subtitles' => $subtitles
        ]);
    }

    public function postCreate(Request $request)
    {
        $movie = Movie::find($request->movie);
        $schedule = new Schedule([
            'room_id' => $request->room,
            'movie_id' => $request->movie,
            'audio_id' => $request->audio,
            'subtitle_id' => $request->subtitle,
            'date' => $request->date,
            'startTime' => $request->startTime,
            'endTime' => date('H:i', strtotime($request->startTime) + ($movie->showTime * 60)),
        ]);
        $schedule->save();
        return redirect('admin/schedule?theater=' . $request->theater . '&date=' . $request->date);
    }

    public function postEdit()
    {
        return view('admin.schedules.edit');
    }
    public function status(Request $request){
        $schedule = Schedule::find($request->schedule_id);
        $schedule['status'] = $request->active;
        $schedule->save();
        return response();
    }
    public function early_status(Request $request){
        $schedule = Schedule::find($request->early_id);
        $schedule['early'] = $request->active;
        $schedule->save();
        return response();
    }
    public function delete($id){
        $schedule = Schedule::find($id);
        if($schedule['status'] ==0 ){
            Schedule::destroy($id);
            return response()->json(['success' => 'Delete Successfully']);
        }
        else{
            return response()->json(['error' => "Please change status to offline" ]);
        }

    }
}
