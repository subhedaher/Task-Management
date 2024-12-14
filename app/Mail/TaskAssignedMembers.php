<?php

namespace App\Mail;

use App\Models\Setting;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Storage;

class TaskAssignedMembers extends Mailable
{
    use Queueable, SerializesModels;

    public $member, $task;

    /**
     * Create a new message instance.
     */
    public function __construct($member, $task)
    {
        $this->member = $member;
        $this->task = $task;
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'New Task Assigned',
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        $settings = Setting::first();
        return new Content(
            markdown: 'dashboard.emails.task-assigned-members',
            with: [
                'memberName' => $this->member->name,
                'projectName' => $this->task->project->name,
                'taskDescription' => $this->task->description,
                'taskPirority' => $this->task->priority,
                'taskName' => $this->task->name,
                'startDate' => $this->task->start_date,
                'endDate' => $this->task->end_date,
                'adminName' => $this->task->project->admin->name,
                'position' => $this->task->project->admin->roles[0]->name,
                'imageUrl' => Storage::url($settings->logo)
            ]
        );
    }

    /**
     * Get the attachments for the message.
     *
     * @return array<int, \Illuminate\Mail\Mailables\Attachment>
     */
    public function attachments(): array
    {
        return [];
    }
}
