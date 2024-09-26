<?php

namespace App\Services;

use App\Entity\User;
use App\Exceptions\UserSubscriptionException;
use App\Services\UserValidation\UserValidatorInterface;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\DependencyInjection\Attribute\TaggedIterator;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Address;
use Symfony\Component\Mime\Email;
use Twig\Environment;

class SubscriptionService implements SubscriptionInterface
{
    /**
     * @param UserValidatorInterface[] $validators
     */
    public function __construct(
        #[TaggedIterator('user.validator')]
        private iterable $validators,
        private EntityManagerInterface $entityManager,
        protected MailerInterface $mailer,
        protected Environment $twig
    ) { }

    public function signup(User $user): void
    {
        foreach ($this->validators as $validator) {
            $validationResult = $validator->validate($user);
            if (!empty($validationResult->getErrors())) {
                throw new UserSubscriptionException(implode(' ', $validationResult->getErrors()));
            }
        }

        $this->entityManager->persist($user);
        $this->entityManager->flush();

        $html = $this->twig->render('emails/signup.html.twig', [
            'firstname' => $user->getFirstname(),
            'type' => $user->getType()
        ]);

        $mail = (new Email())
            ->to($user->getEmail())
            ->from(new Address('signup@example.com'))
            ->subject('Thank you for signing up!')
            ->html($html);

        $this->mailer->send($mail);
    }
}