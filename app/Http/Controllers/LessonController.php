<?php

namespace App\Http\Controllers;

use App\Models\Course;
use App\Models\Lesson;
use App\Models\Token_User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class LessonController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    public function store(Request $request)
    {
        //check user_id with teacher of course
            //get user with token
                $tocken_c = $request->bearerToken();
                $token = Token_User::where('token', $tocken_c)->first();
            //get course
                $course = Course::where('course_id', $request->course_id)->get();

            if($course->user_id === $token->user_id){

                $request->validate([
                    'course_id' => 'required',
                    'meta_title' => ['sometimes', 'string'],
                    'meta_description' => ['sometimes', 'string'],
                    'video' => ['sometimes', 'mimes:mp4,webm', 'max:20480'],
                    'contents' => ['sometimes', 'string'],
                ]);

                //if video exist upload
                    if($request->file('video')->getSize()) {
                        $path = $request->file('video')->store('videos', 'public');
                        $url = Storage::disk('public')->url($path);
                    }

                //create new record
                    $lesson = Lesson::create([
                        'course_id' => $course->course_id,
                        'video' => $url??null,
                        'contents' => $request->contents??null,
                        'meta_title' => $request->meta_title??null,
                        'meta_description' => $request->meta_description??null,
                    ]);

                return response()->json([
                    'lesson' => $lesson,
                    'message' => 'Lesson created successfully.'
                ], 201);

            }else
                return response()->json([
                    'error' => 'you are not authorized to access this page',
                ], 403);
    }

    /**
     * Display the specified resource.
     */
    public function show(Lesson $lesson)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Lesson $lesson)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Lesson $lesson)
    {
        //check user_id with teacher of course

            //get user with token
                $tocken_c = $request->bearerToken();
                $token = Token_User::where('token', $tocken_c)->first();

            //get course
                $course = Course::where('course_id', $request->course_id)->get();

            if($course->user_id === $token->user_id) {

                $request->validate([
                    'course_id' => 'sometimes',
                    'meta_title' => ['sometimes', 'string'],
                    'meta_description' => ['sometimes', 'string'],
                    'video' => ['sometimes', 'mimes:mp4,webm', 'max:20480'],
                    'contents' => ['sometimes', 'string'],
                ]);

                //if video exist upload
                    if ($request->file('video')->getSize()) {
                        $path = $request->file('video')->store('videos', 'public');
                        $url = Storage::disk('public')->url($path);
                    }

                $lesson->update([
                    'course_id' => $course->course_id ?? $lesson->course_id,
                    'video' => $url ?? $lesson->video,
                    'contents' => $request->contents ?? $lesson->contents,
                    'meta_title' => $request->meta_title ?? $lesson->contents,
                    'meta_description' => $request->meta_description ?? $lesson->meta_description,
                ]);

                return response()->json([
                    'lesson' => $lesson,
                    'message' => 'Lesson updated successfully.'
                ], 201);
            }else
                return response()->json([
                    'error' => 'you are not authorized to access this page',
                ], 403);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Lesson $lesson)
    {
        //
    }
}
