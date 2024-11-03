<?php

namespace App\Domain\Models;

use App\Domain\ValueObjects\Date;
use App\Domain\ValueObjects\Agency;
use App\Domain\ValueObjects\FullName;
use Illuminate\Database\Eloquent\Model;

class Spy extends Model
{
    protected $fillable = ['name','surname','agency','country_of_operation','date_of_birth','date_of_death'];

    protected $table = 'spies';

    public function getFullName(): FullName
    {
        return $this->fullName;
    }

    public function getAgency(): Agency
    {
        return $this->agency;
    }

    public function getDateOfBirth(): Date
    {
        return $this->dateOfBirth;
    }

    public function getDateOfDeath(): ?Date
    {
        return $this->dateOfDeath;
    }

}
