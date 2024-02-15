<?php

namespace App\Repositories;

use App\Models\Medical;
use InfyOm\Generator\Common\BaseRepository;

/**
 * Class MedicalRepository
 * @package App\Repositories
 * @version December 1, 2017, 11:22 pm UTC
 *
 * @method Medical findWithoutFail($id, $columns = ['*'])
 * @method Medical find($id, $columns = ['*'])
 * @method Medical first($columns = ['*'])
*/
class MedicalRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'advice',
        'symptoms',
        'first_aid'
    ];

    /**
     * Configure the Model
     **/
    public function model()
    {
        return Medical::class;
    }

    public function search($student_id) {
        return Medical::where('student_id', $student_id)->get();
    }
}
