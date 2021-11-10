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
        return Form::make()
            ->withGroup(Group::make('Recipients')
                ->withField(Field::text('to')->setLabel('Recipients')->setTooltip('A comma separated list of the recipients')->setRequired(true)->setValue(''))
                ->withField(Field::text('cc')->setLabel('CC Recipients')->setTooltip('A comma separated list of emails to cc in')->setRequired(false)->setValue(''))
                ->withField(Field::text('bcc')->setLabel('BCC Recipients')->setTooltip('A comma separated list of emails to bcc in')->setRequired(false)->setValue(''))
                ->withField(Field::select('from_id')->setLabel('From')->setHint('Who should the email come from?')->setRequired(true)->setValue(null)
                    ->setSelectOptions(EmailAddress::forUser(app(Authentication::class)->getUser())
                        ->get()->filter(fn(EmailAddress $emailAddress) => $emailAddress->status !== 'Waiting for Verification')
                        ->map(fn(EmailAddress $emailAddress) => ['id' => $emailAddress->id, 'value' => $emailAddress->email])
                        ->toArray()
                    )
                )
                ->withField(Field::text('reply_to')->setLabel('The email to reply to. Defaults to the email being used to send.')
                    ->setTooltip('When a user replies to the email, their reply will be routed to this email address.')
                    ->setRequired(false)->setValue(null))
            )

            ->withGroup(Group::make('Content')
                ->withField(Field::html('subject')->setLabel('Subject')->setHint('The subject of the email')->setRequired(false))
                ->withField(Field::html('content')->setLabel('Email Body')->setHint('The contents of the email')->setRequired(true))
                ->withField(Field::text('attachments')->setLabel('Attachments')->setHint('A comma separated list of URLs')->setRequired(false))
            )
            ->withGroup(Group::make('Meta Data')
                ->withField(Field::text('notes')->setLabel('Private notes to help you identify the source or context about the email')
                    ->setTooltip('These notes will stay hidden from the email recipient')
                    ->setRequired(false)
                )
                ->withField(Field::select('priority')->setLabel('Priority')->withNullOption('No priority set')
                    ->setHint('1 is high priority, 5 is low priority')->setRequired(false)->setValue(null)
                    ->withOption(1, 'Highest')->withOption(2, 'High')
                    ->withOption(3, 'Medium')->withOption(4, 'Low')->withOption(5, 'Lowest')
                )
            )
            ->form();
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
            $this->option('content'),
            explode(',', $this->option('to')),
            EmailAddress::findOrFail($this->option('from_id'))
        );
        $payload->setSentVia('action');
        $payload->setNotes($this->option('notes'));
        $payload->setSubject($this->option('subject'));
        $payload->setBcc(array_filter(explode(',', $this->option('bcc', ''))));
        $payload->setCc(array_filter(explode(',', $this->option('cc', ''))));
        $payload->setPriority($this->option('priority', null));
        $payload->setReplyTo($this->option('reply_to', null));

        $files = array_filter(explode(',', $this->option('attachments', '')));
        if(!empty($files)) {
            $attachments = new UploadAttachments($files);
            $attachments->upload();
            $attachments->getPayload($payload);
        }

        return $payload;
    }
}
