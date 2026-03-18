<?php

namespace App\View\Components;

use DateInterval;
use DateTimeInterface;
use Illuminate\View\Component;

class Countdown extends Component
{
    public function __construct(
        public DateTimeInterface $expires,
    ) {}

    public function render()
    {
        return view('components.countdown');
    }

    public function days(): string
    {
        return sprintf('%02d', $this->difference()->d);
    }

    public function hours(): string
    {
        return sprintf('%02d', $this->difference()->h);
    }

    public function minutes(): string
    {
        return sprintf('%02d', $this->difference()->i);
    }

    public function seconds(): string
    {
        return sprintf('%02d', $this->difference()->s);
    }

    public function difference(): DateInterval
    {
        return $this->expires->diff(now($this->expires->getTimezone()));
    }
}
