<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class AdminInquiryNotification extends Mailable
{
    use Queueable, SerializesModels;
    protected $details;

    /**
     * Create a new message instance.
     * 初期設定やデータの受け取りなど
     */
    public function __construct($details)
    {
        $this->details = $details;
    }

    /**
     * Get the message envelope.
     * デフォルトの送信者、受信者、件名などの情報
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: '問い合わせ通知メール',
            from: 'test@example.com',
            to: 'test@example.com',
        );
    }

    /**
     * Get the message content definition.
     * 本文
     * HTMLテンプレートまたはテキスト形式
     */
    public function content(): Content
    {
        return new Content(
            view: 'emails.admin_contact_notification', // メールのビューファイル
            with: [
                'details' => $this->details
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
