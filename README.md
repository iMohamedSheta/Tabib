# Project Overview

This project is a comprehensive SaaS platform designed for managing medical clinics. It provides a range of features including user authentication, clinic management, doctor and patient management, appointment scheduling, and integrated AI-powered services.

## Key Features

-   **User Management:** Supports various user roles including clinic admins, doctors, patients, and managers. Uses Laravel Fortify for authentication and password management.
-   **Clinic Management:** Allows creation and management of clinics, including their details, services, and related staff.
-   **Doctor and Patient Management:** Enables the creation and management of doctor and patient profiles, along with their associated information.
-   **Appointment Scheduling:** Provides a calendar system for scheduling appointments and managing events. Includes features for handling event creation and modification.
-   **AI-Powered Services:** Integrates with AI models for various tasks including text generation and documentation creation.
-   **Data Management:** Utilizes DTOs (Data Transfer Objects) for data transfer and includes multiple query builders for efficient data retrieval.
-   **File Management:** Supports uploading, managing, and displaying media files, including profile pictures and documents.
-   **Payments:** Includes an invoice system for billing and payment tracking.
-   **Progressive Web App (PWA) Support:** The application is designed to function as a PWA, with features such as `manifest.json` and offline support.

## Major Components

### Enums

-   `ActionResponseStatusEnum`: Defines the status of action responses (`SUCCESS`, `ERROR`, `AUTHORIZE_ERROR`).
-   `AiModelEnum`: Defines the available AI models.
-   `CalendarTypeEnum`: Defines the types of calendar events.
-   `ClinicLevelEnum`: Defines the levels of clinics.
-   `ClinicTypeEnum`: Defines the types of clinics.
-   `DaysEnum`: Defines the days of the week.
-   `HelperEnum`: Defines helper strings for common use cases.
-   `InvoiceStatusEnum`: Defines the statuses of invoices.
-   `InvoiceTypeEnum`: Defines the types of invoices.
-   `MediaCollectionEnum`: Defines the collections for media files.
-   `MediaTypeEnum`: Defines the types of media.
-   `MessageTypeEnum`: Defines the types of messages.
-   `OAuthProviderEnum`: Defines the OAuth providers.
-   `UserInfoEnum`: Defines the gender options.
-   `UserRoleEnum`: Defines the user roles within the application.

### Traits

-   `ActionResponseTrait`: Provides methods for creating standard action responses.
-   `GenerateUniqueCodeTrait`: Provides methods to generate unique codes.
-   `ActionResponseHandlerTrait`: Provides an abstract method for handling action responses.
-   `WithSteps`: Manages steps in multi-step forms.
-   `withProfilePhotoTrait`: Provides a computed property to generate user profile photo URLs.
-   `HasMediaUrls`: Generates URLs for media items.
-   `HasCustomDefaultProfilePhoto`: Generates default profile photo URLs.
-   `WithCustomPagination`: Provides pagination functionality for collections.
-   `SocialiteResponseTrait`: Provides a response for successful socialite logins.
-   `PasswordValidationRules`: Defines the password validation rules.

### Actions

-   `RegisterAction`: Handles the user registration process.
-   `CreateClinicAction`: Creates a new clinic and its associated resources.
-   `CreateClinicServiceAction`: Handles the creation of clinic services.
-   `DeleteClinicServiceAction`: Handles the deletion of clinic services.
-   `UpdateClinicServiceAction`: Handles the update of clinic services.
-   `CreateDoctorAction`: Handles the creation of doctors.
-   `DeleteDoctorAction`: Handles the deletion of doctors.
-   `UpdateDoctorAction`: Handles the updating of doctor information.
-   `CreateNewUser`: Creates new users.
-   `ResetUserPassword`: Resets user passwords.
-   `UpdateUserPassword`: Updates user passwords.
-   `UpdateUserProfileInformation`: Updates user profile information.
-   `DeleteUser`: Deletes users.
-   `CreatePatientAction`: Handles the creation of patients.
-   `DeletePatientAction`: Handles the deletion of patients.
-   `DeleteUserAttachedFileAction`: Handles the deletion of user attached files.

### Services

-   `HuggingFaceService`: Provides an interface to the Hugging Face API for AI-related tasks.
-   `MediaUrlGeneratorService`: Generates temporary URLs for media items.
-   `OrganizationSetupService`: Sets up default data for new organizations.
-   `ManifestService`: Generates the manifest for the PWA.
-   `StoreProfileImageService`: Handles storing profile images.
-   `GetProfilePhotoUrlService`: Generates the URLs for user profile photos.

### Data Transfer Objects (DTOs)

-   `RegisterUserDTO`: Encapsulates data for registering a new user.
-   `CreateClinicServiceDTO`: Encapsulates data for creating a clinic service.
-   `UpdateClinicServiceDTO`: Encapsulates data for updating a clinic service.
-   `CreateDoctorDTO`: Encapsulates data for creating a doctor.
-   `UpdateDoctorDTO`: Encapsulates data for updating a doctor.
-   `CreatePatientDTO`: Encapsulates data for creating a patient.

### Livewire Components

-   `Prompt`: Handles AI prompts and conversation.
-   `Calendar`: Displays a calendar with events.
-   `AddEventModal`: Provides a modal for adding new events.
-   `UpdateEventModal`: Provides a modal for updating existing events.
-   `ClinicServiceTable`: Displays a table of clinic services.
-   `CreateClinicServiceModal`: Provides a modal for creating clinic services.
-   `InfoClinicServiceModal`: Displays information for a clinic service.
-   `UpdateClinicServiceModal`: Provides a modal for updating clinic services.
-   `ClinicTable`: Displays a table of clinics.
-   `CreateClinicModal`: Provides a modal for creating new clinics.
-   `DoctorTable`: Displays a table of doctors.
-   `CreateDoctorModal`: Provides a modal for creating doctors.
-   `InfoDoctorModal`: Displays information about a doctor.
-   `UpdateDoctorModal`: Provides a modal for updating doctor details.
-   `CreatePatientModal`: Provides a modal for creating patients.
-   `UploadAttachedFileModal`: Provides a modal for uploading files.
-   `PatientTable`: Displays a table of patients.
-   `ShowPatient`: Displays details for a patient, their appointments and files.
-   `QueueTable`: Displays a table of patients in the queue.
-   `ReceptionGlobalSearchModal`: Provides a search functionality for reception users.
-   `Register`: Handles the multi-step registration of new clinics.
-   `OAuthCallback`: Handles OAuth callbacks for clinic registration.

### Controllers

-   `FacebookSocialiteController`: Handles authentication using Facebook.
-   `GoogleSocialiteController`: Handles authentication using Google.
-   `LaravelPWAController`: Manages PWA functionality.
-   `PrivateStorageController`: Manages access to private files.

### Models

-   `Calendar`: Represents calendar entries.
-   `Clinic`: Represents a clinic.
-   `ClinicAdmin`: Represents a clinic administrator.
-   `ClinicService`: Represents a clinic service.
-   `Doctor`: Represents a doctor.
-   `Event`: Represents a calendar event.
-   `Invoice`: Represents an invoice.
-   `Manager`: Represents a manager.
-   `Media`: Represents media files.
-   `Message`: Represents a message.
-   `Organization`: Represents an organization.
-   `Patient`: Represents a patient.
-   `Plan`: Represents a subscription plan.
-   `Prompt`: Represents a prompt within the application.
-   `Receptionist`: Represents a receptionist
-   `User`: Represents a user.

### Query Builders

-   `ClinicQueryBuilder`: Provides specific queries for the `clinics` table.
-   `ClinicServiceQueryBuilder`: Provides specific queries for the `clinic_services` table.
-   `DoctorQueryBuilder`: Provides specific queries for the `doctors` table.
-   `PatientQueryBuilder`: Provides specific queries for the `patients` table.

### Proxies

-   `ClinicQueryBuilderProxy`: Acts as a proxy for the `ClinicQueryBuilder`.
-   `ClinicServiceQueryBuilderProxy`: Acts as a proxy for the `ClinicServiceQueryBuilder`.
-   `DoctorQueryBuilderProxy`: Acts as a proxy for the `DoctorQueryBuilder`.
-   `PatientQueryBuilderProxy`: Acts as a proxy for the `PatientQueryBuilder`.

### Other

-   `AgeFormatter`: Provides methods for formatting age.
-   `CalendarDatepickerAdapter`: Handles and converts datepicker values.
-   `DataSizeFormatter`: Formats byte sizes into readable format.
-   `DateFormatter`: Provides methods for formatting dates.
-   `MoneyFormatter`: Formats money amounts.
-   `OrganizationBillingCodeGenerator`: Generates billing codes for organizations.
-   `PUIDGenerator`: Generates unique patient IDs.
-   `FilenameGenerator`: Generates unique file names.
-   `Helper`: Provides a helper method for logging.

## Directory Structure

```
├── app
│ ├── Actions
│ ├── Console
│ ├── DTOs
│ ├── Enums
│ ├── Exceptions
│ ├── Http
│ │ ├── Controllers
│ │ └── Requests
│ ├── Livewire
│ │ ├── App
│ │ │ ├── Clinic
│ │ │ │ ├── includes
│ │ │ │ └── *
│ │ │ ├── Doctor
│ │ │ │ └── includes
│ │ │ ├── Patient
│ │ │ │ └── includes
│ │ │ └── *
│ │ └── *
│ ├── Mail
│ ├── Models
│ ├── Proxy
│ │ └── QueryBuilders
│ ├── QueryBuilders
│ ├── Providers
│ ├── Scopes
│ ├── Services
│ ├── Traits
│ └── Transformers
├── analyze
│ └── cloc
├── config
├── database
│ ├── factories
│ ├── migrations
│ └── seeders
├── lang
├── public
├── resources
│ ├── css
│ ├── js
│ └── views
├── routes
├── storage
├── tests
└── vendor
```
