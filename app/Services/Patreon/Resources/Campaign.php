<?php

namespace App\Services\Patreon\Resources;

class Campaign
{
    /** @var int */
    public $id;

    /** @var string */
    public $name;

    /** @var int */
    public $pledgedSum;

    /** @var \App\Services\Patreon\Resources\ResourceCollection  */
    public $rewards;

    public function __construct(int $id, string $name, int $pledgedSum)
    {
        $this->id = $id;
        $this->name = $name;
        $this->pledgedSum = $pledgedSum;

        $this->rewards = new ResourceCollection();
    }

    public function fillRewards(array $rewardRelationsData, ResourceCollection $rewards)
    {
        foreach ($rewardRelationsData['data'] as $rewardRelation) {
            $this->rewards->add($rewards->get($rewardRelation['id']));
        }
    }

    public static function import(array $data)
    {
        return new self(
            $data['id'],
            $data['attributes']['creation_name'],
            $data['attributes']['pledge_sum']
        );
    }
}
