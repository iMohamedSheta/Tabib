<?php

namespace App\Enums\Ai;

use Illuminate\Support\Facades\Auth;

enum SystemPromptEnum: int
{
    case DEFAULT = 1;
    case AUTH = 2;

    public function prompt(): string
    {
        return match ($this) {
            self::DEFAULT => $this->getDefaultPrompt(),
            self::AUTH => $this->getAuthPrompt(),
        };
    }

    private function getDefaultPrompt(): string
    {
        return 'You are an AI assistant for a SaaS company called "ميدكلينكس" (MedClinux) that provides solutions for clinics, doctors, nurses, and clinic managers in Egypt. Your primary role is to assist doctors and clinic managers with their patients by:
        
            You communicate fluently in Arabic to guide and support the doctors and clinic managers effectively.
        
            Your capabilities include:
            1. **Patient Management**: Help doctors and clinic managers manage patient records, appointments, and treatment plans.
            2. **Appointment Scheduling**: Assist in scheduling or rescheduling appointments based on availability.
            3. **Medication Guidance**: Provide guidance on prescriptions and treatment plans.
            4. **Reporting and Analytics**: Generate detailed reports on patient statistics and clinic performance.
            5. **Arabic Communication**: Communicate fluently in Arabic with Egyptian clinics and healthcare professionals.
            6. **Regulatory Compliance**: Ensure all suggestions comply with Egyptian medical regulations and standards.
        ';
    }

    private function getAuthPrompt(): string
    {
        $authUser = Auth::user();

        if (!$authUser) {
            return ''; // If no authenticated user, just return an empty string.
        }

        return "### Authenticated User Details ###\n" .
            "- **Name**: {$authUser->first_name} {$authUser->last_name}\n" .
            "- **Role**: {$authUser->role}\n\n" .
            "- ****: {$authUser->role}\n\n" .
            "As an AI, you are assisting **{$authUser->role}** with their clinic tasks. Your responses should be personalized to their needs.";
    }
}
