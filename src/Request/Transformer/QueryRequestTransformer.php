<?php

declare(strict_types=1);

namespace HttpProcess\Request\Transformer;

use HttpProcess\Request\ApiRequestInterface;
use HttpProcess\Request\Exception\BadRequestException;
use ReflectionClass;
use ReflectionException;
use Symfony\Component\HttpFoundation\Request;

final class QueryRequestTransformer implements RequestTransformerInterface
{
    public function __construct(
        readonly private string $type
    ) {
    }

    public function transform(Request $request): ApiRequestInterface
    {
        try {
            $apiRequest = new $this->type;
            $reflectionClass = new ReflectionClass($apiRequest);
            $properties = $reflectionClass->getProperties();

            foreach ($properties as $property) {
                $name = $property->getName();
                $type = $property->getType()->getName();
                $value = $this->getRequestQueryParam($request, $name, $type);

                if ($property->isPublic()) {
                    $property->setValue($apiRequest, $value);
                }

                if ($property->isPrivate() || $property->isProtected()) {
                    $setter = 'set' . ucfirst($name);

                    if (!$reflectionClass->hasMethod($setter)) {
                        continue;
                    }

                    $reflectionClass
                        ->getMethod($setter)
                        ->invoke($apiRequest, $value);
                }
            }

            return $apiRequest;
        } catch (ReflectionException) {
            throw new BadRequestException("Invalid request query");
        }
    }

    private function getRequestQueryParam(Request $request, string $name, string $type): int|bool|string
    {
        return match ($type) {
            'int' => $request->query->getInt($name),
            'bool' => $request->query->getBoolean($name),
            'string' => $request->query->get($name),
            default => throw new BadRequestException(
                sprintf("Invalid request query parameter type '%s' for property '%s'", $type, $name)
            )
        };
    }
}
