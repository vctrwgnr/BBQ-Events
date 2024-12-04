<?php

namespace App\Repository;

use App\Model\Event;

class EventRepository{

    public function findAll(): array {


        $party1 = new Event(1, 'Techno', 'Super cool', 'Berlin', 50);
        $party2 = new Event(2, 'Rock', 'Laut', 'Hamburg', 190);
        $party3 = new Event(3, 'Hip Hop', 'Energetic', 'Munich', 200);

        return [$party1, $party2, $party3];

    }

    public function findOne(int $id): ?Event {
        $parties = $this->findAll();
        foreach ($parties as $party) {
            if ($party->getId() == $id) {
                return $party;
            }
        }
        return null;
    }



}
