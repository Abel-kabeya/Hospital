<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Doctor;
use App\Models\Appointment;

class AdminController extends Controller
{
    //
    public function addview()
    {

        return view('admin.add_doctor');
    }

    public function upload(Request $request)
    {

        $doctor = new doctor;
        $image = $request->file;

        $imagename = time() . '.' . $image->getClientoriginalExtension();

        $request->file->move('doctorimage', $imagename);

        $doctor->image = $imagename;

        $doctor->name = $request->name;
        $doctor->phone = $request->number;
        $doctor->room = $request->room;
        $doctor->speciality = $request->speciality;

        $doctor->save();

        return redirect()->back()->with('message', 'Doctor Added Successfully');
    }

    public function show_appointments()
    {
        $data = appointment::all();

        return view('admin.show_appointments', compact('data'));
    }

    public function approve($id)
    {
        $data = appointment::findOrFail($id);

        $data->status = 'Approved';
        $data->save();

        return redirect()->back();
    }

    public function cancel($id)
    {
        $data = appointment::findOrFail($id);

        $data->status = 'Canceled';
        $data->save();

        return redirect()->back();
    }

    public function show_doctor()
    {
        $doctors = doctor::all();

        return view('admin.show_doctor', compact('doctors'));
    }

    public function delete_doctor($id)
    {
        $doctor = doctor::findOrFail($id);

        $doctor->delete();

        return redirect()->back();
    }

    public function update_doctor($id)
    {

        $doctor = doctor::findOrFail($id);

        return view('admin.update_doctor', compact('doctor'));
    }

    public function edit_doctor(Request $request, $id)
    {

        $doctor = doctor::findOrFail($id);

        $doctor->name = $request->name;
        $doctor->name = $request->phone;
        $doctor->name = $request->speciality;
        $doctor->name = $request->room;

        $image = $request->file;

        if ($image) {

            $imagename = time() . '.' . $image->getClientOriginalExtension();
            $request->file->move('doctorimage', $imagename);
            $doctor->image = $imagename;
        }

        $doctor->save();

        return redirect()->back()->with('message', 'Doctor details has been update successfully');
    }
}
