<?php

namespace App\Imports;

use App\Models\User;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Hash;
use Maatwebsite\Excel\Concerns\ToModel;

class CandidateImport implements ToModel
{
    protected $examId;
    protected $newUsersCount = 0;  // Counter for newly created users
    protected $existingUsersCount = 0; // Counter for existing users

    public function __construct($examId = null)
    {
        $this->examId = $examId;
    }


    /**
     * @param array $row
     *
     * @return \Illuminate\Database\Eloquent\Model|null
     */
    public function model(array $row)
    {
        //Log::info($row);
        if ($row[0] != 'name') {

            $user = User::firstOrCreate(
                ['email' => $row[1]], // Attributes to check
                [
                    'name' => $row[0],
                    'password' => Hash::make($row[2])
                ] // Attributes to set if creating a new record
            );

            if ($user->wasRecentlyCreated) {
                $this->newUsersCount++; // Increment new users counter
            } else {
                $this->existingUsersCount++; // Increment existing users counter
            }

            if ($this->examId) {
                $user->exams()->syncWithoutDetaching([$this->examId]);
            }
            
        }

    }

    public function getCounts()
    {
        return [
            'newUsersCount' => $this->newUsersCount,
            'existingUsersCount' => $this->existingUsersCount
        ];
    }
}
