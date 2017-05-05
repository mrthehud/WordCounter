<?php

namespace Command;

use Counter\CountWords;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Exception\InvalidArgumentException;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

/**
 * Counts frequently used words in a file at a given location
 */
class CountFrequentWordsCommand extends Command {

	/**
	 * @var CountWords
	 */
	private $counter;
	
	protected function configure() {
		$this
			->setName('app:frequent-words')
			->setDescription('Count frequently used words in a text file.')
			->setHelp('This command will count the frequently used words in '
			          . 'a text file, located at the path you provide.')
			->addArgument('path', InputArgument::OPTIONAL,
				'A path to the text file you wish to count frequently used words in',
				'https://s3-eu-west-1.amazonaws.com/secretsales-dev-test/interview/flatland.txt'
			)
			->addOption('limit', 'l', InputOption::VALUE_REQUIRED,
				'Show this number of frequent words', CountWords::DEFAULT_LIMIT);
		
		$this->counter = new CountWords();

	}

	protected function execute(InputInterface $input, OutputInterface $output) {
		$fp = @fopen($input->getArgument('path'), 'r');

		if (false === $fp) {
			throw new InvalidArgumentException(sprintf(
				'The file or location "%s" cannot be opened for reading.',
				$input->getArgument('path')
			));
		}

		while ($line = fgets($fp)) {
			$this->counter->appendWords($line);
		}

		$word_count = $this->counter->getWordCount();
		arsort($word_count, SORT_NUMERIC);

		$top = array_slice($word_count, 0, $input->getOption('limit'));
		foreach ($top as $word => $count) {
			$output->writeln(sprintf('%s,%d', $word, $count));
		}
	}

}
