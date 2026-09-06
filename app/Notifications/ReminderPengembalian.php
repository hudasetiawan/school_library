<?php

namespace App\Notifications;

use App\Models\Borrowing;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class ReminderPengembalian extends Notification implements ShouldQueue
{
    use Queueable;

    /**
     * Create a new notification instance.
     */
    public function __construct(
        public readonly Borrowing $borrowing,
        public readonly int $daysRemaining,
    ) {}

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        return ['mail'];
    }

    /**
     * Get the mail representation of the notification.
     */
    public function toMail(object $notifiable): MailMessage
    {
        $bookTitle = $this->borrowing->book?->judul ?? 'Buku Tidak Diketahui';
        $dueDate = $this->borrowing->tanggal_jatuh_tempo->translatedFormat('l, d F Y');

        $subject = match ($this->daysRemaining) {
            0 => "🚨 Hari Ini Batas Akhir Pengembalian: \"{$bookTitle}\"",
            1 => "⚠️ Besok Batas Akhir! Pengembalian Buku: \"{$bookTitle}\"",
            2 => "⏰ 2 Hari Lagi: Pengembalian Buku \"{$bookTitle}\"",
            default => "📚 {$this->daysRemaining} Hari Lagi: Pengingat Pengembalian \"{$bookTitle}\"",
        };

        $urgencyLevel = match ($this->daysRemaining) {
            0 => 'critical',
            1 => 'warning',
            default => 'info',
        };

        return (new MailMessage)
            ->subject($subject)
            ->markdown('mail.reminder-pengembalian', [
                'userName'      => $notifiable->name,
                'bookTitle'     => $bookTitle,
                'dueDate'       => $dueDate,
                'borrowDate'    => $this->borrowing->tanggal_pinjam->translatedFormat('d F Y'),
                'daysRemaining' => $this->daysRemaining,
                'urgencyLevel'  => $urgencyLevel,
            ]);
    }

    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toArray(object $notifiable): array
    {
        return [
            'borrowing_id'   => $this->borrowing->id,
            'book_title'     => $this->borrowing->book?->judul,
            'due_date'       => $this->borrowing->tanggal_jatuh_tempo->toDateString(),
            'days_remaining' => $this->daysRemaining,
        ];
    }
}
