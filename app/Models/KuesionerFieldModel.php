<?php

namespace App\Models;

use CodeIgniter\Model;

class KuesionerFieldModel extends Model
{
    protected $table = 'kuesioner_fields';
    protected $primaryKey = 'id';

    protected $allowedFields = [
        'field_name',
        'label',
        'header',
        'type',
        'options',
        'required',
        'step',
        'order',
        'source_table',
        'created_at',
        'updated_at',
    ];

    protected $useTimestamps = true;
}
