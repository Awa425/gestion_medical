<?php
namespace App\Services;

use App\Models\SalleAttente;

class SalleAttenteService{
    public function addPatientToWaitingRoom(array $data)
    {
        return SalleAttente::create($data);
    }
}