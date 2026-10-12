<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Override;

class MedicalCase extends Model
{
    protected $fillable = [
        'case_number',
        'patient_reference',
        'surgeon_name',
        'implant_type',
        'status',
        'priority',
        'surgery_date',
        'created_by'
    ];

    #[Override]
    protected function casts(): array 
    {
        return [
            'surgery_date' => 'date',
        ];
    }

    public function creator()
    {
        return $this->belongsTo(\App\Models\User::class, 'created_by');
    }
}
