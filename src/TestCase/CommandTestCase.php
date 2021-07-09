<?php declare(strict_types=1);

namespace RichCongress\TestSuite\TestCase;

use RichCongress\WebTestBundle\TestCase\Internal\WebTestCase;
use Symfony\Bundle\FrameworkBundle\Console\Application;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Tester\CommandTester;
use Symfony\Component\HttpKernel\KernelInterface;

/**
 * Class CommandTestCase
 *
 * @package    RichCongress\TestSuite\TestCase
 * @author     Nicolas Guilloux <nguilloux@richcongress.com>
 * @copyright  2014 - 2021 RichCongress (https://www.richcongress.com)
 */
abstract class CommandTestCase extends TestCase
{
    /** @var CommandTester */
    protected $commandTester;

    /** @var Command */
    protected $command;

    /**
     * Use setUp to execute code after the beforeTest execution
     */
    public function setUp(): void
    {
        parent::setUp();

        if ($this->command === null) {
            return;
        }

        // Declare the command within the application first
        if (WebTestCase::isEnabled()) {
            /** @var KernelInterface $kernel */
            $kernel = $this->getContainer()->get('kernel');
            $application = new Application($kernel);
            $application->add($this->command);
        }

        $this->commandTester = new CommandTester($this->command);
    }

    /**
     * @param array $input
     * @param array $options
     *
     * @return string
     */
    public function execute(array $input = [], array $options = []): string
    {
        $this->commandTester->execute($input, $options);

        return $this->commandTester->getDisplay();
    }
}
