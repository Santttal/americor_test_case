<?php

declare(strict_types=1);

namespace App\UI\Http\Middleware;

use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpKernel\Event\RequestEvent;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Validator\Validation;

final class ValidationMiddleware
{
    public function onKernelRequest(RequestEvent $event): void
    {
        $request = $event->getRequest();

        // Применяем валидацию только для JSON-запросов
        if ('json' !== $request->getContentTypeFormat()) {
            return;
        }

        $data = json_decode($request->getContent(), true);
        if (null === $data) {
            $response = new JsonResponse(['error' => 'Некорректный JSON'], JsonResponse::HTTP_BAD_REQUEST);
            $event->setResponse($response);

            return;
        }

        // Определяем тип запроса по имени маршрута
        $routeName = $request->attributes->get('_route');

        if ('client_create' === $routeName) {
            $constraints = new Assert\Collection([
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
                    'address' => new Assert\Collection([
                        'fields' => [
                            'street' => new Assert\NotBlank(['message' => 'street обязателен']),
                            'city' => new Assert\NotBlank(['message' => 'city обязателен']),
                            'state' => new Assert\NotBlank(['message' => 'state обязателен']),
                            'zip' => new Assert\NotBlank(['message' => 'zip обязателен']),
                        ],
                        'allowExtraFields' => true,
                    ]),
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
                'allowExtraFields' => true,
            ]);
        } elseif ('credit_issue' === $routeName) {
            $constraints = new Assert\Collection([
                'fields' => [
                    'clientId' => [
                        new Assert\NotBlank(['message' => 'clientId не должен быть пустым']),
                        new Assert\Uuid(['message' => 'clientId должен быть валидным UUID']),
                    ],
                    'creditId' => [
                        new Assert\NotBlank(['message' => 'creditId не должен быть пустым']),
                        new Assert\Uuid(['message' => 'creditId должен быть валидным UUID']),
                    ],
                    'productName' => new Assert\NotBlank(['message' => 'Название продукта не должно быть пустым']),
                    'term' => [
                        new Assert\NotBlank(['message' => 'Срок кредита обязателен']),
                        new Assert\Type(['type' => 'integer', 'message' => 'Срок кредита должен быть числом']),
                    ],
                    'interestRate' => [
                        new Assert\NotBlank(['message' => 'Процентная ставка обязателена']),
                        new Assert\Type(['type' => 'numeric', 'message' => 'Процентная ставка должна быть числовой']),
                    ],
                    'amount' => [
                        new Assert\NotBlank(['message' => 'Сумма кредита обязана быть указана']),
                        new Assert\Type(['type' => 'numeric', 'message' => 'Сумма кредита должна быть числовой']),
                    ],
                ],
                'allowExtraFields' => true,
            ]);
        } else {
            return;
        }

        $validator = Validation::createValidator();
        $violations = $validator->validate($data, $constraints);

        if (count($violations) > 0) {
            $errors = [];
            foreach ($violations as $violation) {
                $errors[$violation->getPropertyPath()][] = $violation->getMessage();
            }
            $response = new JsonResponse(['errors' => $errors], JsonResponse::HTTP_BAD_REQUEST);
            $event->setResponse($response);
        }
    }
}
