<?php declare(strict_types=1);

namespace RichCongress\TestSuite\TestCase;

use Symfony\Component\Security\Core\Authentication\Token\NullToken;
use Symfony\Component\Security\Core\Authentication\Token\UsernamePasswordToken;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Authorization\Voter\VoterInterface;
use Symfony\Component\Security\Core\User\UserInterface;

/**
 * Class VoterTestCase
 *
 * @package    RichCongress\TestSuite\TestCase
 * @author     Nicolas Guilloux <nguilloux@richcongress.com>
 * @copyright  2014 - 2021 RichCongress (https://www.richcongress.com)
 */
abstract class VoterTestCase extends \RichCongress\RecurrentFixturesTestBundle\TestCase\TestCase
{
    /** @var VoterInterface */
    protected $voter;

    /**
     * @param UserInterface|null $user
     * @param array              $roles
     *
     * @return UsernamePasswordToken
     */
    public function getToken(UserInterface $user = null, array $roles = []): TokenInterface
    {
        return $user
            ? new UsernamePasswordToken($user, 'main', $roles)
            : new NullToken();
    }

    /**
     * @param mixed              $subject
     * @param string|array       $attributes
     * @param UserInterface|null $user
     *
     * @return int
     */
    public function vote($subject, $attributes, UserInterface $user = null): int
    {
        if (!$this->voter instanceof VoterInterface) {
            throw new \LogicException('The voter is not well initialized. Please set the `voter` property.');
        }

        $attributes = (array) $attributes;
        $token = $this->getToken($user);

        return $this->voter->vote($token, $subject, $attributes);
    }
}
