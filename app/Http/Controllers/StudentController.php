<?php

namespace App\Http\Controllers;

use App\Events\UserCreateEvent;
use App\Models\PresensiRecord;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Auth\Events\Registered;

class StudentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data = User::with('kelas')->whereHas('roles', function ($q){
            $q->where('name', config('enums.roles.student') );
        })->latest()->paginate();


        return view('pages.student.index', compact('data'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('pages.student.create');
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
            'email' => 'required|email|unique:users,email',
            'identity_number' => 'required',
            'phone_number' => 'required'
        ]);

        $faker = \Faker\Factory::create();

        $fields['password'] = Hash::make($faker->word());
        $fields['opening_status'] = config('enums.opening_status.registered');

        $user = User::create($fields);

        $user->assignRole(config('enums.roles.student'));

        event(new UserCreateEvent($user));


        return redirect()->route('student.index');
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
        $student = User::findOrFail($id);

        return view('pages.student.edit', compact('student'));
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
            'identity_number' => 'required',
            'phone_number' => 'required'
        ]);

        $student = User::findOrFail($id);
        $student->update($fields);

        return back();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $student = User::findOrFail($id);
        $student->delete();

        PresensiRecord::where('student_id', $student->id)->delete();

        return redirect()->route('student.index');
    }
}
