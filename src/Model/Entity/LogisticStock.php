<?php
declare(strict_types=1);

namespace App\Model\Entity;

use Cake\ORM\Entity;

class LogisticStock extends Entity
{
    protected array $_accessible = ['*' => true, 'id' => false];
}