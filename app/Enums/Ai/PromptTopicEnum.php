<?php

declare(strict_types=1);

namespace App\Enums\Ai;

use App\Models\Embedding;
use App\Services\External\Ai\Embedding\GenerateEmbeddingService;
use App\Services\External\Ai\Embedding\PreprocessEmbeddedTextService;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Pgvector\Laravel\Distance;
use Pgvector\Laravel\Vector;

enum PromptTopicEnum: int
{
    case PATIENT = 1;
    case APPOINTMENT = 2;
    case INVOICE = 3;

    public static function getTopicOptions(): array
    {
        return [
            self::PATIENT->value => 'المرضى',
            self::APPOINTMENT->value => 'المواعيد والحجوزات',
            self::INVOICE->value => 'الفواتير',
        ];
    }

    public static function getSemanticTopic(string $message): string
    {
        $messagePreProcessor = new PreprocessEmbeddedTextService($message);
        $translatedCleanedMessage = (string) $messagePreProcessor->clean()->translate();

        $messageVector = (new GenerateEmbeddingService())->handle($translatedCleanedMessage);

        $results = Embedding::nearestNeighbors('embedding', new Vector($messageVector))
            ->where('organization_id', Auth::user()->organization_id)
            // ->orderByRaw('sparse_vector <#> ?', [new SparseVector($messageVector, 30522)]) // Fixed
            ->limit(120)
            ->pluck('content', 'id')
            ->toArray();

        $searchString = '%' . implode('%', array_map('trim', explode(' ', $message))) . '%';

        $resultsSearch = Embedding::where('content', 'LIKE', $searchString)
            ->limit(10)
            ->pluck('content', 'id')
            ->toArray();

        $i = 1;

        return implode(', ', array_map(function (string $item) use (&$i): string {
            return ($i++) . '. ' . $item;
        }, array_unique([...$results, ...$resultsSearch])));
    }

    public function label(): string
    {
        return match ($this) {
            self::PATIENT => 'المرضى',
            self::APPOINTMENT => 'المواعيد والحجوزات',
            self::INVOICE => 'الفواتير',
        };
    }

    public function prompt(): string
    {
        return match ($this) {
            self::PATIENT => $this->getPatientPrompt(),
            self::APPOINTMENT => 'المواعيد والحجوزات',
            self::INVOICE => 'الفواتير',
        };
    }

    public function getAppointmentPrompt(): string
    {
        return '';
    }

    private function getPatientPrompt(): string
    {
        if (Auth::check() && Auth::user()->isClinicAdmin()) {
            $rememberMinutes = now()->addMinutes(10);

            $cacheKey = Cache::generateOrgScopedKey('patient_prompt_query', self::class);
            $dbDriver = config('database.default');

            $query = (fn () => DB::table('patients as p')
                ->where('p.organization_id', Auth::user()->organization_id)
                ->join('users as u', 'u.id', '=', 'p.user_id')
                ->join('events as e', 'e.patient_id', '=', 'p.id')
                ->join('doctors as d', 'd.id', '=', 'e.doctor_id')
                ->join('users as du', 'du.id', '=', 'd.user_id')
                ->select([
                    'p.id as pid',
                    DB::raw("CONCAT(u.first_name, '. ', u.last_name) as patient"),
                    'u.phone',
                    'p.age',
                    'p.gender',
                    'p.puid',
                    'e.id as eid',
                    DB::raw(('pgsql' === $dbDriver ? "TO_CHAR(e.start_at, 'YYYY-MM-DD HH24:MI')" : "DATE_FORMAT(e.start_at, '%Y-%m-%d %H:%i')") . ' as start'),
                    DB::raw(('pgsql' === $dbDriver ? "TO_CHAR(e.end_at, 'YYYY-MM-DD HH24:MI')" : "DATE_FORMAT(e.end_at, '%Y-%m-%d %H:%i')") . ' as end'),
                    DB::raw("CONCAT(du.first_name, '. ', du.last_name) as doctor"),
                ])
                ->get()
                ->map(fn ($p): array => [
                    'id' => $p->pid,
                    'patient' => $p->patient,
                    'phone' => $p->phone,
                    'age' => $p->age,
                    'gender' => $p->gender,
                    'event' => [
                        'id' => $p->eid,
                        'start' => $p->start,
                        'end' => $p->end,
                        'doctor' => $p->doctor,
                    ],
                ])
                ->toJson());

            return Cache::remember(
                key: $cacheKey,
                ttl: $rememberMinutes,
                callback: $query,
            );
        }

        return '';
    }
}
