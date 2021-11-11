<?php

namespace BristolSU\Mail\Actions;

use BristolSU\Mail\Mail\EmailPayload;
use BristolSU\Mail\Mail\SendEmailJob;
use BristolSU\Mail\Mail\Upload\UploadAttachments;
use BristolSU\Mail\Models\EmailAddress;
use BristolSU\Support\Action\ActionResponse;
use BristolSU\Support\Action\Contracts\Action;
use BristolSU\Support\Authentication\Contracts\Authentication;
use FormSchema\Generator\Field;
use FormSchema\Generator\Form;
use FormSchema\Generator\Group;
use FormSchema\Schema\Form as FormSchema;

class SendEmail extends Action
{

    public static function options(): FormSchema
    {
        $from = EmailAddress::forUser(app(Authentication::class)->getUser())
            ->get()
            ->filter(fn(EmailAddress $emailAddress) => $emailAddress->status !== 'Waiting for Verification');

        return Form::make()
            ->withGroup(Group::make('Recipients')
                ->withField(Field::select('from_id')
                    ->setSelectOptions($from->map(fn(EmailAddress $emailAddress) => ['id' => $emailAddress->id, 'value' => $emailAddress->email])->toArray())
                    ->setLabel('From')
                    ->setHint('Who to send the email from.')
                    ->setTooltip('This will appear as the address the email is sent from.')
                    ->setRequired(true)
                )
                ->withField(Field::tags('to')
                    ->setLabel('To *')
                    ->setHint('Who to send the email to.')
                    ->setTooltip('You may enter multiple recipients by pressing enter.')
                    ->setRequired(false)
                )
                ->withField(Field::tags('cc')
                    ->setLabel('CC')
                    ->setHint('Who to cc the email to.')
                    ->setTooltip('You may enter multiple recipients by pressing enter.')
                    ->setValue([])
                    ->setRequired(false)
                )
                ->withField(Field::tags('bcc')
                    ->setLabel('Bcc')
                    ->setHint('Who to bcc the email to.')
                    ->setTooltip('You may enter multiple recipients by pressing enter.')
                    ->setValue([])
                    ->setRequired(false)
                )
                ->withField(Field::text('reply_to')
                    ->setLabel('Reply To')
                    ->setHint('The email that replies should be directed to.')
                    ->setRequired(false)
                ))
            ->withGroup(
                Group::make('Content')
                    ->withField(Field::text('subject')
                        ->setLabel('Subject')
                        ->setHint('The subject of the message.')
                        ->setTooltip('This will appear as the subject on the email.')
                        ->setRequired(false)
                    )
                    ->withField(Field::radios('content_type')
                        ->setLabel('Content Type')
                        ->setHint('The type of content you want to send.')
                        ->setValue('builder')
                        ->withOption('html', 'HTML')
                        ->withOption('builder', 'Builder')
                        ->setRequired(false)
                    )
                    ->withField((Field::html('html_content'))
                        ->setLabel('Content')
                        ->setHint('The body of the email')
                        ->setRequired(false)
                    )
                    ->withField(Field::text('greeting')
                        ->setLabel('Greeting')
                        ->setHint('The first line of the message')
                        ->setTooltip('e.g. Dear X,')
                        ->setRequired(false)
                    )
                    ->withField(Field::textArea('before_lines')
                        ->setLabel('Before Lines')
                        ->setHint('Lines that appear before the action')
                        ->setRequired(false)
                    )
                    ->withField(Field::text('action_text')
                        ->setLabel('Action Name')
                        ->setHint('The text to show on the action button')
                        ->setRequired(false)
                    )
                    ->withField(Field::text('action_url')
                        ->setLabel('Action URL')
                        ->setHint('The URL to send the user to when they click the button')
                        ->setRequired(false)
                    )
                    ->withField(Field::select('action_type')
                        ->setLabel('Action Type')
                        ->withOption('action', 'Normal')
                        ->withOption('error', 'Error')
                        ->withOption('success', 'Success')
                        ->setValue('action')
                        ->setHint('The text to show on the action button')
                        ->setRequired(false)
                    )
                    ->withField(Field::textArea('after_lines')
                        ->setLabel('After Lines')
                        ->setHint('Lines that appear after the action')
                        ->setRequired(false)
                    )
                    ->withField(Field::textArea('salutation')
                        ->setLabel('Salutation')
                        ->setHint('The last line of the message')
                        ->setTooltip('e.g. Many thanks,')
                        ->setRequired(false)
                    )->withField(Field::fileUpload('attachments')
                        ->setLabel('Attachments')
                        ->withOptions(['multiple' => true])
                        ->setHint('Attachments for the email.')
                        ->setValue([])
                        ->setTooltip('You may select multiple files.')
                        ->setRequired(false)
                    ))->withGroup(
                Group::make('Meta Data')
                    ->withField(Field::textInput('notes')
                        ->setLabel('Notes')
                        ->setHint('Notes to help you identify the email later.')
                        ->setTooltip('These notes aren\'t shown to the user, and will be kept private.')
                        ->setRequired(false)
                    )->withField(Field::select('priority')
                        ->setLabel('Priority')
                        ->setHint('1 is high priority, 5 is low priority')
                        ->setRequired(false)
                        ->withOption(1, 'Highest')->withOption(2, 'High')->withOption(3, 'Medium')->withOption(4, 'Low')->withOption(5, 'Lowest')
                    )
            )->form();

    }

    public function run(): ActionResponse
    {
        $payload = $this->getPayload();

        SendEmailJob::dispatchSync($payload);

        return ActionResponse::success('Email sent to outbox');
    }

    private function getPayload(): EmailPayload
    {
        $payload = new EmailPayload(
            $this->getContent(),
            $this->option('to', []),
            EmailAddress::findOrFail($this->option('from_id'))
        );
        $payload->setSentVia('action');
        $payload->setNotes($this->option('notes'));
        $payload->setSubject($this->option('subject'));
        $payload->setBcc($this->option('bcc', []));
        $payload->setCc($this->option('cc', []));
        $payload->setPriority($this->option('priority', null));
        $payload->setReplyTo($this->option('reply_to', null));

        $files = array_filter($this->option('attachments', []));
        if (!empty($files)) {
            $attachments = new UploadAttachments($files);
            $attachments->upload();
            $attachments->getPayload($payload);
        }

        return $payload;
    }

    private function getContent()
    {
        if($this->option('content_type') === 'html') {
            return $this->option('html_content', '');
        } elseif($this->option('content_type') === 'builder') {
            return [
                'greeting' => $this->option('greeting', ''),
                'before_lines' => \Illuminate\Support\Arr::wrap($this->option('before_lines', [])),
                'after_lines' => \Illuminate\Support\Arr::wrap($this->option('after_lines', [])),
                'salutation' => $this->option('salutation', ''),
                'action' => ($this->option('action_text') !== null && $this->option('action_url') !== null && $this->option('action_type') !== null) ?
                    [
                        'text' => $this->option('action_text'),
                        'url' => $this->option('action_url'),
                        'type' => $this->option('action_type'),
                    ] : []
            ];
        }
        return null;
    }
}
