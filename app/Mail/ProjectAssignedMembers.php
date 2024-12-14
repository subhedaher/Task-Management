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

class ProjectAssignedMembers extends Mailable
{
    use Queueable, SerializesModels;

    public $member, $project, $admin;

    /**
     * Create a new message instance.
     */
    public function __construct($member, $project, $admin)
    {
        $this->member = $member;
        $this->project = $project;
        $this->admin = $admin;
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'New Project Invitation',
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        $settings = Setting::first();
        return new Content(
            markdown: 'dashboard.emails.project-assigned-members',
            with: [
                'memberName' => $this->member->name,
                'projectName' => $this->project->name,
                'projectDescription' => $this->project->description,
                'startDate' => $this->project->start_date,
                'endDate' => $this->project->end_date,
                'projectManager' => $this->project->member->name,
                'departmentName' => $this->project->department->name,
                'adminName' => $this->admin->name,
                'position' => $this->admin->roles[0]->name,
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
