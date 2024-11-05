<?php

namespace App\Domain\Models;

use App\Domain\Events\SpyCreated;
use App\Domain\ValueObjects\Date;
use App\Domain\ValueObjects\FullName;
use Illuminate\Database\Eloquent\Model;

class Spy extends Model
{
    protected $fillable = ['name','surname','agency','country_of_operation','date_of_birth','date_of_death'];

    protected $table = 'spies';

    public static function boot()
    {
        parent::boot();

        // Dispatch SpyCreated event after successful creation
        static::created(fn (Spy $spy) => event(new SpyCreated($spy)));
    }

    public function getFullNameAttribute(): FullName
    {
        return new FullName($this->attributes['name'], $this->attributes['surname']);
    }

    public function getDateOfBirthAttribute(): Date
    {
        return new Date($this->attributes['date_of_birth']);
    }

    public function getDateOfDeathAttribute(): ?Date
    {
        return $this->attributes['date_of_death'] ? new Date($this->attributes['date_of_death']) : null;
    }

}
