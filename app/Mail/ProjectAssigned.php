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

class ProjectAssigned extends Mailable
{
    use Queueable, SerializesModels;

    public $manegar, $project, $admin;

    /**
     * Create a new message instance.
     */
    public function __construct($manegar, $project, $admin)
    {
        $this->manegar = $manegar;
        $this->project = $project;
        $this->admin = $admin;
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Project Manager Assignment',
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        $settings = Setting::first();

        return new Content(
            markdown: 'dashboard.emails.project-assigned',
            with: [
                'managerName' => $this->manegar->name,
                'projectName' => $this->project->name,
                'startDate' => $this->project->start_date,
                'endDate' => $this->project->end_date,
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
