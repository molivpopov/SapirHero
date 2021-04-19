<?php

namespace App\Casts;

use App\Models\Skill;
use Illuminate\Contracts\Database\Eloquent\CastsAttributes;

class UsedSkills implements CastsAttributes
{
    /**
     * Cast the given value.
     *
     * @param \Illuminate\Database\Eloquent\Model $model
     * @param string $key
     * @param mixed $value
     * @param array $attributes
     * @return mixed
     */
    public function get($model, $key, $value, $attributes)
    {
        return Skill::find(explode(',', $value));
    }

    /**
     * Prepare the given value for storage.
     *
     * @param \Illuminate\Database\Eloquent\Model $model
     * @param string $key
     * @param array $value
     * @param array $attributes
     * @return mixed
     */
    public function set($model, $key, $value, $attributes)
    {
        $usedSkills = $value->filter(function ($skill) {
            return $skill->chance;
        })->map(function ($skill) {
            return $skill->id;
        })->toArray();

        return implode(',', $usedSkills);
    }
}
