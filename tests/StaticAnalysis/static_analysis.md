---

Line app\Actions\Auth\RegisterAction.php

---

14 Method App\Actions\Auth\RegisterAction::handle() has parameter $clinicData with no value type specified in iterable type array.  
 🪪 missingType.iterableValue  
 💡 See: https://phpstan.org/blog/solving-phpstan-no-value-type-specified-in-iterable-type  
 44 Method App\Actions\Auth\RegisterAction::createClinic() has parameter $clinicData with no value type specified in iterable type array.  
 🪪 missingType.iterableValue  
 💡 See: https://phpstan.org/blog/solving-phpstan-no-value-type-specified-in-iterable-type

---

---

Line app\Actions\Clinic\CreateClinicAction.php

---

16 Method App\Actions\Clinic\CreateClinicAction::handle() has parameter $clinicData with no value type specified in iterable type array.  
 🪪 missingType.iterableValue  
 💡 See: https://phpstan.org/blog/solving-phpstan-no-value-type-specified-in-iterable-type

---

---

Line app\Attributes\UsedIn.php

---

8 Property App\Attributes\UsedIn::$places type has no value type specified in iterable type array.  
 🪪 missingType.iterableValue  
 💡 See: https://phpstan.org/blog/solving-phpstan-no-value-type-specified-in-iterable-type  
 10 Method App\Attributes\UsedIn::\_\_construct() has parameter $places with no type specified.  
 🪪 missingType.parameter

---

---

Line app\Contracts\InternalExceptionInterface.php

---

7 Method App\Contracts\InternalExceptionInterface::exception() has no return type specified.  
 🪪 missingType.return

---

---

Line app\Contracts\UserRoleModelInterface.php

---

16 Method App\Contracts\UserRoleModelInterface::user() has no return type specified.  
 🪪 missingType.return

---

---

Line app\DTOs\Auth\RegisterUserDTO.php

---

10 Method App\DTOs\Auth\RegisterUserDTO::**construct() has parameter $email with no type specified.  
 🪪 missingType.parameter  
 10 Method App\DTOs\Auth\RegisterUserDTO::**construct() has parameter $email_verified_at with no type specified.  
 🪪 missingType.parameter  
 10 Method App\DTOs\Auth\RegisterUserDTO::**construct() has parameter $first_name with no type specified.  
 🪪 missingType.parameter  
 10 Method App\DTOs\Auth\RegisterUserDTO::**construct() has parameter $last_name with no type specified.  
 🪪 missingType.parameter  
 10 Method App\DTOs\Auth\RegisterUserDTO::**construct() has parameter $oauth_id with no type specified.  
 🪪 missingType.parameter  
 10 Method App\DTOs\Auth\RegisterUserDTO::**construct() has parameter $oauth_scopes with no type specified.  
 🪪 missingType.parameter  
 10 Method App\DTOs\Auth\RegisterUserDTO::**construct() has parameter $oauth_token with no type specified.  
 🪪 missingType.parameter  
 10 Method App\DTOs\Auth\RegisterUserDTO::**construct() has parameter $oauth_token_expires_in with no type specified.  
 🪪 missingType.parameter  
 10 Method App\DTOs\Auth\RegisterUserDTO::**construct() has parameter $password with no type specified.  
 🪪 missingType.parameter  
 10 Method App\DTOs\Auth\RegisterUserDTO::**construct() has parameter $phone with no type specified.  
 🪪 missingType.parameter  
 10 Method App\DTOs\Auth\RegisterUserDTO::**construct() has parameter $profile_photo_path with no type specified.  
 🪪 missingType.parameter  
 10 Method App\DTOs\Auth\RegisterUserDTO::**construct() has parameter $role with no type specified.  
 🪪 missingType.parameter  
 10 Method App\DTOs\Auth\RegisterUserDTO::\_\_construct() has parameter $username with no type specified.  
 🪪 missingType.parameter  
 30 Method App\DTOs\Auth\RegisterUserDTO::userData() return type has no value type specified in iterable type array.  
 🪪 missingType.iterableValue  
 💡 See: https://phpstan.org/blog/solving-phpstan-no-value-type-specified-in-iterable-type

---

---

Line app\DTOs\ClinicService\CreateClinicServiceDTO.php

---

18 Method App\DTOs\ClinicService\CreateClinicServiceDTO::clinicServiceData() return type has no value type specified in iterable type array.  
 🪪 missingType.iterableValue  
 💡 See: https://phpstan.org/blog/solving-phpstan-no-value-type-specified-in-iterable-type

---

---

Line app\DTOs\ClinicService\UpdateClinicServiceDTO.php

---

16 Method App\DTOs\ClinicService\UpdateClinicServiceDTO::clinicServiceData() return type has no value type specified in iterable type array.  
 🪪 missingType.iterableValue  
 💡 See: https://phpstan.org/blog/solving-phpstan-no-value-type-specified-in-iterable-type

---

---

Line app\DTOs\Doctor\CreateDoctorDTO.php

---

10 Property App\DTOs\Doctor\CreateDoctorDTO::$organization_id has no type specified.  
 🪪 missingType.property  
 12 Method App\DTOs\Doctor\CreateDoctorDTO::**construct() has parameter $available_days with no type specified.  
 🪪 missingType.parameter  
 12 Method App\DTOs\Doctor\CreateDoctorDTO::**construct() has parameter $end_time with no type specified.  
 🪪 missingType.parameter  
 12 Method App\DTOs\Doctor\CreateDoctorDTO::**construct() has parameter $license_number with no type specified.  
 🪪 missingType.parameter  
 12 Method App\DTOs\Doctor\CreateDoctorDTO::**construct() has parameter $notes with no type specified.  
 🪪 missingType.parameter  
 12 Method App\DTOs\Doctor\CreateDoctorDTO::**construct() has parameter $photo with no type specified.  
 🪪 missingType.parameter  
 12 Method App\DTOs\Doctor\CreateDoctorDTO::**construct() has parameter $qualifications with no type specified.  
 🪪 missingType.parameter  
 12 Method App\DTOs\Doctor\CreateDoctorDTO::**construct() has parameter $start_time with no type specified.  
 🪪 missingType.parameter  
 12 Method App\DTOs\Doctor\CreateDoctorDTO::**construct() has parameter $telehealth_phone with no type specified.  
 🪪 missingType.parameter  
 32 Method App\DTOs\Doctor\CreateDoctorDTO::userData() return type has no value type specified in iterable type array.  
 🪪 missingType.iterableValue  
 💡 See: https://phpstan.org/blog/solving-phpstan-no-value-type-specified-in-iterable-type  
 46 Method App\DTOs\Doctor\CreateDoctorDTO::doctorData() return type has no value type specified in iterable type array.  
 🪪 missingType.iterableValue  
 💡 See: https://phpstan.org/blog/solving-phpstan-no-value-type-specified-in-iterable-type

---

---

Line app\DTOs\Doctor\UpdateDoctorDTO.php

---

9 Method App\DTOs\Doctor\UpdateDoctorDTO::\_\_construct() has parameter $photo with no type specified.  
 🪪 missingType.parameter  
 23 Method App\DTOs\Doctor\UpdateDoctorDTO::userData() return type has no value type specified in iterable type array.  
 🪪 missingType.iterableValue  
 💡 See: https://phpstan.org/blog/solving-phpstan-no-value-type-specified-in-iterable-type  
 35 Method App\DTOs\Doctor\UpdateDoctorDTO::doctorData() return type has no value type specified in iterable type array.  
 🪪 missingType.iterableValue  
 💡 See: https://phpstan.org/blog/solving-phpstan-no-value-type-specified-in-iterable-type

---

---

Line app\DTOs\Patient\CreatePatientDTO.php

---

11 Property App\DTOs\Patient\CreatePatientDTO::$organization_id has no type specified.  
 🪪 missingType.property  
 13 Method App\DTOs\Patient\CreatePatientDTO::**construct() has parameter $address with no type specified.  
 🪪 missingType.parameter  
 13 Method App\DTOs\Patient\CreatePatientDTO::**construct() has parameter $age with no type specified.  
 🪪 missingType.parameter  
 13 Method App\DTOs\Patient\CreatePatientDTO::**construct() has parameter $allergies with no type specified.  
 🪪 missingType.parameter  
 13 Method App\DTOs\Patient\CreatePatientDTO::**construct() has parameter $clinic_id with no type specified.  
 🪪 missingType.parameter  
 13 Method App\DTOs\Patient\CreatePatientDTO::**construct() has parameter $first_name with no type specified.  
 🪪 missingType.parameter  
 13 Method App\DTOs\Patient\CreatePatientDTO::**construct() has parameter $gender with no type specified.  
 🪪 missingType.parameter  
 13 Method App\DTOs\Patient\CreatePatientDTO::**construct() has parameter $height with no type specified.  
 🪪 missingType.parameter  
 13 Method App\DTOs\Patient\CreatePatientDTO::**construct() has parameter $last_name with no type specified.  
 🪪 missingType.parameter  
 13 Method App\DTOs\Patient\CreatePatientDTO::**construct() has parameter $national_card_id with no type specified.  
 🪪 missingType.parameter  
 13 Method App\DTOs\Patient\CreatePatientDTO::**construct() has parameter $nationality with no type specified.  
 🪪 missingType.parameter  
 13 Method App\DTOs\Patient\CreatePatientDTO::**construct() has parameter $notes with no type specified.  
 🪪 missingType.parameter  
 13 Method App\DTOs\Patient\CreatePatientDTO::**construct() has parameter $other_phone with no type specified.  
 🪪 missingType.parameter  
 13 Method App\DTOs\Patient\CreatePatientDTO::**construct() has parameter $phone with no type specified.  
 🪪 missingType.parameter  
 13 Method App\DTOs\Patient\CreatePatientDTO::**construct() has parameter $photo with no type specified.  
 🪪 missingType.parameter  
 13 Method App\DTOs\Patient\CreatePatientDTO::\_\_construct() has parameter $weight with no type specified.  
 🪪 missingType.parameter  
 33 Method App\DTOs\Patient\CreatePatientDTO::patientData() return type has no value type specified in iterable type array.  
 🪪 missingType.iterableValue  
 💡 See: https://phpstan.org/blog/solving-phpstan-no-value-type-specified-in-iterable-type  
 51 Method App\DTOs\Patient\CreatePatientDTO::userData() return type has no value type specified in iterable type array.  
 🪪 missingType.iterableValue  
 💡 See: https://phpstan.org/blog/solving-phpstan-no-value-type-specified-in-iterable-type

---

---

Line app\Enums\Clinic\ClinicLevelEnum.php

---

12 Method App\Enums\Clinic\ClinicLevelEnum::getClinicLevelLabels() return type has no value type specified in iterable type array.  
 🪪 missingType.iterableValue  
 💡 See: https://phpstan.org/blog/solving-phpstan-no-value-type-specified-in-iterable-type  
 20 Method App\Enums\Clinic\ClinicLevelEnum::matchClinicLevelLabel() has parameter $clinicType with no type specified.  
 🪪 missingType.parameter

---

---

Line app\Enums\Clinic\ClinicTypeEnum.php

---

20 Method App\Enums\Clinic\ClinicTypeEnum::getClinicTypeLabels() return type has no value type specified in iterable type array.  
 🪪 missingType.iterableValue  
 💡 See: https://phpstan.org/blog/solving-phpstan-no-value-type-specified-in-iterable-type  
 36 Method App\Enums\Clinic\ClinicTypeEnum::matchClinicTypeLabel() has parameter $clinicType with no type specified.  
 🪪 missingType.parameter

---

---

Line app\Enums\Helpers\Dates\DaysEnum.php

---

15 Method App\Enums\Helpers\Dates\DaysEnum::getDaysLabels() return type has no value type specified in iterable type array.  
 🪪 missingType.iterableValue  
 💡 See: https://phpstan.org/blog/solving-phpstan-no-value-type-specified-in-iterable-type

---

---

Line app\Formatters\MoneyFormatter.php

---

7 Method App\Formatters\MoneyFormatter::format() has parameter $amount with no type specified.  
 🪪 missingType.parameter

---

---

Line app\Generators\ClinicCodeGenerator.php

---

30 Method App\Generators\ClinicCodeGenerator::checkExistingCodes() has parameter $generatedCodes with no value type specified in iterable type array.  
 🪪 missingType.iterableValue  
 💡 See: https://phpstan.org/blog/solving-phpstan-no-value-type-specified-in-iterable-type  
 30 Method App\Generators\ClinicCodeGenerator::checkExistingCodes() return type has no value type specified in iterable type array.  
 🪪 missingType.iterableValue  
 💡 See: https://phpstan.org/blog/solving-phpstan-no-value-type-specified-in-iterable-type

---

---

Line app\Generators\OrganizationBillingCodeGenerator.php

---

30 Method App\Generators\OrganizationBillingCodeGenerator::checkExistingCodes() has parameter $generatedCodes with no value type specified in iterable type array.  
 🪪 missingType.iterableValue  
 💡 See: https://phpstan.org/blog/solving-phpstan-no-value-type-specified-in-iterable-type  
 30 Method App\Generators\OrganizationBillingCodeGenerator::checkExistingCodes() return type has no value type specified in iterable type array.  
 🪪 missingType.iterableValue  
 💡 See: https://phpstan.org/blog/solving-phpstan-no-value-type-specified-in-iterable-type

---

---

Line app\Generators\PUIDGenerator.php

---

30 Method App\Generators\PUIDGenerator::checkExistingCodes() has parameter $generatedCodes with no value type specified in iterable type array.  
 🪪 missingType.iterableValue  
 💡 See: https://phpstan.org/blog/solving-phpstan-no-value-type-specified-in-iterable-type  
 30 Method App\Generators\PUIDGenerator::checkExistingCodes() return type has no value type specified in iterable type array.  
 🪪 missingType.iterableValue  
 💡 See: https://phpstan.org/blog/solving-phpstan-no-value-type-specified-in-iterable-type

---

---

Line app\Generators\base\Generator.php

---

41 Method App\Generators\base\Generator::checkExistingCodes() has parameter $generatedCodes with no value type specified in iterable type array.  
 🪪 missingType.iterableValue  
 💡 See: https://phpstan.org/blog/solving-phpstan-no-value-type-specified-in-iterable-type  
 41 Method App\Generators\base\Generator::checkExistingCodes() return type has no value type specified in iterable type array.  
 🪪 missingType.iterableValue  
 💡 See: https://phpstan.org/blog/solving-phpstan-no-value-type-specified-in-iterable-type

---

---

Line app\Helpers\helpers.php

---

15 Function speedTest() return type has no value type specified in iterable type array.  
 🪪 missingType.iterableValue  
 💡 See: https://phpstan.org/blog/solving-phpstan-no-value-type-specified-in-iterable-type  
 62 Function getAppName() has no return type specified.  
 🪪 missingType.return  
 69 Function js() has no return type specified.  
 🪪 missingType.return  
 86 Function css() has no return type specified.  
 🪪 missingType.return  
 103 Function obj() has parameter $objectData with no value type specified in iterable type array.  
 🪪 missingType.iterableValue  
 💡 See: https://phpstan.org/blog/solving-phpstan-no-value-type-specified-in-iterable-type  
 119 Function array_only() has parameter $array with no value type specified in iterable type array.  
 🪪 missingType.iterableValue  
 💡 See: https://phpstan.org/blog/solving-phpstan-no-value-type-specified-in-iterable-type  
 119 Function array_only() has parameter $keys with no value type specified in iterable type array.  
 🪪 missingType.iterableValue  
 💡 See: https://phpstan.org/blog/solving-phpstan-no-value-type-specified-in-iterable-type  
 119 Function array_only() return type has no value type specified in iterable type array.  
 🪪 missingType.iterableValue  
 💡 See: https://phpstan.org/blog/solving-phpstan-no-value-type-specified-in-iterable-type  
 126 Function log_dev() has parameter $e with no type specified.  
 🪪 missingType.parameter

---

---

Line app\Http\Controllers\Auth\Socialite\FacebookSocialiteController.php

---

20 Method App\Http\Controllers\Auth\Socialite\FacebookSocialiteController::redirect() has no return type specified.  
 🪪 missingType.return  
 25 Method App\Http\Controllers\Auth\Socialite\FacebookSocialiteController::callback() has no return type specified.  
 🪪 missingType.return

---

---

Line app\Http\Controllers\Auth\Socialite\GoogleSocialiteController.php

---

15 Method App\Http\Controllers\Auth\Socialite\GoogleSocialiteController::redirect() has no return type specified.  
 🪪 missingType.return  
 20 Method App\Http\Controllers\Auth\Socialite\GoogleSocialiteController::callback() has no return type specified.  
 🪪 missingType.return

---

---

Line app\Http\Controllers\PWA\LaravelPWAController.php

---

10 Method App\Http\Controllers\PWA\LaravelPWAController::manifestJson() has no return type specified.  
 🪪 missingType.return  
 17 Method App\Http\Controllers\PWA\LaravelPWAController::offline() has no return type specified.  
 🪪 missingType.return

---

---

Line app\Http\Requests\ClinicService\CreateClinicServiceRequest.php

---

9 Method App\Http\Requests\ClinicService\CreateClinicServiceRequest::\_\_construct() has parameter $clinicsIds with no value type specified in iterable type array.  
 🪪 missingType.iterableValue  
 💡 See: https://phpstan.org/blog/solving-phpstan-no-value-type-specified-in-iterable-type  
 14 Method App\Http\Requests\ClinicService\CreateClinicServiceRequest::rules() return type has no value type specified in iterable type array.  
 🪪 missingType.iterableValue  
 💡 See: https://phpstan.org/blog/solving-phpstan-no-value-type-specified-in-iterable-type

---

---

Line app\Http\Requests\ClinicService\UpdateClinicServiceRequest.php

---

9 Method App\Http\Requests\ClinicService\UpdateClinicServiceRequest::\_\_construct() has parameter $clinicsIds with no value type specified in iterable type array.  
 🪪 missingType.iterableValue  
 💡 See: https://phpstan.org/blog/solving-phpstan-no-value-type-specified-in-iterable-type  
 14 Method App\Http\Requests\ClinicService\UpdateClinicServiceRequest::rules() return type has no value type specified in iterable type array.  
 🪪 missingType.iterableValue  
 💡 See: https://phpstan.org/blog/solving-phpstan-no-value-type-specified-in-iterable-type

---

---

Line app\Http\Requests\Clinic\CreateClinicRequest.php

---

10 Method App\Http\Requests\Clinic\CreateClinicRequest::rules() return type has no value type specified in iterable type array.  
 🪪 missingType.iterableValue  
 💡 See: https://phpstan.org/blog/solving-phpstan-no-value-type-specified-in-iterable-type  
 15 Method App\Http\Requests\Clinic\CreateClinicRequest::stepOneRules() return type has no value type specified in iterable type array.  
 🪪 missingType.iterableValue  
 💡 See: https://phpstan.org/blog/solving-phpstan-no-value-type-specified-in-iterable-type  
 24 Method App\Http\Requests\Clinic\CreateClinicRequest::stepTwoRules() return type has no value type specified in iterable type array.  
 🪪 missingType.iterableValue  
 💡 See: https://phpstan.org/blog/solving-phpstan-no-value-type-specified-in-iterable-type  
 33 Method App\Http\Requests\Clinic\CreateClinicRequest::stepThreeRules() return type has no value type specified in iterable type array.  
 🪪 missingType.iterableValue  
 💡 See: https://phpstan.org/blog/solving-phpstan-no-value-type-specified-in-iterable-type  
 42 Method App\Http\Requests\Clinic\CreateClinicRequest::getClinicTypesArray() return type has no value type specified in iterable type array.  
 🪪 missingType.iterableValue  
 💡 See: https://phpstan.org/blog/solving-phpstan-no-value-type-specified-in-iterable-type

---

---

Line app\Http\Requests\Doctor\CreateDoctorRequest.php

---

10 Method App\Http\Requests\Doctor\CreateDoctorRequest::rules() return type has no value type specified in iterable type array.  
 🪪 missingType.iterableValue  
 💡 See: https://phpstan.org/blog/solving-phpstan-no-value-type-specified-in-iterable-type

---

---

Line app\Http\Requests\Doctor\UpdateDoctorRequest.php

---

10 Method App\Http\Requests\Doctor\UpdateDoctorRequest::\_\_construct() has parameter $doctor with no type specified.  
 🪪 missingType.parameter  
 15 Method App\Http\Requests\Doctor\UpdateDoctorRequest::rules() return type has no value type specified in iterable type array.  
 🪪 missingType.iterableValue  
 💡 See: https://phpstan.org/blog/solving-phpstan-no-value-type-specified-in-iterable-type

---

---

Line app\Http\Requests\Patient\CreatePatientRequest.php

---

9 Method App\Http\Requests\Patient\CreatePatientRequest::\_\_construct() has parameter $clinicsIds with no value type specified in iterable type array.  
 🪪 missingType.iterableValue  
 💡 See: https://phpstan.org/blog/solving-phpstan-no-value-type-specified-in-iterable-type  
 14 Method App\Http\Requests\Patient\CreatePatientRequest::rules() return type has no value type specified in iterable type array.  
 🪪 missingType.iterableValue  
 💡 See: https://phpstan.org/blog/solving-phpstan-no-value-type-specified-in-iterable-type

---

---

Line app\Livewire\App\Calendar\Calendar.php

---

11 Property App\Livewire\App\Calendar\Calendar::$events has no type specified.                                              
         🪪  missingType.property                                                                                                 
  13     Property App\Livewire\App\Calendar\Calendar::$config has no type specified.  
 🪪 missingType.property  
 15 Property App\Livewire\App\Calendar\Calendar::$clinics has no type specified.  
 🪪 missingType.property  
 17 Method App\Livewire\App\Calendar\Calendar::render() has no return type specified.  
 🪪 missingType.return  
 55 Method App\Livewire\App\Calendar\Calendar::getClinics() return type has no value type specified in iterable type array.  
 🪪 missingType.iterableValue  
 💡 See: https://phpstan.org/blog/solving-phpstan-no-value-type-specified-in-iterable-type  
 60 Method App\Livewire\App\Calendar\Calendar::deleteEventAction() has parameter $eventId with no type specified.  
 🪪 missingType.parameter

---

---

Line app\Livewire\App\Calendar\Includes\AddEventModal.php

---

44 Property App\Livewire\App\Calendar\Includes\AddEventModal::$title has no type specified.                                                                                           
         🪪  missingType.property                                                                                                                                                           
  46     Property App\Livewire\App\Calendar\Includes\AddEventModal::$start has no type specified.  
 🪪 missingType.property  
 48 Property App\Livewire\App\Calendar\Includes\AddEventModal::$end has no type specified.                                                                                             
         🪪  missingType.property                                                                                                                                                           
  50     Property App\Livewire\App\Calendar\Includes\AddEventModal::$allDay has no type specified.  
 🪪 missingType.property  
 52 Property App\Livewire\App\Calendar\Includes\AddEventModal::$search has no type specified.                                                                                          
         🪪  missingType.property                                                                                                                                                           
  54     Property App\Livewire\App\Calendar\Includes\AddEventModal::$clinics has no type specified.  
 🪪 missingType.property  
 57 Property App\Livewire\App\Calendar\Includes\AddEventModal::$searchResults has no type specified.                                                                                   
         🪪  missingType.property                                                                                                                                                           
  60     Property App\Livewire\App\Calendar\Includes\AddEventModal::$first_name has no type specified.  
 🪪 missingType.property  
 62 Property App\Livewire\App\Calendar\Includes\AddEventModal::$last_name has no type specified.                                                                                       
         🪪  missingType.property                                                                                                                                                           
  64     Property App\Livewire\App\Calendar\Includes\AddEventModal::$phone has no type specified.  
 🪪 missingType.property  
 66 Property App\Livewire\App\Calendar\Includes\AddEventModal::$other_phone has no type specified.                                                                                     
         🪪  missingType.property                                                                                                                                                           
  68     Property App\Livewire\App\Calendar\Includes\AddEventModal::$age has no type specified.  
 🪪 missingType.property  
 70 Property App\Livewire\App\Calendar\Includes\AddEventModal::$gender has no type specified.                                                                                          
         🪪  missingType.property                                                                                                                                                           
  72     Property App\Livewire\App\Calendar\Includes\AddEventModal::$clinic_id has no type specified.  
 🪪 missingType.property  
 75 Property App\Livewire\App\Calendar\Includes\AddEventModal::$patient_id has no type specified.                                                                                      
         🪪  missingType.property                                                                                                                                                           
  78     Property App\Livewire\App\Calendar\Includes\AddEventModal::$service_id has no type specified.  
 🪪 missingType.property  
 80 Method App\Livewire\App\Calendar\Includes\AddEventModal::render() has no return type specified.  
 🪪 missingType.return  
 89 Method App\Livewire\App\Calendar\Includes\AddEventModal::getClinicServices() has no return type specified.  
 🪪 missingType.return  
 95 Method App\Livewire\App\Calendar\Includes\AddEventModal::getSearchResults() return type with generic class Illuminate\Support\Collection does not specify its types: TKey, TValue  
 🪪 missingType.generics  
 100 Method App\Livewire\App\Calendar\Includes\AddEventModal::rules() return type has no value type specified in iterable type array.  
 🪪 missingType.iterableValue  
 💡 See: https://phpstan.org/blog/solving-phpstan-no-value-type-specified-in-iterable-type  
 119 Method App\Livewire\App\Calendar\Includes\AddEventModal::addedRules() return type has no value type specified in iterable type array.  
 🪪 missingType.iterableValue  
 💡 See: https://phpstan.org/blog/solving-phpstan-no-value-type-specified-in-iterable-type  
 128 Method App\Livewire\App\Calendar\Includes\AddEventModal::rulesForAddEventWithExistingPatient() return type has no value type specified in iterable type array.  
 🪪 missingType.iterableValue  
 💡 See: https://phpstan.org/blog/solving-phpstan-no-value-type-specified-in-iterable-type  
 229 Method App\Livewire\App\Calendar\Includes\AddEventModal::matchStatus() has parameter $actionResponseStatus with no type specified.  
 🪪 missingType.parameter  
 238 Method App\Livewire\App\Calendar\Includes\AddEventModal::dispatchEventToCalendar() has no return type specified.  
 🪪 missingType.return  
 238 Method App\Livewire\App\Calendar\Includes\AddEventModal::dispatchEventToCalendar() has parameter $dispatchedEvent with no type specified.  
 🪪 missingType.parameter  
 238 Method App\Livewire\App\Calendar\Includes\AddEventModal::dispatchEventToCalendar() has parameter $event with no type specified.  
 🪪 missingType.parameter  
 257 Method App\Livewire\App\Calendar\Includes\AddEventModal::resetForm() has no return type specified.  
 🪪 missingType.return

---

---

Line app\Livewire\App\Calendar\Includes\UpdateEventModal.php

---

15 Property App\Livewire\App\Calendar\Includes\UpdateEventModal::$model has no type specified.                                        
         🪪  missingType.property                                                                                                           
  17     Property App\Livewire\App\Calendar\Includes\UpdateEventModal::$update_event_id has no type specified.  
 🪪 missingType.property  
 19 Property App\Livewire\App\Calendar\Includes\UpdateEventModal::$update_allDay has no type specified.                                
         🪪  missingType.property                                                                                                           
  21     Property App\Livewire\App\Calendar\Includes\UpdateEventModal::$update_start has no type specified.  
 🪪 missingType.property  
 23 Property App\Livewire\App\Calendar\Includes\UpdateEventModal::$update_end has no type specified.                                   
         🪪  missingType.property                                                                                                           
  25     Property App\Livewire\App\Calendar\Includes\UpdateEventModal::$update_title has no type specified.  
 🪪 missingType.property  
 27 Method App\Livewire\App\Calendar\Includes\UpdateEventModal::render() has no return type specified.  
 🪪 missingType.return  
 34 Method App\Livewire\App\Calendar\Includes\UpdateEventModal::updateEventAction() has parameter $event with no type specified.  
 🪪 missingType.parameter  
 72 Method App\Livewire\App\Calendar\Includes\UpdateEventModal::updateEventDateAction() has parameter $allDay with no type specified.  
 🪪 missingType.parameter  
 72 Method App\Livewire\App\Calendar\Includes\UpdateEventModal::updateEventDateAction() has parameter $end with no type specified.  
 🪪 missingType.parameter  
 72 Method App\Livewire\App\Calendar\Includes\UpdateEventModal::updateEventDateAction() has parameter $id with no type specified.  
 🪪 missingType.parameter  
 72 Method App\Livewire\App\Calendar\Includes\UpdateEventModal::updateEventDateAction() has parameter $start with no type specified.  
 🪪 missingType.parameter

---

---

Line app\Livewire\App\ClinicService\ClinicServiceTable.php

---

19 Method App\Livewire\App\ClinicService\ClinicServiceTable::getClinicServices() return type with generic interface Illuminate\Contracts\Pagination\LengthAwarePaginator does not specify its types: TItem  
 🪪 missingType.generics  
 24 Method App\Livewire\App\ClinicService\ClinicServiceTable::getClinics() return type has no value type specified in iterable type array.  
 🪪 missingType.iterableValue  
 💡 See: https://phpstan.org/blog/solving-phpstan-no-value-type-specified-in-iterable-type  
 29 Method App\Livewire\App\ClinicService\ClinicServiceTable::deleteClinicServiceAction() has parameter $id with no type specified.  
 🪪 missingType.parameter  
 49 Method App\Livewire\App\ClinicService\ClinicServiceTable::matchStatus() has parameter $actionResponseStatus with no type specified.  
 🪪 missingType.parameter  
 58 Method App\Livewire\App\ClinicService\ClinicServiceTable::render() has no return type specified.  
 🪪 missingType.return

---

---

Line app\Livewire\App\ClinicService\Includes\CreateClinicServiceModal.php

---

13 Property App\Livewire\App\ClinicService\Includes\CreateClinicServiceModal::$withButton has no type specified.                                       
         🪪  missingType.property                                                                                                                            
  15     Property App\Livewire\App\ClinicService\Includes\CreateClinicServiceModal::$showName has no type specified.  
 🪪 missingType.property  
 17 Property App\Livewire\App\ClinicService\Includes\CreateClinicServiceModal::$clinics has no type specified.                                          
         🪪  missingType.property                                                                                                                            
  19     Property App\Livewire\App\ClinicService\Includes\CreateClinicServiceModal::$name has no type specified.  
 🪪 missingType.property  
 21 Property App\Livewire\App\ClinicService\Includes\CreateClinicServiceModal::$clinic_id has no type specified.                                        
         🪪  missingType.property                                                                                                                            
  23     Property App\Livewire\App\ClinicService\Includes\CreateClinicServiceModal::$price has no type specified.  
 🪪 missingType.property  
 25 Property App\Livewire\App\ClinicService\Includes\CreateClinicServiceModal::$description has no type specified.                                      
         🪪  missingType.property                                                                                                                            
  27     Property App\Livewire\App\ClinicService\Includes\CreateClinicServiceModal::$color has no type specified.  
 🪪 missingType.property  
 29 Method App\Livewire\App\ClinicService\Includes\CreateClinicServiceModal::rules() return type has no value type specified in iterable type array.  
 🪪 missingType.iterableValue  
 💡 See: https://phpstan.org/blog/solving-phpstan-no-value-type-specified-in-iterable-type  
 56 Method App\Livewire\App\ClinicService\Includes\CreateClinicServiceModal::matchStatus() has parameter $actionResponseStatus with no type specified.  
 🪪 missingType.parameter  
 65 Method App\Livewire\App\ClinicService\Includes\CreateClinicServiceModal::resetForm() has no return type specified.  
 🪪 missingType.return  
 73 Method App\Livewire\App\ClinicService\Includes\CreateClinicServiceModal::render() has no return type specified.  
 🪪 missingType.return

---

---

Line app\Livewire\App\ClinicService\Includes\InfoClinicServiceModal.php

---

9 Property App\Livewire\App\ClinicService\Includes\InfoClinicServiceModal::$clinicService has no type specified.  
 🪪 missingType.property  
 11 Method App\Livewire\App\ClinicService\Includes\InfoClinicServiceModal::render() has no return type specified.  
 🪪 missingType.return

---

---

Line app\Livewire\App\ClinicService\Includes\UpdateClinicServiceModal.php

---

14 Property App\Livewire\App\ClinicService\Includes\UpdateClinicServiceModal::$showName has no type specified.                                                      
         🪪  missingType.property                                                                                                                                         
  16     Property App\Livewire\App\ClinicService\Includes\UpdateClinicServiceModal::$withButton has no type specified.  
 🪪 missingType.property  
 18 Property App\Livewire\App\ClinicService\Includes\UpdateClinicServiceModal::$clinics has no type specified.                                                       
         🪪  missingType.property                                                                                                                                         
  20     Property App\Livewire\App\ClinicService\Includes\UpdateClinicServiceModal::$clinicServiceId has no type specified.  
 🪪 missingType.property  
 22 Property App\Livewire\App\ClinicService\Includes\UpdateClinicServiceModal::$name has no type specified.                                                          
         🪪  missingType.property                                                                                                                                         
  24     Property App\Livewire\App\ClinicService\Includes\UpdateClinicServiceModal::$price has no type specified.  
 🪪 missingType.property  
 26 Property App\Livewire\App\ClinicService\Includes\UpdateClinicServiceModal::$description has no type specified.                                                   
         🪪  missingType.property                                                                                                                                         
  28     Property App\Livewire\App\ClinicService\Includes\UpdateClinicServiceModal::$color has no type specified.  
 🪪 missingType.property  
 30 Property App\Livewire\App\ClinicService\Includes\UpdateClinicServiceModal::$clinic_id has no type specified.  
 🪪 missingType.property  
 32 Method App\Livewire\App\ClinicService\Includes\UpdateClinicServiceModal::mount() has parameter $clinicService with no type specified.  
 🪪 missingType.parameter  
 32 Method App\Livewire\App\ClinicService\Includes\UpdateClinicServiceModal::mount() has parameter $clinics with no value type specified in iterable type array.  
 🪪 missingType.iterableValue  
 💡 See: https://phpstan.org/blog/solving-phpstan-no-value-type-specified-in-iterable-type  
 45 Method App\Livewire\App\ClinicService\Includes\UpdateClinicServiceModal::render() has no return type specified.  
 🪪 missingType.return  
 50 Method App\Livewire\App\ClinicService\Includes\UpdateClinicServiceModal::rules() return type has no value type specified in iterable type array.  
 🪪 missingType.iterableValue  
 💡 See: https://phpstan.org/blog/solving-phpstan-no-value-type-specified-in-iterable-type  
 55 Method App\Livewire\App\ClinicService\Includes\UpdateClinicServiceModal::prepareForValidation() has parameter $attributes with no type specified.  
 🪪 missingType.parameter  
 55 Method App\Livewire\App\ClinicService\Includes\UpdateClinicServiceModal::prepareForValidation() return type has no value type specified in iterable type array.  
 🪪 missingType.iterableValue  
 💡 See: https://phpstan.org/blog/solving-phpstan-no-value-type-specified-in-iterable-type  
 86 Method App\Livewire\App\ClinicService\Includes\UpdateClinicServiceModal::matchStatus() has parameter $status with no type specified.  
 🪪 missingType.parameter  
 95 Method App\Livewire\App\ClinicService\Includes\UpdateClinicServiceModal::resetForm() has no return type specified.  
 🪪 missingType.return

---

---

Line app\Livewire\App\Clinic\ClinicTable.php

---

13 Method App\Livewire\App\Clinic\ClinicTable::getClinics() return type with generic interface Illuminate\Contracts\Pagination\LengthAwarePaginator does not specify its types: TItem  
 🪪 missingType.generics  
 18 Method App\Livewire\App\Clinic\ClinicTable::render() has no return type specified.  
 🪪 missingType.return

---

---

Line app\Livewire\App\Clinic\Includes\CreateClinicModal.php

---

12 Method App\Livewire\App\Clinic\Includes\CreateClinicModal::render() has no return type specified.  
 🪪 missingType.return

---

---

Line app\Livewire\App\Doctor\DoctorTable.php

---

22 Method App\Livewire\App\Doctor\DoctorTable::getDoctors() has no return type specified.  
 🪪 missingType.return  
 31 Method App\Livewire\App\Doctor\DoctorTable::getClinics() return type has no value type specified in iterable type array.  
 🪪 missingType.iterableValue  
 💡 See: https://phpstan.org/blog/solving-phpstan-no-value-type-specified-in-iterable-type  
 36 Method App\Livewire\App\Doctor\DoctorTable::deleteDoctorAction() has parameter $id with no type specified.  
 🪪 missingType.parameter  
 56 Method App\Livewire\App\Doctor\DoctorTable::matchStatus() has parameter $actionResponseStatus with no type specified.  
 🪪 missingType.parameter  
 65 Method App\Livewire\App\Doctor\DoctorTable::render() has no return type specified.  
 🪪 missingType.return

---

---

Line app\Livewire\App\Doctor\Includes\CreateDoctorModal.php

---

22 Property App\Livewire\App\Doctor\Includes\CreateDoctorModal::$clinics has no type specified.                                                    
         🪪  missingType.property                                                                                                                        
  24     Property App\Livewire\App\Doctor\Includes\CreateDoctorModal::$days has no type specified.  
 🪪 missingType.property  
 26 Property App\Livewire\App\Doctor\Includes\CreateDoctorModal::$username has no type specified.                                                   
         🪪  missingType.property                                                                                                                        
  28     Property App\Livewire\App\Doctor\Includes\CreateDoctorModal::$password has no type specified.  
 🪪 missingType.property  
 30 Property App\Livewire\App\Doctor\Includes\CreateDoctorModal::$first_name has no type specified.                                                 
         🪪  missingType.property                                                                                                                        
  32     Property App\Livewire\App\Doctor\Includes\CreateDoctorModal::$last_name has no type specified.  
 🪪 missingType.property  
 34 Property App\Livewire\App\Doctor\Includes\CreateDoctorModal::$specialization has no type specified.                                             
         🪪  missingType.property                                                                                                                        
  36     Property App\Livewire\App\Doctor\Includes\CreateDoctorModal::$clinic_ids has no type specified.  
 🪪 missingType.property  
 38 Property App\Livewire\App\Doctor\Includes\CreateDoctorModal::$phone has no type specified.                                                      
         🪪  missingType.property                                                                                                                        
  40     Property App\Livewire\App\Doctor\Includes\CreateDoctorModal::$other_phone has no type specified.  
 🪪 missingType.property  
 42 Property App\Livewire\App\Doctor\Includes\CreateDoctorModal::$photo has no type specified.                                                      
         🪪  missingType.property                                                                                                                        
  44     Property App\Livewire\App\Doctor\Includes\CreateDoctorModal::$selected_days has no type specified.  
 🪪 missingType.property  
 46 Property App\Livewire\App\Doctor\Includes\CreateDoctorModal::$license_number has no type specified.                                             
         🪪  missingType.property                                                                                                                        
  48     Property App\Livewire\App\Doctor\Includes\CreateDoctorModal::$qualifications has no type specified.  
 🪪 missingType.property  
 50 Property App\Livewire\App\Doctor\Includes\CreateDoctorModal::$available_days has no type specified.                                             
         🪪  missingType.property                                                                                                                        
  52     Property App\Livewire\App\Doctor\Includes\CreateDoctorModal::$start_time has no type specified.  
 🪪 missingType.property  
 54 Property App\Livewire\App\Doctor\Includes\CreateDoctorModal::$end_time has no type specified.                                                   
         🪪  missingType.property                                                                                                                        
  56     Property App\Livewire\App\Doctor\Includes\CreateDoctorModal::$telehealth_phone has no type specified.  
 🪪 missingType.property  
 58 Property App\Livewire\App\Doctor\Includes\CreateDoctorModal::$notes has no type specified.  
 🪪 missingType.property  
 60 Method App\Livewire\App\Doctor\Includes\CreateDoctorModal::mount() has parameter $clinics with no value type specified in iterable type array.  
 🪪 missingType.iterableValue  
 💡 See: https://phpstan.org/blog/solving-phpstan-no-value-type-specified-in-iterable-type  
 67 Method App\Livewire\App\Doctor\Includes\CreateDoctorModal::rules() return type has no value type specified in iterable type array.  
 🪪 missingType.iterableValue  
 💡 See: https://phpstan.org/blog/solving-phpstan-no-value-type-specified-in-iterable-type  
 93 Method App\Livewire\App\Doctor\Includes\CreateDoctorModal::matchStatus() has parameter $actionResponseStatus with no type specified.  
 🪪 missingType.parameter  
 114 Method App\Livewire\App\Doctor\Includes\CreateDoctorModal::render() has no return type specified.  
 🪪 missingType.return

---

---

Line app\Livewire\App\Doctor\Includes\InfoDoctorModal.php

---

11 Property App\Livewire\App\Doctor\Includes\InfoDoctorModal::$doctor has no type specified.                                                     
         🪪  missingType.property                                                                                                                      
  13     Property App\Livewire\App\Doctor\Includes\InfoDoctorModal::$clinics has no type specified.  
 🪪 missingType.property  
 15 Method App\Livewire\App\Doctor\Includes\InfoDoctorModal::mount() has parameter $clinics with no value type specified in iterable type array.  
 🪪 missingType.iterableValue  
 💡 See: https://phpstan.org/blog/solving-phpstan-no-value-type-specified-in-iterable-type  
 15 Method App\Livewire\App\Doctor\Includes\InfoDoctorModal::mount() has parameter $doctor with no type specified.  
 🪪 missingType.parameter  
 21 Method App\Livewire\App\Doctor\Includes\InfoDoctorModal::render() has no return type specified.  
 🪪 missingType.return

---

---

Line app\Livewire\App\Doctor\Includes\UpdateDoctorModal.php

---

22 Property App\Livewire\App\Doctor\Includes\UpdateDoctorModal::$doctor has no type specified.                                                     
         🪪  missingType.property                                                                                                                        
  25     Property App\Livewire\App\Doctor\Includes\UpdateDoctorModal::$clinics has no type specified.  
 🪪 missingType.property  
 28 Property App\Livewire\App\Doctor\Includes\UpdateDoctorModal::$username has no type specified.                                                   
         🪪  missingType.property                                                                                                                        
  30     Property App\Livewire\App\Doctor\Includes\UpdateDoctorModal::$first_name has no type specified.  
 🪪 missingType.property  
 32 Property App\Livewire\App\Doctor\Includes\UpdateDoctorModal::$last_name has no type specified.                                                  
         🪪  missingType.property                                                                                                                        
  34     Property App\Livewire\App\Doctor\Includes\UpdateDoctorModal::$specialization has no type specified.  
 🪪 missingType.property  
 36 Property App\Livewire\App\Doctor\Includes\UpdateDoctorModal::$organization_id has no type specified.                                            
         🪪  missingType.property                                                                                                                        
  38     Property App\Livewire\App\Doctor\Includes\UpdateDoctorModal::$phone has no type specified.  
 🪪 missingType.property  
 40 Property App\Livewire\App\Doctor\Includes\UpdateDoctorModal::$other_phone has no type specified.                                                
         🪪  missingType.property                                                                                                                        
  42     Property App\Livewire\App\Doctor\Includes\UpdateDoctorModal::$photo has no type specified.  
 🪪 missingType.property  
 44 Property App\Livewire\App\Doctor\Includes\UpdateDoctorModal::$password has no type specified.                                                   
         🪪  missingType.property                                                                                                                        
  46     Property App\Livewire\App\Doctor\Includes\UpdateDoctorModal::$password_confirmation has no type specified.  
 🪪 missingType.property  
 48 Method App\Livewire\App\Doctor\Includes\UpdateDoctorModal::mount() has parameter $clinics with no value type specified in iterable type array.  
 🪪 missingType.iterableValue  
 💡 See: https://phpstan.org/blog/solving-phpstan-no-value-type-specified-in-iterable-type  
 48 Method App\Livewire\App\Doctor\Includes\UpdateDoctorModal::mount() has parameter $doctor with no type specified.  
 🪪 missingType.parameter  
 60 Method App\Livewire\App\Doctor\Includes\UpdateDoctorModal::rules() return type has no value type specified in iterable type array.  
 🪪 missingType.iterableValue  
 💡 See: https://phpstan.org/blog/solving-phpstan-no-value-type-specified-in-iterable-type  
 91 Method App\Livewire\App\Doctor\Includes\UpdateDoctorModal::matchStatus() has parameter $actionResponseStatus with no type specified.  
 🪪 missingType.parameter  
 100 Method App\Livewire\App\Doctor\Includes\UpdateDoctorModal::render() has no return type specified.  
 🪪 missingType.return

---

---

Line app\Livewire\App\Patient\Includes\CreatePatientModal.php

---

16 Property App\Livewire\App\Patient\Includes\CreatePatientModal::$withButton has no type specified.                                                 
         🪪  missingType.property                                                                                                                          
  18     Property App\Livewire\App\Patient\Includes\CreatePatientModal::$showName has no type specified.  
 🪪 missingType.property  
 20 Property App\Livewire\App\Patient\Includes\CreatePatientModal::$clinics has no type specified.                                                    
         🪪  missingType.property                                                                                                                          
  22     Property App\Livewire\App\Patient\Includes\CreatePatientModal::$first_name has no type specified.  
 🪪 missingType.property  
 24 Property App\Livewire\App\Patient\Includes\CreatePatientModal::$last_name has no type specified.                                                  
         🪪  missingType.property                                                                                                                          
  26     Property App\Livewire\App\Patient\Includes\CreatePatientModal::$age has no type specified.  
 🪪 missingType.property  
 28 Property App\Livewire\App\Patient\Includes\CreatePatientModal::$clinic_id has no type specified.                                                  
         🪪  missingType.property                                                                                                                          
  30     Property App\Livewire\App\Patient\Includes\CreatePatientModal::$phone has no type specified.  
 🪪 missingType.property  
 32 Property App\Livewire\App\Patient\Includes\CreatePatientModal::$other_phone has no type specified.                                                
         🪪  missingType.property                                                                                                                          
  34     Property App\Livewire\App\Patient\Includes\CreatePatientModal::$gender has no type specified.  
 🪪 missingType.property  
 36 Property App\Livewire\App\Patient\Includes\CreatePatientModal::$address has no type specified.                                                    
         🪪  missingType.property                                                                                                                          
  38     Property App\Livewire\App\Patient\Includes\CreatePatientModal::$allergies has no type specified.  
 🪪 missingType.property  
 40 Property App\Livewire\App\Patient\Includes\CreatePatientModal::$height has no type specified.                                                     
         🪪  missingType.property                                                                                                                          
  42     Property App\Livewire\App\Patient\Includes\CreatePatientModal::$weight has no type specified.  
 🪪 missingType.property  
 44 Property App\Livewire\App\Patient\Includes\CreatePatientModal::$national_card_id has no type specified.                                           
         🪪  missingType.property                                                                                                                          
  46     Property App\Livewire\App\Patient\Includes\CreatePatientModal::$nationality has no type specified.  
 🪪 missingType.property  
 48 Property App\Livewire\App\Patient\Includes\CreatePatientModal::$notes has no type specified.                                                      
         🪪  missingType.property                                                                                                                          
  50     Property App\Livewire\App\Patient\Includes\CreatePatientModal::$photo has no type specified.  
 🪪 missingType.property  
 52 Method App\Livewire\App\Patient\Includes\CreatePatientModal::mount() has parameter $clinics with no value type specified in iterable type array.  
 🪪 missingType.iterableValue  
 💡 See: https://phpstan.org/blog/solving-phpstan-no-value-type-specified-in-iterable-type  
 58 Method App\Livewire\App\Patient\Includes\CreatePatientModal::render() has no return type specified.  
 🪪 missingType.return  
 63 Method App\Livewire\App\Patient\Includes\CreatePatientModal::rules() return type has no value type specified in iterable type array.  
 🪪 missingType.iterableValue  
 💡 See: https://phpstan.org/blog/solving-phpstan-no-value-type-specified-in-iterable-type  
 90 Method App\Livewire\App\Patient\Includes\CreatePatientModal::matchStatus() has parameter $actionResponseStatus with no type specified.  
 🪪 missingType.parameter

---

---

Line app\Livewire\App\Patient\PatientTable.php

---

16 Property App\Livewire\App\Patient\PatientTable::$search has no type specified.  
 🪪 missingType.property  
 18 Method App\Livewire\App\Patient\PatientTable::getPatients() return type with generic interface Illuminate\Contracts\Pagination\LengthAwarePaginator does not specify its types: TItem  
 🪪 missingType.generics  
 23 Method App\Livewire\App\Patient\PatientTable::getClinics() return type has no value type specified in iterable type array.  
 🪪 missingType.iterableValue  
 💡 See: https://phpstan.org/blog/solving-phpstan-no-value-type-specified-in-iterable-type  
 28 Method App\Livewire\App\Patient\PatientTable::render() has no return type specified.  
 🪪 missingType.return

---

---

Line app\Livewire\App\Patient\ShowPatient.php

---

14 Method App\Livewire\App\Patient\ShowPatient::render() has no return type specified.  
 🪪 missingType.return

---

---

Line app\Livewire\App\Queue\QueueTable.php

---

14 Property App\Livewire\App\Queue\QueueTable::$search has no type specified.  
 🪪 missingType.property  
 16 Method App\Livewire\App\Queue\QueueTable::getQueues() return type with generic interface Illuminate\Contracts\Pagination\LengthAwarePaginator does not specify its types: TItem  
 🪪 missingType.generics  
 21 Method App\Livewire\App\Queue\QueueTable::getClinics() has no return type specified.  
 🪪 missingType.return  
 26 Method App\Livewire\App\Queue\QueueTable::render() has no return type specified.  
 🪪 missingType.return

---

---

Line app\Livewire\App\Reception\ReceptionGlobalSearchModal.php

---

13 Property App\Livewire\App\Reception\ReceptionGlobalSearchModal::$show has no type specified.                                                                                            
         🪪  missingType.property                                                                                                                                                                
  15     Property App\Livewire\App\Reception\ReceptionGlobalSearchModal::$search has no type specified.  
 🪪 missingType.property  
 17 Property App\Livewire\App\Reception\ReceptionGlobalSearchModal::$searchType has no type specified.  
 🪪 missingType.property  
 19 Method App\Livewire\App\Reception\ReceptionGlobalSearchModal::render() has no return type specified.  
 🪪 missingType.return  
 26 Method App\Livewire\App\Reception\ReceptionGlobalSearchModal::getSearchResults() return type has no value type specified in iterable type array.  
 🪪 missingType.iterableValue  
 💡 See: https://phpstan.org/blog/solving-phpstan-no-value-type-specified-in-iterable-type  
 26 Method App\Livewire\App\Reception\ReceptionGlobalSearchModal::getSearchResults() return type has no value type specified in iterable type array|Illuminate\Support\Collection.  
 🪪 missingType.iterableValue  
 💡 See: https://phpstan.org/blog/solving-phpstan-no-value-type-specified-in-iterable-type  
 26 Method App\Livewire\App\Reception\ReceptionGlobalSearchModal::getSearchResults() return type with generic class Illuminate\Support\Collection does not specify its types: TKey, TValue  
 🪪 missingType.generics  
 35 Method App\Livewire\App\Reception\ReceptionGlobalSearchModal::getSearchResultUrl() has no return type specified.  
 🪪 missingType.return  
 35 Method App\Livewire\App\Reception\ReceptionGlobalSearchModal::getSearchResultUrl() has parameter $searchResultId with no type specified.  
 🪪 missingType.parameter

---

---

Line app\Livewire\Auth\Register\Register.php

---

18 Property App\Livewire\Auth\Register\Register::$name has no type specified.                                                    
         🪪  missingType.property                                                                                                      
  20     Property App\Livewire\Auth\Register\Register::$type has no type specified.  
 🪪 missingType.property  
 22 Property App\Livewire\Auth\Register\Register::$first_name has no type specified.                                              
         🪪  missingType.property                                                                                                      
  24     Property App\Livewire\Auth\Register\Register::$last_name has no type specified.  
 🪪 missingType.property  
 26 Property App\Livewire\Auth\Register\Register::$phone has no type specified.                                                   
         🪪  missingType.property                                                                                                      
  28     Property App\Livewire\Auth\Register\Register::$username has no type specified.  
 🪪 missingType.property  
 30 Property App\Livewire\Auth\Register\Register::$password has no type specified.                                                
         🪪  missingType.property                                                                                                      
  32     Property App\Livewire\Auth\Register\Register::$password_confirmation has no type specified.  
 🪪 missingType.property  
 35 Property App\Livewire\Auth\Register\Register::$policy has no type specified.  
 🪪 missingType.property  
 42 Method App\Livewire\Auth\Register\Register::stepOneRules() return type has no value type specified in iterable type array.  
 🪪 missingType.iterableValue  
 💡 See: https://phpstan.org/blog/solving-phpstan-no-value-type-specified-in-iterable-type  
 47 Method App\Livewire\Auth\Register\Register::stepTwoRules() return type has no value type specified in iterable type array.  
 🪪 missingType.iterableValue  
 💡 See: https://phpstan.org/blog/solving-phpstan-no-value-type-specified-in-iterable-type  
 52 Method App\Livewire\Auth\Register\Register::stepThreeRules() return type has no value type specified in iterable type array.  
 🪪 missingType.iterableValue  
 💡 See: https://phpstan.org/blog/solving-phpstan-no-value-type-specified-in-iterable-type  
 100 Method App\Livewire\Auth\Register\Register::render() has no return type specified.  
 🪪 missingType.return

---

---

Line app\Livewire\Auth\Register\Steps\OAuthCallback.php

---

13 Property App\Livewire\Auth\Register\Steps\OAuthCallback::$userData has no type specified.                                                    
         🪪  missingType.property                                                                                                                     
  15     Property App\Livewire\Auth\Register\Steps\OAuthCallback::$name has no type specified.  
 🪪 missingType.property  
 17 Property App\Livewire\Auth\Register\Steps\OAuthCallback::$type has no type specified.                                                        
         🪪  missingType.property                                                                                                                     
  19     Property App\Livewire\Auth\Register\Steps\OAuthCallback::$policy has no type specified.  
 🪪 missingType.property  
 21 Method App\Livewire\Auth\Register\Steps\OAuthCallback::mount() has parameter $userData with no value type specified in iterable type array.  
 🪪 missingType.iterableValue  
 💡 See: https://phpstan.org/blog/solving-phpstan-no-value-type-specified-in-iterable-type  
 26 Method App\Livewire\Auth\Register\Steps\OAuthCallback::rules() return type has no value type specified in iterable type array.  
 🪪 missingType.iterableValue  
 💡 See: https://phpstan.org/blog/solving-phpstan-no-value-type-specified-in-iterable-type  
 31 Method App\Livewire\Auth\Register\Steps\OAuthCallback::render() has no return type specified.  
 🪪 missingType.return

---

---

Line app\Models\Calendar.php

---

13 Class App\Models\Calendar uses generic trait Illuminate\Database\Eloquent\Factories\HasFactory but does not specify its types: TFactory  
 🪪 missingType.generics  
 17 Method App\Models\Calendar::clinicServices() has no return type specified.  
 🪪 missingType.return

---

---

Line app\Models\Clinic.php

---

13 Class App\Models\Clinic uses generic trait Illuminate\Database\Eloquent\Factories\HasFactory but does not specify its types: TFactory  
 🪪 missingType.generics  
 17 Method App\Models\Clinic::subClinics() has no return type specified.  
 🪪 missingType.return  
 22 Method App\Models\Clinic::parentClinic() has no return type specified.  
 🪪 missingType.return  
 27 Method App\Models\Clinic::organization() has no return type specified.  
 🪪 missingType.return  
 32 Method App\Models\Clinic::list() return type has no value type specified in iterable type array.  
 🪪 missingType.iterableValue  
 💡 See: https://phpstan.org/blog/solving-phpstan-no-value-type-specified-in-iterable-type

---

---

Line app\Models\ClinicAdmin.php

---

14 Class App\Models\ClinicAdmin uses generic trait Illuminate\Database\Eloquent\Factories\HasFactory but does not specify its types: TFactory  
 🪪 missingType.generics  
 37 Method App\Models\ClinicAdmin::user() has no return type specified.  
 🪪 missingType.return  
 42 Method App\Models\ClinicAdmin::clinic() has no return type specified.  
 🪪 missingType.return  
 47 Method App\Models\ClinicAdmin::subClinics() has no return type specified.  
 🪪 missingType.return

---

---

Line app\Models\ClinicService.php

---

13 Class App\Models\ClinicService uses generic trait Illuminate\Database\Eloquent\Factories\HasFactory but does not specify its types: TFactory  
 🪪 missingType.generics  
 17 Method App\Models\ClinicService::list() has no return type specified.  
 🪪 missingType.return

---

---

Line app\Models\Doctor.php

---

15 Class App\Models\Doctor uses generic trait Illuminate\Database\Eloquent\Factories\HasFactory but does not specify its types: TFactory  
 🪪 missingType.generics  
 19 Method App\Models\Doctor::user() return type with generic class Illuminate\Database\Eloquent\Relations\BelongsTo does not specify its types: TRelatedModel, TDeclaringModel  
 🪪 missingType.generics  
 24 Method App\Models\Doctor::clinic() return type with generic class Illuminate\Database\Eloquent\Relations\BelongsTo does not specify its types: TRelatedModel, TDeclaringModel  
 🪪 missingType.generics

---

---

Line app\Models\Manager.php

---

11 Class App\Models\Manager uses generic trait Illuminate\Database\Eloquent\Factories\HasFactory but does not specify its types: TFactory  
 🪪 missingType.generics  
 13 Method App\Models\Manager::user() has no return type specified.  
 🪪 missingType.return

---

---

Line app\Models\Organization.php

---

11 Class App\Models\Organization uses generic trait Illuminate\Database\Eloquent\Factories\HasFactory but does not specify its types: TFactory  
 🪪 missingType.generics  
 15 Method App\Models\Organization::clinics() has no return type specified.  
 🪪 missingType.return  
 20 Method App\Models\Organization::clinicServices() has no return type specified.  
 🪪 missingType.return  
 25 Method App\Models\Organization::clinicAdmins() has no return type specified.  
 🪪 missingType.return  
 30 Method App\Models\Organization::users() has no return type specified.  
 🪪 missingType.return

---

---

Line app\Models\Patient.php

---

13 Class App\Models\Patient uses generic trait Illuminate\Database\Eloquent\Factories\HasFactory but does not specify its types: TFactory  
 🪪 missingType.generics  
 17 Method App\Models\Patient::user() has no return type specified.  
 🪪 missingType.return  
 22 Method App\Models\Patient::clinic() has no return type specified.  
 🪪 missingType.return

---

---

Line app\Models\Plan.php

---

10 Class App\Models\Plan uses generic trait Illuminate\Database\Eloquent\Factories\HasFactory but does not specify its types: TFactory  
 🪪 missingType.generics

---

---

Line app\Models\Receptionist.php

---

13 Class App\Models\Receptionist uses generic trait Illuminate\Database\Eloquent\Factories\HasFactory but does not specify its types: TFactory  
 🪪 missingType.generics

---

---

Line app\Models\Scopes\OrganizationScope.php

---

16 Method App\Models\Scopes\OrganizationScope::apply() has parameter $builder with generic class Illuminate\Database\Eloquent\Builder but does not specify its types: TModel  
 🪪 missingType.generics

---

---

Line app\Models\User.php

---

21 Class App\Models\User uses generic trait Illuminate\Database\Eloquent\Factories\HasFactory but does not specify its types: TFactory  
 🪪 missingType.generics  
 92 Method App\Models\User::organization() has no return type specified.  
 🪪 missingType.return  
 97 Method App\Models\User::user() has no return type specified.  
 🪪 missingType.return  
 109 Method App\Models\User::clinicAdmin() has no return type specified.  
 🪪 missingType.return  
 114 Method App\Models\User::doctor() has no return type specified.  
 🪪 missingType.return  
 119 Method App\Models\User::patient() has no return type specified.  
 🪪 missingType.return  
 124 Method App\Models\User::receptionist() has no return type specified.  
 🪪 missingType.return  
 129 Method App\Models\User::manager() has no return type specified.  
 🪪 missingType.return  
 134 Method App\Models\User::scopeLikeIn() has no return type specified.  
 🪪 missingType.return  
 134 Method App\Models\User::scopeLikeIn() has parameter $fields with no value type specified in iterable type array.  
 🪪 missingType.iterableValue  
 💡 See: https://phpstan.org/blog/solving-phpstan-no-value-type-specified-in-iterable-type  
 134 Method App\Models\User::scopeLikeIn() has parameter $query with no type specified.  
 🪪 missingType.parameter  
 134 Method App\Models\User::scopeLikeIn() has parameter $value with no type specified.  
 🪪 missingType.parameter

---

---

Line app\Proxy\QueryBuilders\ClinicQueryBuilderProxy.php

---

12 Method App\Proxy\QueryBuilders\ClinicQueryBuilderProxy::getClinicsForTable() has parameter $page with no type specified.  
 🪪 missingType.parameter  
 12 Method App\Proxy\QueryBuilders\ClinicQueryBuilderProxy::getClinicsForTable() has parameter $perPage with no type specified.  
 🪪 missingType.parameter  
 12 Method App\Proxy\QueryBuilders\ClinicQueryBuilderProxy::getClinicsForTable() return type with generic interface Illuminate\Contracts\Pagination\LengthAwarePaginator does not specify its types: TItem  
 🪪 missingType.generics

---

---

Line app\Proxy\QueryBuilders\ClinicServiceQueryBuilderProxy.php

---

12 Method App\Proxy\QueryBuilders\ClinicServiceQueryBuilderProxy::getClinicServicesForTable() has parameter $page with no type specified.  
 🪪 missingType.parameter  
 12 Method App\Proxy\QueryBuilders\ClinicServiceQueryBuilderProxy::getClinicServicesForTable() has parameter $perPage with no type specified.  
 🪪 missingType.parameter  
 12 Method App\Proxy\QueryBuilders\ClinicServiceQueryBuilderProxy::getClinicServicesForTable() return type with generic interface Illuminate\Contracts\Pagination\LengthAwarePaginator does not specify its types: TItem  
 🪪 missingType.generics

---

---

Line app\Proxy\QueryBuilders\DoctorQueryBuilderProxy.php

---

12 Method App\Proxy\QueryBuilders\DoctorQueryBuilderProxy::getDoctorsForTable() has parameter $page with no type specified.  
 🪪 missingType.parameter  
 12 Method App\Proxy\QueryBuilders\DoctorQueryBuilderProxy::getDoctorsForTable() has parameter $perPage with no type specified.  
 🪪 missingType.parameter  
 12 Method App\Proxy\QueryBuilders\DoctorQueryBuilderProxy::getDoctorsForTable() return type with generic interface Illuminate\Contracts\Pagination\LengthAwarePaginator does not specify its types: TItem  
 🪪 missingType.generics

---

---

Line app\Proxy\QueryBuilders\PatientQueryBuilderProxy.php

---

15 Method App\Proxy\QueryBuilders\PatientQueryBuilderProxy::searchPatients() has parameter $search with no type specified.  
 🪪 missingType.parameter  
 15 Method App\Proxy\QueryBuilders\PatientQueryBuilderProxy::searchPatients() return type with generic class Illuminate\Support\Collection does not specify its types: TKey, TValue  
 🪪 missingType.generics  
 25 Method App\Proxy\QueryBuilders\PatientQueryBuilderProxy::getPatientsForTable() has parameter $page with no type specified.  
 🪪 missingType.parameter  
 25 Method App\Proxy\QueryBuilders\PatientQueryBuilderProxy::getPatientsForTable() has parameter $perPage with no type specified.  
 🪪 missingType.parameter  
 25 Method App\Proxy\QueryBuilders\PatientQueryBuilderProxy::getPatientsForTable() has parameter $search with no type specified.  
 🪪 missingType.parameter  
 25 Method App\Proxy\QueryBuilders\PatientQueryBuilderProxy::getPatientsForTable() return type with generic interface Illuminate\Contracts\Pagination\LengthAwarePaginator does not specify its types: TItem  
 🪪 missingType.generics

---

---

Line app\QueryBuilders\Base\QueryBuilderWrapper.php

---

24 Method App\QueryBuilders\Base\QueryBuilderWrapper::**call() has no return type specified.  
 🪪 missingType.return  
 24 Method App\QueryBuilders\Base\QueryBuilderWrapper::**call() has parameter $method with no type specified.  
 🪪 missingType.parameter  
 24 Method App\QueryBuilders\Base\QueryBuilderWrapper::\_\_call() has parameter $parameters with no type specified.  
 🪪 missingType.parameter

---

---

Line app\QueryBuilders\PatientQueryBuilder.php

---

45 Method App\QueryBuilders\PatientQueryBuilder::searchPatients() has parameter $search with no type specified.  
 🪪 missingType.parameter

---

---

Line app\Responses\ActionResponse.php

---

9 Method App\Responses\ActionResponse::\_\_construct() has parameter $data with no type specified.  
 🪪 missingType.parameter  
 18 Method App\Responses\ActionResponse::getData() has no return type specified.  
 🪪 missingType.return

---

---

Line app\Rules\StartDateBeforeEndDate.php

---

9 Method App\Rules\StartDateBeforeEndDate::\_\_construct() has parameter $endDateAttribute with no type specified.  
 🪪 missingType.parameter

---

---

Line app\Services\Organization\OrganizationSetupService.php

---

16 Method App\Services\Organization\OrganizationSetupService::starterClinicServices() return type has no value type specified in iterable type array.  
 🪪 missingType.iterableValue  
 💡 See: https://phpstan.org/blog/solving-phpstan-no-value-type-specified-in-iterable-type  
 25 Method App\Services\Organization\OrganizationSetupService::makeClinicService() has parameter $clinic_id with no type specified.  
 🪪 missingType.parameter  
 25 Method App\Services\Organization\OrganizationSetupService::makeClinicService() has parameter $description with no type specified.  
 🪪 missingType.parameter  
 25 Method App\Services\Organization\OrganizationSetupService::makeClinicService() return type has no value type specified in iterable type array.  
 🪪 missingType.iterableValue  
 💡 See: https://phpstan.org/blog/solving-phpstan-no-value-type-specified-in-iterable-type

---

---

Line app\Services\PWA\ManifestService.php

---

7 Method App\Services\PWA\ManifestService::generate() has no return type specified.  
 🪪 missingType.return

---

---

Line app\Services\Register\StoreProfileImageService.php

---

9 Method App\Services\Register\StoreProfileImageService::handleFacebookImage() has parameter $imageURL with no type specified.  
 🪪 missingType.parameter

---

---

Line app\Services\User\GetProfilePhotoUrlService.php

---

9 Method App\Services\User\GetProfilePhotoUrlService::handle() has no return type specified.  
 🪪 missingType.return  
 9 Method App\Services\User\GetProfilePhotoUrlService::handle() has parameter $first_name with no type specified.  
 🪪 missingType.parameter  
 9 Method App\Services\User\GetProfilePhotoUrlService::handle() has parameter $profile_photo_path with no type specified.  
 🪪 missingType.parameter  
 9 Method App\Services\User\GetProfilePhotoUrlService::handle() has parameter $username with no type specified.  
 🪪 missingType.parameter  
 20 Method App\Services\User\GetProfilePhotoUrlService::defaultProfilePhotoUrl() has parameter $first_name with no type specified.  
 🪪 missingType.parameter  
 20 Method App\Services\User\GetProfilePhotoUrlService::defaultProfilePhotoUrl() has parameter $username with no type specified.  
 🪪 missingType.parameter

---

---

Line app\Traits\ActionTraits\ActionResponseTrait.php (in context of class App\Actions\ClinicService\CreateClinicServiceAction)

---

10 Method App\Actions\ClinicService\CreateClinicServiceAction::createResponse() has parameter $data with no type specified.  
 🪪 missingType.parameter  
 20 Method App\Actions\ClinicService\CreateClinicServiceAction::success() has no return type specified.  
 🪪 missingType.return  
 20 Method App\Actions\ClinicService\CreateClinicServiceAction::success() has parameter $data with no value type specified in iterable type array.  
 🪪 missingType.iterableValue  
 💡 See: https://phpstan.org/blog/solving-phpstan-no-value-type-specified-in-iterable-type  
 30 Method App\Actions\ClinicService\CreateClinicServiceAction::error() has no return type specified.  
 🪪 missingType.return  
 30 Method App\Actions\ClinicService\CreateClinicServiceAction::error() has parameter $data with no value type specified in iterable type array.  
 🪪 missingType.iterableValue  
 💡 See: https://phpstan.org/blog/solving-phpstan-no-value-type-specified-in-iterable-type  
 40 Method App\Actions\ClinicService\CreateClinicServiceAction::authorizeError() has no return type specified.  
 🪪 missingType.return  
 40 Method App\Actions\ClinicService\CreateClinicServiceAction::authorizeError() has parameter $data with no value type specified in iterable type array.  
 🪪 missingType.iterableValue  
 💡 See: https://phpstan.org/blog/solving-phpstan-no-value-type-specified-in-iterable-type

---

---

Line app\Traits\ActionTraits\ActionResponseTrait.php (in context of class App\Actions\ClinicService\DeleteClinicServiceAction)

---

10 Method App\Actions\ClinicService\DeleteClinicServiceAction::createResponse() has parameter $data with no type specified.  
 🪪 missingType.parameter  
 20 Method App\Actions\ClinicService\DeleteClinicServiceAction::success() has no return type specified.  
 🪪 missingType.return  
 20 Method App\Actions\ClinicService\DeleteClinicServiceAction::success() has parameter $data with no value type specified in iterable type array.  
 🪪 missingType.iterableValue  
 💡 See: https://phpstan.org/blog/solving-phpstan-no-value-type-specified-in-iterable-type  
 30 Method App\Actions\ClinicService\DeleteClinicServiceAction::error() has no return type specified.  
 🪪 missingType.return  
 30 Method App\Actions\ClinicService\DeleteClinicServiceAction::error() has parameter $data with no value type specified in iterable type array.  
 🪪 missingType.iterableValue  
 💡 See: https://phpstan.org/blog/solving-phpstan-no-value-type-specified-in-iterable-type  
 40 Method App\Actions\ClinicService\DeleteClinicServiceAction::authorizeError() has no return type specified.  
 🪪 missingType.return  
 40 Method App\Actions\ClinicService\DeleteClinicServiceAction::authorizeError() has parameter $data with no value type specified in iterable type array.  
 🪪 missingType.iterableValue  
 💡 See: https://phpstan.org/blog/solving-phpstan-no-value-type-specified-in-iterable-type

---

---

Line app\Traits\ActionTraits\ActionResponseTrait.php (in context of class App\Actions\ClinicService\UpdateClinicServiceAction)

---

10 Method App\Actions\ClinicService\UpdateClinicServiceAction::createResponse() has parameter $data with no type specified.  
 🪪 missingType.parameter  
 20 Method App\Actions\ClinicService\UpdateClinicServiceAction::success() has no return type specified.  
 🪪 missingType.return  
 20 Method App\Actions\ClinicService\UpdateClinicServiceAction::success() has parameter $data with no value type specified in iterable type array.  
 🪪 missingType.iterableValue  
 💡 See: https://phpstan.org/blog/solving-phpstan-no-value-type-specified-in-iterable-type  
 30 Method App\Actions\ClinicService\UpdateClinicServiceAction::error() has no return type specified.  
 🪪 missingType.return  
 30 Method App\Actions\ClinicService\UpdateClinicServiceAction::error() has parameter $data with no value type specified in iterable type array.  
 🪪 missingType.iterableValue  
 💡 See: https://phpstan.org/blog/solving-phpstan-no-value-type-specified-in-iterable-type  
 40 Method App\Actions\ClinicService\UpdateClinicServiceAction::authorizeError() has no return type specified.  
 🪪 missingType.return  
 40 Method App\Actions\ClinicService\UpdateClinicServiceAction::authorizeError() has parameter $data with no value type specified in iterable type array.  
 🪪 missingType.iterableValue  
 💡 See: https://phpstan.org/blog/solving-phpstan-no-value-type-specified-in-iterable-type

---

---

Line app\Traits\ActionTraits\ActionResponseTrait.php (in context of class App\Actions\Doctor\CreateDoctorAction)

---

10 Method App\Actions\Doctor\CreateDoctorAction::createResponse() has parameter $data with no type specified.  
 🪪 missingType.parameter  
 20 Method App\Actions\Doctor\CreateDoctorAction::success() has no return type specified.  
 🪪 missingType.return  
 20 Method App\Actions\Doctor\CreateDoctorAction::success() has parameter $data with no value type specified in iterable type array.  
 🪪 missingType.iterableValue  
 💡 See: https://phpstan.org/blog/solving-phpstan-no-value-type-specified-in-iterable-type  
 30 Method App\Actions\Doctor\CreateDoctorAction::error() has no return type specified.  
 🪪 missingType.return  
 30 Method App\Actions\Doctor\CreateDoctorAction::error() has parameter $data with no value type specified in iterable type array.  
 🪪 missingType.iterableValue  
 💡 See: https://phpstan.org/blog/solving-phpstan-no-value-type-specified-in-iterable-type  
 40 Method App\Actions\Doctor\CreateDoctorAction::authorizeError() has no return type specified.  
 🪪 missingType.return  
 40 Method App\Actions\Doctor\CreateDoctorAction::authorizeError() has parameter $data with no value type specified in iterable type array.  
 🪪 missingType.iterableValue  
 💡 See: https://phpstan.org/blog/solving-phpstan-no-value-type-specified-in-iterable-type

---

---

Line app\Traits\ActionTraits\ActionResponseTrait.php (in context of class App\Actions\Doctor\DeleteDoctorAction)

---

10 Method App\Actions\Doctor\DeleteDoctorAction::createResponse() has parameter $data with no type specified.  
 🪪 missingType.parameter  
 20 Method App\Actions\Doctor\DeleteDoctorAction::success() has no return type specified.  
 🪪 missingType.return  
 20 Method App\Actions\Doctor\DeleteDoctorAction::success() has parameter $data with no value type specified in iterable type array.  
 🪪 missingType.iterableValue  
 💡 See: https://phpstan.org/blog/solving-phpstan-no-value-type-specified-in-iterable-type  
 30 Method App\Actions\Doctor\DeleteDoctorAction::error() has no return type specified.  
 🪪 missingType.return  
 30 Method App\Actions\Doctor\DeleteDoctorAction::error() has parameter $data with no value type specified in iterable type array.  
 🪪 missingType.iterableValue  
 💡 See: https://phpstan.org/blog/solving-phpstan-no-value-type-specified-in-iterable-type  
 40 Method App\Actions\Doctor\DeleteDoctorAction::authorizeError() has no return type specified.  
 🪪 missingType.return  
 40 Method App\Actions\Doctor\DeleteDoctorAction::authorizeError() has parameter $data with no value type specified in iterable type array.  
 🪪 missingType.iterableValue  
 💡 See: https://phpstan.org/blog/solving-phpstan-no-value-type-specified-in-iterable-type

---

---

Line app\Traits\ActionTraits\ActionResponseTrait.php (in context of class App\Actions\Doctor\UpdateDoctorAction)

---

10 Method App\Actions\Doctor\UpdateDoctorAction::createResponse() has parameter $data with no type specified.  
 🪪 missingType.parameter  
 20 Method App\Actions\Doctor\UpdateDoctorAction::success() has no return type specified.  
 🪪 missingType.return  
 20 Method App\Actions\Doctor\UpdateDoctorAction::success() has parameter $data with no value type specified in iterable type array.  
 🪪 missingType.iterableValue  
 💡 See: https://phpstan.org/blog/solving-phpstan-no-value-type-specified-in-iterable-type  
 30 Method App\Actions\Doctor\UpdateDoctorAction::error() has no return type specified.  
 🪪 missingType.return  
 30 Method App\Actions\Doctor\UpdateDoctorAction::error() has parameter $data with no value type specified in iterable type array.  
 🪪 missingType.iterableValue  
 💡 See: https://phpstan.org/blog/solving-phpstan-no-value-type-specified-in-iterable-type  
 40 Method App\Actions\Doctor\UpdateDoctorAction::authorizeError() has no return type specified.  
 🪪 missingType.return  
 40 Method App\Actions\Doctor\UpdateDoctorAction::authorizeError() has parameter $data with no value type specified in iterable type array.  
 🪪 missingType.iterableValue  
 💡 See: https://phpstan.org/blog/solving-phpstan-no-value-type-specified-in-iterable-type

---

---

Line app\Traits\ActionTraits\ActionResponseTrait.php (in context of class App\Actions\Patient\CreatePatientAction)

---

10 Method App\Actions\Patient\CreatePatientAction::createResponse() has parameter $data with no type specified.  
 🪪 missingType.parameter  
 20 Method App\Actions\Patient\CreatePatientAction::success() has no return type specified.  
 🪪 missingType.return  
 20 Method App\Actions\Patient\CreatePatientAction::success() has parameter $data with no value type specified in iterable type array.  
 🪪 missingType.iterableValue  
 💡 See: https://phpstan.org/blog/solving-phpstan-no-value-type-specified-in-iterable-type  
 30 Method App\Actions\Patient\CreatePatientAction::error() has no return type specified.  
 🪪 missingType.return  
 30 Method App\Actions\Patient\CreatePatientAction::error() has parameter $data with no value type specified in iterable type array.  
 🪪 missingType.iterableValue  
 💡 See: https://phpstan.org/blog/solving-phpstan-no-value-type-specified-in-iterable-type  
 40 Method App\Actions\Patient\CreatePatientAction::authorizeError() has no return type specified.  
 🪪 missingType.return  
 40 Method App\Actions\Patient\CreatePatientAction::authorizeError() has parameter $data with no value type specified in iterable type array.  
 🪪 missingType.iterableValue  
 💡 See: https://phpstan.org/blog/solving-phpstan-no-value-type-specified-in-iterable-type

---

---

Line app\Traits\LivewireTraits\WithSteps.php (in context of class App\Livewire\App\Clinic\Includes\CreateClinicModal)

---

7 Property App\Livewire\App\Clinic\Includes\CreateClinicModal::$step has no type specified.                         
         🪪  missingType.property                                                                                          
  9      Property App\Livewire\App\Clinic\Includes\CreateClinicModal::$maxSteps has no type specified.  
 🪪 missingType.property

---

---

Line app\Traits\LivewireTraits\WithSteps.php (in context of class App\Livewire\App\Doctor\Includes\CreateDoctorModal)

---

7 Property App\Livewire\App\Doctor\Includes\CreateDoctorModal::$step has no type specified.                         
         🪪  missingType.property                                                                                          
  9      Property App\Livewire\App\Doctor\Includes\CreateDoctorModal::$maxSteps has no type specified.  
 🪪 missingType.property

---

---

Line app\Traits\LivewireTraits\WithSteps.php (in context of class App\Livewire\Auth\Register\Register)

---

7 Property App\Livewire\Auth\Register\Register::$step has no type specified.                         
         🪪  missingType.property                                                                           
  9      Property App\Livewire\Auth\Register\Register::$maxSteps has no type specified.  
 🪪 missingType.property

---

---

Line app\Traits\LivewireTraits\withProfilePhotoTrait.php (in context of class App\Livewire\App\Calendar\Includes\AddEventModal)

---

10 Method App\Livewire\App\Calendar\Includes\AddEventModal::getUserProfilePhotoUrl() has no return type specified.  
 🪪 missingType.return  
 10 Method App\Livewire\App\Calendar\Includes\AddEventModal::getUserProfilePhotoUrl() has parameter $first_name with no type specified.  
 🪪 missingType.parameter  
 10 Method App\Livewire\App\Calendar\Includes\AddEventModal::getUserProfilePhotoUrl() has parameter $profile_photo_path with no type specified.  
 🪪 missingType.parameter  
 10 Method App\Livewire\App\Calendar\Includes\AddEventModal::getUserProfilePhotoUrl() has parameter $username with no type specified.  
 🪪 missingType.parameter

---

---

Line app\Traits\LivewireTraits\withProfilePhotoTrait.php (in context of class App\Livewire\App\Doctor\DoctorTable)

---

10 Method App\Livewire\App\Doctor\DoctorTable::getUserProfilePhotoUrl() has no return type specified.  
 🪪 missingType.return  
 10 Method App\Livewire\App\Doctor\DoctorTable::getUserProfilePhotoUrl() has parameter $first_name with no type specified.  
 🪪 missingType.parameter  
 10 Method App\Livewire\App\Doctor\DoctorTable::getUserProfilePhotoUrl() has parameter $profile_photo_path with no type specified.  
 🪪 missingType.parameter  
 10 Method App\Livewire\App\Doctor\DoctorTable::getUserProfilePhotoUrl() has parameter $username with no type specified.  
 🪪 missingType.parameter

---

---

Line app\Traits\LivewireTraits\withProfilePhotoTrait.php (in context of class App\Livewire\App\Reception\ReceptionGlobalSearchModal)

---

10 Method App\Livewire\App\Reception\ReceptionGlobalSearchModal::getUserProfilePhotoUrl() has no return type specified.  
 🪪 missingType.return  
 10 Method App\Livewire\App\Reception\ReceptionGlobalSearchModal::getUserProfilePhotoUrl() has parameter $first_name with no type specified.  
 🪪 missingType.parameter  
 10 Method App\Livewire\App\Reception\ReceptionGlobalSearchModal::getUserProfilePhotoUrl() has parameter $profile_photo_path with no type specified.  
 🪪 missingType.parameter  
 10 Method App\Livewire\App\Reception\ReceptionGlobalSearchModal::getUserProfilePhotoUrl() has parameter $username with no type specified.  
 🪪 missingType.parameter

---

---

Line app\Traits\Socialite\SocialiteResponseTrait.php (in context of class App\Http\Controllers\Auth\Socialite\FacebookSocialiteController)

---

7 Method App\Http\Controllers\Auth\Socialite\FacebookSocialiteController::socialiteLoginSuccess() has no return type specified.  
 🪪 missingType.return

---

---

Line app\Traits\User\HasCustomDefaultProfilePhoto.php (in context of class App\Models\User)

---

10 Method App\Models\User::profilePhotoUrl() return type with generic class Illuminate\Database\Eloquent\Casts\Attribute does not specify its types: TGet, TSet  
 🪪 missingType.generics

---

---

Line app\Transformers\Base\Transformer.php

---

7 Method App\Transformers\Base\Transformer::\_\_construct() has parameter $item with no type specified.  
 🪪 missingType.parameter  
 11 Method App\Transformers\Base\Transformer::transform() has parameter $item with no type specified.  
 🪪 missingType.parameter  
 16 Method App\Transformers\Base\Transformer::transformCollection() has parameter $items with no type specified.  
 🪪 missingType.parameter  
 16 Method App\Transformers\Base\Transformer::transformCollection() has parameter $methods with no value type specified in iterable type array.  
 🪪 missingType.iterableValue  
 💡 See: https://phpstan.org/blog/solving-phpstan-no-value-type-specified-in-iterable-type

---

[ERROR] Found 440 errors
