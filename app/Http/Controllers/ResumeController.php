<?php

namespace App\Http\Controllers;

use App\CustomHelpers\ReturnBase;
use App\Models\Contact;
use App\Models\EducationHistory;
use App\Models\Language;
use App\Models\Resume;
use App\Models\Skills;
use App\Models\WorkHistory;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Tymon\JWTAuth\Facades\JWTAuth;
use Tymon\JWTAuth\Facades\JWTFactory;

class ResumeController extends Controller
{
    // Upload resume
    public function HandleFileUpload($avatar, $name)
    {
        //your base64 encoded data
        $file_64 = $avatar;

        // .txt .doc .pdf .csv .docx

        $extensions = array('jpeg', 'png', 'jpg');

        $extension = explode('/', explode(':', substr($file_64, 0, strpos($file_64, ';')))[1])[1];

        if (!in_array($extension, $extensions)) {
            return "fail";
        }

        $replace = substr($file_64, 0, strpos($file_64, ',') + 1);

        // find substring fro replace here eg: data:image/png;base64,

        $file = str_replace($replace, '', $file_64);

        $file = str_replace(' ', '+', $file);

        $fileName = null;

        $fileName = $name . '-' . date('d-M-Y') . '.' . $extension;

        Storage::disk('public')->put('/apiFiles/' . $fileName, base64_decode($file));

        return $fileName;
    }

    // Retrieve file
    public function RetrieveFile($fileName)
    {
        $myFile = Storage::disk('public')->get('/apiFiles/' . $fileName);

        $extension = explode('.', $fileName)[1];

        // $headers = array('Content-Type: application/pdf');

        $fileName = explode('.', $fileName)[0] . time() . '.' . $extension;

        // return response()->download($myFile, $fileName, $headers);
        $prefix = null;
        if ($extension == "png") {
            $prefix = 'data:image/png;base64,';
        } else if ($extension == 'jpeg') {
            $prefix = 'data:image/jpeg;base64,';
        } else {
            $prefix = 'data:image/jpg;base64,';
        }
        return $prefix . base64_encode($myFile);

        // $result = [
        //     'file' => base64_encode($file)
        // ];
        // return $result;
    }

    /** CREATE RESUME
     * DESCRIPTION: Handle the creation of a resume
     * ENDPOINT: /resumes
     * METHOD: POST
     * TODO
     * - create a resume
     * - create work history
     * - create education
     * - create skills
     * - create language
     * - create contacts
     * 
     */

    public function Create(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                // Personal details
                "personal_details" => "required|array",
                "personal_details.Avatar" => "required|string",
                "personal_details.FirstName" => "required|string",
                "personal_details.MiddleName" => "sometimes|nullable|string",
                "personal_details.LastName" => "required|string",
                "personal_details.DateOfBirth" => "required|string",
                "personal_details.Nationality" => "required|string",
                "personal_details.Gender" => "required|string",
                "personal_details.Bio" => "required|string",
                "personal_details.Headline" => "required|string",
                // Address
                "address" => "required|array",
                "address.CountryOfResidence" => "required|string",
                "address.City" => "required|string",
                "address.PostalCode" => "sometimes|nullable|string",

                // Education
                "education" => "required|array",
                "education.*.Institution" => "required|string",
                "education.*.Location" => "required|string",
                "education.*.Achievements" => "required|string",
                "education.*.StartDate" => "required|string",
                "education.*.EndDate" => "sometimes|nullable|string",

                // Work history
                "work_history" => "required|array",
                "work_history.*.Company" => "required|string",
                "work_history.*.Position" => "required|string",
                "work_history.*.Role" => "required|string",
                "work_history.*.StartDate" => "required|string",
                "work_history.*.EndDate" => "sometimes|nullable|string",

                // Skills
                "skills" => "required|array",
                "skills.*.Name" => "required|string",
                "skills.*.Description" => "required|string",
                "skills.*.Level" => "required|string",

                // Languages
                "languages" => "required|array",
                "languages.*.Name" => "required|string",
                "languages.*.Level" => "required|string",

                // Contacts
                "contact" => "required|array",
                "contact.Phone" => "required|string",
                "contact.Website" => "sometimes|nullable|string",
                "contact.Twitter" => "sometimes|nullable|string",
                "contact.Facebook" => "sometimes|nullable|string",
                "contact.Instagram" => "sometimes|nullable|string",
                "contact.LinkedIn" => "sometimes|nullable|string",
            ]);

            if ($validator->fails()) {
                return ReturnBase::HandleValidationErrors($validator);
            }
            $request['Created_By'] = auth()->user()->Id;
            $request['CreatedAt'] = date('Y:m:d H:i:s', time());

            $name = $request['personal_details']['FirstName'] . $request['personal_details']['MiddleName'] . $request['personal_details']['LastName'];

            $avatarPath = $this->HandleFileUpload($request['personal_details']['Avatar'], $name);

            if ($avatarPath == "fail") {
                return ReturnBase::Error('Wrong file extension. Must be jpeg, png or jpg', Response::HTTP_BAD_REQUEST);
            }

            DB::beginTransaction();

            $code = Str::random(64);

            $resume = Resume::create([
                'User_Id' => auth()->user()->Id,
                'AvatarPath' => $avatarPath,
                'FirstName' => $request['personal_details']['FirstName'],
                'MiddleName' => $request['personal_details']['MiddleName'],
                'LastName' => $request['personal_details']['LastName'],
                'Headline' => $request['personal_details']['Headline'],
                'DateOfBirth' => $request['personal_details']['DateOfBirth'],
                'Nationality' => $request['personal_details']['Nationality'],
                'Gender' => $request['personal_details']['Gender'],
                'Bio' => $request['personal_details']['Bio'],
                'CountryOfResidence' => $request['address']['CountryOfResidence'],
                'City' => $request['address']['City'],
                'PostalCode' => $request['address']['PostalCode'],
                'RefererCode' => $code,
                'Created_By' =>  $request['Created_By'],
                'CreatedAt' => $request['CreatedAt']
            ]);

            // Create resume education records
            foreach ($request['education'] as $edu) {
                EducationHistory::create([
                    'Resume_Id' => $resume['Id'],
                    'Institution' => $edu['Institution'],
                    'Location' => $edu['Location'],
                    'Achievements' => $edu['Achievements'],
                    'StartDate' => $edu['StartDate'],
                    'EndDate' => $edu['EndDate'],
                    'Created_By' =>  $request['Created_By'],
                    'CreatedAt' => $request['CreatedAt']
                ]);
            }

            // Create work history
            foreach ($request['work_history'] as $work) {
                WorkHistory::create([
                    'Resume_Id' => $resume['Id'],
                    'Company' => $work['Company'],
                    'Position' => $work['Position'],
                    'Role' => $work['Role'],
                    'StartDate' => $work['StartDate'],
                    'EndDate' => $work['EndDate'],
                    'Created_By' =>  $request['Created_By'],
                    'CreatedAt' => $request['CreatedAt']
                ]);
            }

            // Create Skills
            foreach ($request['skills'] as $skill) {
                Skills::create([
                    'Resume_Id' => $resume['Id'],
                    'Name' => $skill['Name'],
                    'Description' => $skill['Description'],
                    'Level' => $skill['Level'],
                    'Created_By' =>  $request['Created_By'],
                    'CreatedAt' => $request['CreatedAt']
                ]);
            }

            // Create languages
            foreach ($request['languages'] as $language) {
                Language::create([
                    'Resume_Id' => $resume['Id'],
                    'Name' => $language['Name'],
                    'Level' => $language['Level'],
                    'Created_By' =>  $request['Created_By'],
                    'CreatedAt' => $request['CreatedAt']
                ]);
            }

            // Create contacts
            $contacts = $request['contact'];

            // Log::info($contact);
            Contact::create([
                'Resume_Id' => $resume['Id'],
                'Phone' => $contacts['Phone'],
                'Website' => $contacts['Website'],
                'Twitter' => $contacts['Twitter'],
                'Facebook' => $contacts['Facebook'],
                'Instagram' => $contacts['Instagram'],
                'Twitter' => $contacts['Twitter'],
                'LinkedIn' => $contacts['LinkedIn'],
                'Created_By' =>  $request['Created_By'],
                'CreatedAt' => $request['CreatedAt']
            ]);

            DB::commit();

            return ReturnBase::JustMessage('Resume has been created successfully', Response::HTTP_OK);
        } catch (\Exception $exp) {
            DB::rollBack();
            return ReturnBase::InternalServerError($exp);
        }
    }

    /** GET RESUME
     * DESCRIPTION: Handle getting resume of logged in user
     * ENDPOINT: /resumes
     * METHOD: GET
     * TODO
     * - get resumes
     * 
     */

    public function GetMyResume()
    {
        try {
            $resume = Resume::where('User_Id', auth()->user()->Id)->first();

            if ($resume == null) {
                return ReturnBase::JustMessage('You do not have a resume. Please create one', 200);
            }
            $resume['Avatar'] = $this->RetrieveFile($resume->AvatarPath);

            $work_histories = [];
            foreach ($resume->work_history as $work_history) {
                $work_history['IsDeleted'] = false;
                array_push($work_histories, $work_history);
            }

            $institutions = [];

            foreach ($resume->education as $institution) {
                $institution['IsDeleted'] = false;
                array_push($institutions, $institution);
            }

            $skills = [];

            foreach ($resume->skills as $skill) {
                $skill['IsDeleted'] = false;
                array_push($skills, $skill);
            }

            $languages = [];

            foreach ($resume->languages as $language) {
                $language['IsDeleted'] = false;
                array_push($languages, $language);
            }


            $result = [
                'personal_details' => [
                    'Avatar' => $resume['Avatar'],
                    "FirstName" => $resume['FirstName'],
                    "MiddleName" => $resume['MiddleName'],
                    "LastName" => $resume['LastName'],
                    "DateOfBirth" => $resume['DateOfBirth'],
                    "Gender" => $resume['Gender'],
                    "Nationality" => $resume['Nationality'],
                    "Bio" => $resume['Bio'],
                    "Headline" => $resume['Headline'],
                    "AccessCode" => $resume['RefererCode']
                ],
                'address' => [
                    "CountryOfResidence" => $resume['CountryOfResidence'],
                    "City" => $resume['City'],
                    "PostalCode" => $resume['PostalCode']
                ],
                'education' => $institutions,
                'work_history' => $work_histories,
                'languages' => $languages,
                'skills' => $skills,
                'contacts' => $resume->contacts,
                'contacts_email' =>  auth()->user()->Email,
            ];

            return ReturnBase::Object('Okay', (object)$result, Response::HTTP_OK);
        } catch (\Exception $exp) {
            DB::rollBack();
            return ReturnBase::InternalServerError($exp);
        }
    }

    /** GET BY REFERER CODE
     * DESCRIPTION: Handle getting resume by referer code
     * ENDPOINT: /resumes/access-code/{access_code}
     * METHOD: GET
     * TODO
     * - check if resume with that code exists
     * 
     */

    public function GetByAccessCode($refererCode)
    {
        try {
            $resume = Resume::where('RefererCode', $refererCode)->first();

            if ($resume == null) {
                return ReturnBase::Error('Resume does not exist', Response::HTTP_BAD_REQUEST);
            }

            $resume['Avatar'] = $this->RetrieveFile($resume->AvatarPath);

            $result = [
                'personal_details' => [
                    'Avatar' => $resume['Avatar'],
                    "FirstName" => $resume['FirstName'],
                    "MiddleName" => $resume['MiddleName'],
                    "LastName" => $resume['LastName'],
                    "DateOfBirth" => $resume['DateOfBirth'],
                    "Gender" => $resume['Gender'],
                    "Nationality" => $resume['Nationality'],
                    "Bio" => $resume['Bio'],
                    "Headline" => $resume['Headline']
                ],
                'address' => [
                    "CountryOfResidence" => $resume['CountryOfResidence'],
                    "City" => $resume['City'],
                    "PostalCode" => $resume['PostalCode']
                ],
                'education' => $resume->education,
                'work_history' => $resume->work_history,
                'languages' => $resume->languages,
                'skills' => $resume->skills,
                'contacts' => $resume->contacts,
                'contacts_email' =>  $resume->user['Email'],
            ];


            return ReturnBase::Object('Success', (object)$result, 200);
        } catch (\Exception $exp) {
            DB::rollBack();
            return ReturnBase::InternalServerError($exp);
        }
    }

    /** VERIFY REFERER CODE
     * DESCRIPTION: Handle verification of referer code
     * ENDPOINT: /resumes/access-code/{access_code}
     * METHOD: POST
     * TODO
     * - check if resume with that code exists
     * 
     */
    public function VerifyAccessCode($refererCode)
    {
        try {
            $resume = Resume::where('RefererCode', $refererCode)->first();

            if ($resume == null) {
                return ReturnBase::Error('Resume does not exist', Response::HTTP_BAD_REQUEST);
            }

            $customClaim = [
                'isGuest' => true,
                'accessCode' => $refererCode,
                'iss' => 'hey',
                'iat' => strtotime("now"),
                'nbf' => strtotime("now"),
                'sub' => 'hey',
                'jti' => Str::random(64),
            ];

            $factory = JWTFactory::customClaims($customClaim);

            $payload = $factory->make();

            $token = JWTAuth::encode($payload);

            return ReturnBase::Object(
                'Success',
                (object)[
                    'token' => (string)$token
                ],
                200
            );
        } catch (\Exception $exp) {
            DB::rollBack();
            return ReturnBase::InternalServerError($exp);
        }
    }

    /** UPDATE RESUME
     * DESCRIPTION: Handle updating a resume
     * ENDPOINT: /resumes
     * METHOD: PUT
     * TODO
     * - update resume
     * 
     */

    public function Update(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                // Personal details
                "personal_details" => "required|array",
                "personal_details.Avatar" => "required|string",
                "personal_details.FirstName" => "required|string",
                "personal_details.MiddleName" => "sometimes|nullable|string",
                "personal_details.LastName" => "required|string",
                "personal_details.DateOfBirth" => "required|string",
                "personal_details.Nationality" => "required|string",
                "personal_details.Gender" => "required|string",
                "personal_details.Bio" => "required|string",
                "personal_details.Headline" => "required|string",
                // Address
                "address" => "required|array",
                "address.CountryOfResidence" => "required|string",
                "address.City" => "required|string",
                "address.PostalCode" => "sometimes|nullable|string",

                // Education
                "education" => "required|array",
                "education.*.Institution" => "required|string",
                "education.*.Location" => "required|string",
                "education.*.Achievements" => "required|string",
                "education.*.StartDate" => "required|string",
                "education.*.EndDate" => "sometimes|nullable|string",

                // Work history
                "work_history" => "required|array",
                "work_history.*.Company" => "required|string",
                "work_history.*.Position" => "required|string",
                "work_history.*.Role" => "required|string",
                "work_history.*.StartDate" => "required|string",
                "work_history.*.EndDate" => "sometimes|nullable|string",

                // Skills
                "skills" => "required|array",
                "skills.*.Name" => "required|string",
                "skills.*.Description" => "required|string",
                "skills.*.Level" => "required|string",

                // Languages
                "languages" => "required|array",
                "languages.*.Name" => "required|string",
                "languages.*.Level" => "required|string",

                // Contacts
                "contact" => "required|array",
                "contact.Phone" => "required|string",
                "contact.Website" => "sometimes|nullable|string",
                "contact.Twitter" => "sometimes|nullable|string",
                "contact.Facebook" => "sometimes|nullable|string",
                "contact.Instagram" => "sometimes|nullable|string",
                "contact.LinkedIn" => "sometimes|nullable|string",
            ]);

            if ($validator->fails()) {
                return ReturnBase::HandleValidationErrors($validator);
            }
            $request['Modified_By'] = auth()->user()->Id;
            $request['ModifiedAt'] = date('Y:m:d H:i:s', time());

            $name = $request['personal_details']['FirstName'] . $request['personal_details']['MiddleName'] . $request['personal_details']['LastName'];

            $avatarPath = $this->HandleFileUpload($request['personal_details']['Avatar'], $name);

            if ($avatarPath == "fail") {
                return ReturnBase::Error('Wrong file extension. Must be jpeg, png or jpg', Response::HTTP_BAD_REQUEST);
            }

            DB::beginTransaction();

            Resume::where('User_Id', auth()->user()->Id)->update([
                'AvatarPath' => $avatarPath,
                'FirstName' => $request['personal_details']['FirstName'],
                'MiddleName' => $request['personal_details']['MiddleName'],
                'LastName' => $request['personal_details']['LastName'],
                'Headline' => $request['personal_details']['Headline'],
                'DateOfBirth' => $request['personal_details']['DateOfBirth'],
                'Nationality' => $request['personal_details']['Nationality'],
                'Gender' => $request['personal_details']['Gender'],
                'Bio' => $request['personal_details']['Bio'],
                'CountryOfResidence' => $request['address']['CountryOfResidence'],
                'City' => $request['address']['City'],
                'PostalCode' => $request['address']['PostalCode'],
                'Modified_By' =>  $request['Modified_By'],
                'ModifiedAt' => $request['ModifiedAt']
            ]);

            $resume = Resume::where('User_Id', auth()->user()->Id)->first();

            // Create resume education records
            foreach ($request['education'] as $edu) {
                // if edu has no Id create it
                if (!isset($edu['Id'])) {
                    EducationHistory::create([
                        'Resume_Id' => $resume['Id'],
                        'Institution' => $edu['Institution'],
                        'Location' => $edu['Location'],
                        'Achievements' => $edu['Achievements'],
                        'StartDate' => $edu['StartDate'],
                        'EndDate' => $edu['EndDate'],
                        'Created_By' =>  $request['Modified_By'],
                        'CreatedAt' => $request['ModifiedAt']
                    ]);
                    // Update education
                } else {
                    if (isset($edu['IsDeleted'])) {
                        if (!$edu['IsDeleted']) {
                            EducationHistory::where('Id', $edu['Id'])->update([
                                'Institution' => $edu['Institution'],
                                'Location' => $edu['Location'],
                                'Achievements' => $edu['Achievements'],
                                'StartDate' => $edu['StartDate'],
                                'EndDate' => $edu['EndDate'],
                                'Modified_By' =>  $request['Modified_By'],
                                'ModifiedAt' => $request['ModifiedAt']
                            ]);
                        } else {
                            EducationHistory::where('Id', $edu['Id'])->delete();
                        }
                    }
                }
            }

            // Create work history
            foreach ($request['work_history'] as $work) {
                // if work has no Id create it
                if (!isset($work['Id'])) {
                    WorkHistory::create([
                        'Resume_Id' => $resume['Id'],
                        'Company' => $work['Company'],
                        'Position' => $work['Position'],
                        'Role' => $work['Role'],
                        'StartDate' => $work['StartDate'],
                        'EndDate' => $work['EndDate'],
                        'Created_By' =>  $request['Modified_By'],
                        'CreatedAt' => $request['ModifiedAt']
                    ]);
                    // Update work history
                } else {
                    if (isset($work['IsDeleted'])) {
                        if (!$work['IsDeleted']) {
                            WorkHistory::where('Id', $work['Id'])->update([
                                'Company' => $work['Company'],
                                'Position' => $work['Position'],
                                'Role' => $work['Role'],
                                'StartDate' => $work['StartDate'],
                                'EndDate' => $work['EndDate'],
                                'Modified_By' =>  $request['Modified_By'],
                                'ModifiedAt' => $request['ModifiedAt']
                            ]);
                        } else {
                            WorkHistory::where('Id', $work['Id'])->delete();
                        }
                    }
                }
            }

            Log::info($request['skills']);

            // Create Skills
            foreach ($request['skills'] as $skill) {
                // if skill has no Id create it
                if (!isset($skill['Id'])) {
                    Skills::create([
                        'Resume_Id' => $resume['Id'],
                        'Name' => $skill['Name'],
                        'Description' => $skill['Description'],
                        'Level' => $skill['Level'],
                        'Created_By' =>  $request['Modified_By'],
                        'CreatedAt' => $request['ModifiedAt']
                    ]);
                } else {
                    if (isset($skill['IsDeleted'])) {
                        if (!$skill['IsDeleted']) {
                            Skills::where('Id', $skill['Id'])->update([
                                'Name' => $skill['Name'],
                                'Description' => $skill['Description'],
                                'Level' => $skill['Level'],
                                'Modified_By' =>  $request['Modified_By'],
                                'ModifiedAt' => $request['ModifiedAt']
                            ]);
                        } else {
                            Skills::where('Id', $skill['Id'])->delete();
                        }
                    }
                }
            }

            // Create languages
            foreach ($request['languages'] as $language) {
                if (!isset($language['Id'])) {
                    Language::create([
                        'Resume_Id' => $resume['Id'],
                        'Name' => $language['Name'],
                        'Level' => $language['Level'],
                        'Created_By' =>  $request['Modified_By'],
                        'CreatedAt' => $request['ModifiedAt']
                    ]);
                } else {
                    if (isset($language['IsDeleted'])) {
                        if (!$language['IsDeleted']) {
                            Language::where('Id', $language['Id'])->update([
                                'Name' => $language['Name'],
                                'Level' => $language['Level'],
                                'Modified_By' =>  $request['Modified_By'],
                                'ModifiedAt' => $request['ModifiedAt']
                            ]);
                        } else {
                            Language::where('Id', $language['Id'])->delete();
                        }
                    }
                }
            }

            // Create contacts
            $contacts = $request['contact'];

            // Log::info($contact);
            Contact::where('Resume_Id', $resume['Id'])->update([
                'Phone' => $contacts['Phone'],
                'Website' => $contacts['Website'],
                'Twitter' => $contacts['Twitter'],
                'Facebook' => $contacts['Facebook'],
                'Instagram' => $contacts['Instagram'],
                'Twitter' => $contacts['Twitter'],
                'LinkedIn' => $contacts['LinkedIn'],
                'Modified_By' =>  $request['Modified_By'],
                'ModifiedAt' => $request['ModifiedAt']
            ]);

            DB::commit();

            return ReturnBase::JustMessage('Resume has been updated successfully', Response::HTTP_OK);
        } catch (\Exception $exp) {
            DB::rollBack();
            return ReturnBase::InternalServerError($exp);
        }
    }
}
