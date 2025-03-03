<?php

declare(strict_types=1);

namespace App\UI\Http\Middleware;

use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpKernel\Event\RequestEvent;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Validator\Validator\ValidatorInterface;

readonly class ValidationMiddleware
{
    public function __construct(private ValidatorInterface $validator)
    {
    }

    public function onKernelRequest(RequestEvent $event): void
    {
        $request = $event->getRequest();

        if ('json' !== $request->getContentTypeFormat()) {
            return;
        }

        $data = json_decode($request->getContent(), true);
        if (null === $data) {
            $event->setResponse(
                new JsonResponse(['error' => 'Некорректный JSON'], JsonResponse::HTTP_BAD_REQUEST)
            );

            return;
        }

        $routeName = $request->attributes->get('_route');

        if ('client_create' === $routeName) {
            $constraints = $this->getClientCreateConstraints();
        } elseif ('credit_issue' === $routeName) {
            $constraints = $this->getCreditIssueConstraints();
        } elseif ('credit_pre_check' === $routeName) {
            $constraints = $this->getCreditPreCheckConstraints();
        } else {
            return;
        }

        $violations = $this->validator->validate($data, $constraints);

        if (count($violations) > 0) {
            $errors = [];
            foreach ($violations as $violation) {
                $errors[$violation->getPropertyPath()][] = $violation->getMessage();
            }
            $event->setResponse(new JsonResponse(['errors' => $errors], JsonResponse::HTTP_BAD_REQUEST));
        }
    }

    private function getClientCreateConstraints(): Assert\Collection
    {
        return new Assert\Collection([
            'fields' => [
                'firstName' => new Assert\NotBlank(['message' => 'firstName не должен быть пустым']),
                'lastName' => new Assert\NotBlank(['message' => 'lastName не должен быть пустым']),
                'age' => [
                    new Assert\NotBlank(['message' => 'age обязателен']),
                    new Assert\Type(['type' => 'integer', 'message' => 'age должен быть числом']),
                    new Assert\Range([
                        'min' => 18,
                        'max' => 60,
                        'notInRangeMessage' => 'age должен быть от 18 до 60',
                    ]),
                ],
                'ssn' => new Assert\NotBlank(['message' => 'ssn обязателен']),
                'address' => $this->getAddressConstraints(),
                'creditRating' => [
                    new Assert\NotBlank(['message' => 'creditRating обязателен']),
                    new Assert\Type(['type' => 'integer', 'message' => 'creditRating должен быть числом']),
                    new Assert\Range([
                        'min' => 300,
                        'max' => 850,
                        'notInRangeMessage' => 'creditRating должен быть от 300 до 850',
                    ]),
                ],
                'email' => [
                    new Assert\NotBlank(['message' => 'email обязателен']),
                    new Assert\Email(['message' => 'Некорректный email']),
                ],
                'phone' => new Assert\NotBlank(['message' => 'phone обязателен']),
                'monthlyIncome' => [
                    new Assert\NotBlank(['message' => 'monthlyIncome обязателен']),
                    new Assert\Type(['type' => 'numeric', 'message' => 'monthlyIncome должен быть числовым']),
                    new Assert\GreaterThanOrEqual([
                        'value' => 1000,
                        'message' => 'monthlyIncome должен быть не менее 1000',
                    ]),
                ],
            ],
            'allowExtraFields' => false,
        ]);
    }

    private function getCreditIssueConstraints(): Assert\Collection
    {
        return new Assert\Collection([
            'fields' => [
                'clientId' => [
                    new Assert\NotBlank(['message' => 'clientId не должен быть пустым']),
                    new Assert\Uuid(['message' => 'clientId должен быть валидным UUID']),
                ],
                'creditId' => [
                    new Assert\NotBlank(['message' => 'creditId не должен быть пустым']),
                    new Assert\Uuid(['message' => 'creditId должен быть валидным UUID']),
                ],
                'term' => [
                    new Assert\NotBlank(['message' => 'term обязателен']),
                    new Assert\Type(['type' => 'integer', 'message' => 'term должен быть числом']),
                    new Assert\GreaterThanOrEqual(['value' => 1, 'message' => 'term должен быть положительным']),
                ],
                'amount' => [
                    new Assert\NotBlank(['message' => 'amount обязателен']),
                    new Assert\Type(['type' => 'numeric', 'message' => 'amount должен быть числовым']),
                    new Assert\GreaterThan(['value' => 0, 'message' => 'amount должен быть больше нуля']),
                ],
            ],
            'allowExtraFields' => false,
        ]);
    }

    private function getCreditPreCheckConstraints(): Assert\Collection
    {
        return new Assert\Collection([
            'fields' => [
                'clientId' => [
                    new Assert\NotBlank(['message' => 'clientId не должен быть пустым']),
                    new Assert\Uuid(['message' => 'clientId должен быть валидным UUID']),
                ],
                'creditId' => [
                    new Assert\NotBlank(['message' => 'creditId не должен быть пустым']),
                    new Assert\Uuid(['message' => 'creditId должен быть валидным UUID']),
                ],
            ],
            'allowExtraFields' => false,
        ]);
    }

    private function getAddressConstraints(): Assert\Collection
    {
        return new Assert\Collection([
            'fields' => [
                'street' => new Assert\NotBlank(['message' => 'street обязателен']),
                'city' => new Assert\NotBlank(['message' => 'city обязателен']),
                'state' => new Assert\NotBlank(['message' => 'state обязателен']),
                'zip' => new Assert\NotBlank(['message' => 'zip обязателен']),
            ],
            'allowExtraFields' => false,
        ]);
    }
}
