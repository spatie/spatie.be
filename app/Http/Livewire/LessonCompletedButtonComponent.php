<?php

namespace App\Http\Livewire;

use App\Models\Lesson;
use Livewire\Component;

class LessonCompletedButtonComponent extends Component
{
    /** @var \App\Models\Lesson|null */
    public $lesson;

    public function mount(Lesson $lesson): void
    {
        $this->lesson = $lesson;
    }

    public function toggleCompleted(): void
    {
        $this->lesson->hasBeenCompletedByCurrentUser()
            ? $this->lesson->markAsUncompletedForCurrentUser()
            : $this->lesson->markAsCompletedForCurrentUser();
    }

    public function render()
    {
        return view('front.pages.courses.livewire.lessonCompletedButton', [
            'lesson' => $this->lesson,
        ]);
    }
}
