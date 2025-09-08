<?php

namespace App\Http\Controllers\Admin;

use App\Models\PayRoll;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\PayrollStoreRequest;
use App\Models\RestaurantBranch;

class PayrollController extends Controller
{
    public function index()
    {
        $payrolls = PayRoll::with('restaurant')->latest()->paginate(20);
        return view('admin.layouts.pages.payroll.index', compact('payrolls'));
    }

    public function create()
    {
        $restaurants = RestaurantBranch::where('status', 1)->get();
        return view('admin.layouts.pages.payroll.create', compact('restaurants'));
    }

    public function store(Request $request)
    {

        $validated = $request->validate([
            'restaurant_id' => 'required|exists:restaurant_branches,id',
            'id_number' => 'required|string|unique:pay_rolls,id_number',
            'joining_date' => 'required|date',
            'employe_name' => 'required|string|max:255',
            'employe_phone' => ['nullable', 'regex:/^(?:\+8801|01)[3-9][0-9]{8}$/', 'unique:pay_rolls,employe_phone'],
            'employe_email' => 'nullable|email|max:255|unique:pay_rolls,employe_email',
            'employe_present_address' => 'nullable|string',
            'employe_permanent_address' => 'nullable|string',
            'gender' => 'nullable|in:0,1,2',
            'employe_blood_group' => 'nullable|string|in:A+,A-,B+,B-,AB+,AB-,O+,O-',
            'employe_designation' => 'nullable|string|max:255',
            'employe_sallery' => 'nullable|numeric|min:0',
            'employe_festival_bonas' => 'nullable|numeric|min:0',
            'employe_festival_bonas_type' => 'nullable|in:cash,product,none',
            'employe_overtime_rate' => 'nullable|numeric|min:0',
            'employe_yearly_leave' => 'nullable|numeric|min:0',
            'employe_nid_number' => 'nullable|string|max:255',
            'employe_date_of_birth' => 'nullable|date',
            'employe_edu_qualification' => 'nullable|array',
            'employe_father_name' => 'nullable|string|max:255',
            'employe_mother_name' => 'nullable|string|max:255',

            'employe_image' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
            'employe_resume' => 'nullable|file|mimes:pdf,doc,docx|max:5120',
            'employe_nid_front_image' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
            'employe_nid_back_image' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
        ]);


        $data = $request->only(['restaurant_id', 'id_number', 'joining_date', 'employe_name', 'employe_phone', 'employe_email', 'employe_nid_number', 'employe_blood_group', 'employe_date_of_birth', 'employe_edu_qualification', 'employe_father_name', 'employe_mother_name', 'employe_present_address', 'employe_permanent_address', 'gender', 'employe_designation', 'employe_sallery', 'employe_festival_bonas', 'employe_festival_bonas_type', 'employe_overtime_rate', 'employe_yearly_leave']);


        if ($request->filled('employe_edu_qualification')) {
            $data['employe_edu_qualification'] = json_encode($request->employe_edu_qualification);
        }


        $fileFields = [
            'employe_image' => 'uploads/employe_images/',
            'employe_resume' => 'uploads/employe_resume/',
            'employe_nid_front_image' => 'uploads/employe_nid/',
            'employe_nid_back_image' => 'uploads/employe_nid/',
        ];

        foreach ($fileFields as $field => $path) {
            if ($request->hasFile($field)) {
                $file = $request->file($field);
                $filename = time() . '_' . uniqid() . '.' . $file->getClientOriginalExtension();
                $file->move(public_path($path), $filename);
                $data[$field] = $path . $filename;
            }
        }


        $employee = PayRoll::create($data);

        return response()->json(
            [
                'success' => true,
                'message' => 'Employee added successfully!',
                'data' => $employee,
            ],
            201,
        );
    }

    // Edit
    public function edit($id)
    {
        $payroll = PayRoll::findOrFail($id);
        $restaurants = RestaurantBranch::select(['id', 'restaurant_branch_name'])->get();

        return view('admin.layouts.pages.payroll.edit', compact('payroll', 'restaurants'));
    }

    // Update
    public function update(Request $request, $id)
    {
        $payroll = PayRoll::findOrFail($id);

        // Validate data
        $validated = $request->validate([
            'restaurant_id' => 'required|exists:restaurant_branches,id',
            'id_number' => 'required|string|unique:pay_rolls,id_number,' . $id,
            'joining_date' => 'required|date',
            'employe_name' => 'required|string|max:255',
            'employe_phone' => ['nullable', 'regex:/^01[3-9][0-9]{8}$/', 'unique:pay_rolls,employe_phone,' . $id],
            'employe_email' => 'nullable|email|unique:pay_rolls,employe_email,' . $id,
            'employe_nid_number' => 'nullable|string|max:100',
            'employe_blood_group' => 'nullable|string|max:10',
            'employe_date_of_birth' => 'nullable|date',
            'employe_edu_qualification' => 'nullable|array',
            'employe_father_name' => 'nullable|string|max:255',
            'employe_mother_name' => 'nullable|string|max:255',
            'employe_present_address' => 'nullable|string',
            'employe_permanent_address' => 'nullable|string',
            'gender' => 'nullable|in:0,1,2',
            'employe_designation' => 'nullable|string|max:255',
            'employe_sallery' => 'nullable|numeric|min:0',
            'employe_festival_bonas' => 'nullable|numeric|min:0',
            'employe_festival_bonas_type' => 'nullable|string|max:50',
            'employe_overtime_rate' => 'nullable|numeric|min:0',
            'employe_yearly_leave' => 'nullable|numeric|min:0',
            'employe_image' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
            'employe_resume' => 'nullable|mimes:pdf,doc,docx|max:5120',
            'employe_nid_front_image' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
            'employe_nid_back_image' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        // Encode education qualification
        if ($request->has('employe_edu_qualification')) {
            $validated['employe_edu_qualification'] = json_encode($request->employe_edu_qualification);
        }

        // File upload fields
        $fileFields = [
            'employe_image' => 'uploads/employe_images/',
            'employe_resume' => 'uploads/employe_resume/',
            'employe_nid_front_image' => 'uploads/employe_nid/',
            'employe_nid_back_image' => 'uploads/employe_nid/',
        ];

        foreach ($fileFields as $field => $path) {
            if ($request->hasFile($field)) {
                // Old file delete
                if ($payroll->$field && file_exists(public_path($payroll->$field))) {
                    unlink(public_path($payroll->$field));
                }

                // Upload new file
                $file = $request->file($field);
                $filename = time() . '_' . uniqid() . '.' . $file->getClientOriginalExtension();
                $file->move(public_path($path), $filename);

                $validated[$field] = $path . $filename;
            }
        }

        // Update payroll
        $payroll->update($validated);

        return redirect()->route('admin.payroll.index')->with('success', 'Employee updated successfully!');
    }

    public function destroy($id)
    {
        $payroll = PayRoll::findOrFail($id);


        $fileFields = ['employe_image', 'employe_resume', 'employe_nid_front_image', 'employe_nid_back_image'];

        foreach ($fileFields as $field) {
            if ($payroll->$field && file_exists(public_path($payroll->$field))) {
                unlink(public_path($payroll->$field));
            }
        }


        $payroll->delete();

        return redirect()->route('admin.payroll.index')->with('success', 'Employee deleted successfully!!');


    }

}
