<?php

/*
 * This file is part of the Sylius package.
 *
 * (c) Paweł Jędrzejewski
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace Sylius\Bundle\ResourceBundle\Validator;

use Sylius\Component\Resource\Model\ToggleableInterface;
use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;
use Webmozart\Assert\Assert;

final class EnabledValidator extends ConstraintValidator
{
    /**
     * {@inheritdoc}
     *
     * @param ToggleableInterface $value
     * @param Constraints\Enabled $constraint
     */
    public function validate($value, Constraint $constraint): void
    {
        /** @var Constraints\Enabled $constraint */
        Assert::isInstanceOf($constraint, Constraints\Enabled::class);

        if (null === $value) {
            return;
        }

        $this->ensureValueImplementsToggleableInterface($value);

        if (!$value->isEnabled()) {
            $this->context->addViolation($constraint->message);
        }
    }

    private function ensureValueImplementsToggleableInterface($value): void
    {
        if (!($value instanceof ToggleableInterface)) {
            throw new \InvalidArgumentException(sprintf(
                '"%s" validates "%s" instances only',
                __CLASS__, ToggleableInterface::class
            ));
        }
    }
}
