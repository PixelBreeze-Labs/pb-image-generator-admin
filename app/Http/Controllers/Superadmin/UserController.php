<?php

namespace App\Http\Controllers\Superadmin;

use App\Models\User;
use App\Models\Company;
use App\Models\Typology;
use App\Models\UserTemplate;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rules\Password;

class UserController extends Controller
{
    public function getHome()
    {
        return view('superadmin.newDashboard');
    }

    public function getCustomers()
    {
        $Customers = Company::where('deleted_at', null)->with(["admin", "type"])->get();
        // dd($Customers);
        return view('superadmin.customers', [
            'Customers' => $Customers,
        ]);
    }

    public function createCostumer()
    {
        $typologies = Typology::all();
        $templateName = getTemplateName();
        return view('superadmin.create-costumer', [
            'typologies' => $typologies,
            'templateName' => $templateName,
        ]);
    }

    public function storeCostumer(Request $request): \Illuminate\Http\RedirectResponse
    {
        $inputs = $request->all();

        // Define validation rules for user and company
        $userValidationRules = [
            'name' => ['required', 'string', 'max:50'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', new Password(8)],
        ];

        $companyValidationRules = [
            'company_name' => ['required', 'string', 'max:255'],
            'company_email' => ['required', 'string', 'email', 'max:255'],
            'company_domain' => ['required', 'string', 'max:255'],
            'typology' => ['required', 'integer'], // Assuming typology is an integer
//            'templates' => ['required', 'array'], // Assuming templates is an array
        ];

        // Validate user and company data
        $userValidator = Validator::make($inputs, $userValidationRules);
        $companyValidator = Validator::make($inputs, $companyValidationRules);


        // Check if both user and company data are valid
        if ($userValidator->fails() || $companyValidator->fails()) {
            // Flash the validation errors
            session()->flash('userValidator', $userValidator->errors());
            session()->flash('companyValidator', $companyValidator->errors());

            // Redirect back to the form
            return redirect()->route('superadmin.costumer-create');
        }


        // Create a new user
        $user = User::create([
            'name' => $inputs['name'],
            'email' => $inputs['email'],
            'password' => Hash::make($inputs['password']),
        ])->assignRole('admin');


        // Create a new company
        Company::create([
            'name' => $inputs['company_name'],
            'email' => $inputs['company_email'],
            'domain' => $inputs['company_domain'],
            'typology' => $inputs['typology'],
            'admin_id' => $user->id,
        ]);


        // Attach templates to the user (assuming 'templates' is an array of template IDs)
        // $user->templates()->attach($inputs['templates']);

        // Flash a success message
        session()->flash('success', 'Customer and company created successfully.');

        return redirect()->route('superadmin.customers');
    }


    public function removeCostumer(Request $request)
    {
        $costumer = Company::find($request['company_id']);
        $costumer->delete();
        return redirect()->route('superadmin.customers');
    }

    public function editCostumer($id)
    {
        $templateName = getTemplateName();
        $costumer = Company::find($id);
        $user_templates = $costumer->admin->templates->pluck('template_id')->toArray();
        $typologies = Typology::all();
        return view('superadmin.edit-costumer', [
            'costumer' => $costumer,
            'typologies' => $typologies,
            'templateName' => $templateName,
            'user_templates' => $user_templates,
        ]);
    }

    public function updateCostumer(Request $request)
    {
        // dd($request);
        $costumer = Company::find($request['costumer_id']);

        $user_templates = $costumer->admin->templates->pluck('template_id')->toArray();
        foreach($request['templates'] as $template_id) {
            if (!in_array($template_id, $user_templates)) {
                UserTemplate::create([
                    'user_id' => $costumer->admin->id,
                    'template_id' => $template_id,
                ]);
            }
        }

        foreach($user_templates as $template_id) {
            if (!in_array($template_id, $request['templates'])) {
                $removed_template = UserTemplate::where('user_id', $costumer->admin->id)->where('template_id', $template_id)->first();
                $removed_template->delete();
            }
        }

        $costumer->name = $request['company_name'];
        $costumer->email = $request['company_email'];
        $costumer->domain = $request['company_domain'];
        $costumer->typology = $request['typology'];
        $costumer->save();
        return redirect()->route('superadmin.customers');
    }
}
