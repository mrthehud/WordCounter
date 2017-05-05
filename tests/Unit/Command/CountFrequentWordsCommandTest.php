<?php
namespace Unit\Command;

use Command\CountFrequentWordsCommand;
use Symfony\Component\Console\Exception\InvalidArgumentException;
use Symfony\Component\Console\Input\ArrayInput;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\NullOutput;
use Symfony\Component\Console\Output\OutputInterface;

class CountFrequentWordsCommandTest extends \PHPUnit_Framework_TestCase {

	/** @var CountFrequentWordsCommand */
	private $command;

	protected function setUp() {
		$this->command = new CountFrequentWordsCommand();
	}


	public function testExecuteThrowsExceptionWhenFileIsNotReadable() {
		try {
			$this->command->run(
				new ArrayInput(['path' => __DIR__ . '/foobar']),
				new NullOutput()
			);
			$this->fail('Execute should throw InvalidArgumentException');
		} catch (InvalidArgumentException $e) {
			// Pass
		} catch (\Exception $e) {
			$this->fail(sprintf(
				'Execute should throw InvalidArgumentException, but threw %s',
				get_class($e)
			));
			throw $e;
		}
	}

	
}
