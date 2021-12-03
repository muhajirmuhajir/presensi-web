<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Course;
use Illuminate\Http\Request;
use App\Events\UserCreateEvent;
use Illuminate\Support\Facades\Hash;

class TeacherController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data = User::whereHas('roles', function ($q){
            $q->where('name', config('enums.roles.teacher') );
        })->latest()->paginate();

        return view('pages.teacher.index', compact('data'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('pages.teacher.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $fields = $request->validate([
            'name' => 'required',
            'email' => 'required|email',
            'phone_number' => 'required'
        ]);

        $faker = \Faker\Factory::create();

        $fields['password'] = Hash::make($faker->word());
        $fields['opening_status'] = config('enums.opening_status.registered');

        $user = User::create($fields);

        event(new UserCreateEvent($user));

        $user->assignRole(config('enums.roles.teacher'));

        return redirect()->route('teacher.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $teacher= User::findOrFail($id);

        return view('pages.teacher.edit', compact('teacher'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $fields = $request->validate([
            'name' => 'required',
            'email' => 'required|email',
            'phone_number' => 'required'
        ]);
        $teacher= User::findOrFail($id);

        $teacher->update($fields);

        return redirect()->back();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $teacher= User::findOrFail($id);

        $teacher->delete();

        Course::where('teacher_id',$id)->update(['teacher_id' => null]);

        return redirect()->route('teacher.index');
    }
}
