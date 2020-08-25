<?php

namespace App\Http\Livewire;

use App\Models\Video;
use Livewire\Component;

class VideoCompletedButtonComponent extends Component
{
    /** @var \App\Models\Video|null */
    public $video;

    public function mount(Video $video)
    {
        $this->video = $video;
    }

    public function toggleCompleted()
    {
        $this->video->hasBeenCompletedByCurrentUser()
            ? $this->video->markAsUncompletedForCurrentUser()
            : $this->video->markAsCompletedForCurrentUser();
    }

    public function render()
    {
        return view('front.pages.videos.livewire.videoCompletedButton', [
            'video' => $this->video,
        ]);
    }
}
