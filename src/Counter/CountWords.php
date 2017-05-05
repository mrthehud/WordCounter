<?php

namespace Counter;

class CountWords {

	/**
	 * The default number of words to output
	 */
	const DEFAULT_LIMIT = 100;

	/**
	 * A regex of characters to remove, and replace with a space.
	 */
	const FILTER_PATTERN = '/[^a-z0-9\s]+/';

	/**
	 * An array of strings to ignore, if they're found as words.
	 * By default, we ignore empty strings and newlines.
	 */
	const IGNORE_WORDS = ['', "\r", "\n"];

	/**
	 * @var array The count of words so far. Index is the word, value is the total number
	 *            of times it's been seen.
	 */
	private $word_count = [];

	/**
	 * Count the number of words in a line, appending to the $word_count instance variable.
	 * Ignores any words in CountFrequencyCommand::IGNORE_WORDS
	 *
	 * @param string $line
	 */
	public function appendWords(string $line) {
		$words = $this->getWordsInLine($line);

		foreach ($words as $word) {
			$word = trim($word);

			if (in_array($word, self::IGNORE_WORDS)) {
				continue;
			}

			if (!isset($this->word_count[$word])) {
				$this->word_count[$word] = 0;
			}
			$this->word_count[$word]++;
		}
	}

	/**
	 * Reset the word count
	 */
	public function resetCount() {
		$this->word_count = [];
	}

	public function getWordCount() {
		return $this->word_count;
	}

	/**
	 * Get an array of al words out of the line, filtering out characters in
	 * CountFrequencyCommand::FILTER_PATTERN
	 *
	 * @param string $line
	 *
	 * @return array
	 */
	private function getWordsInLine(string $line) {
		$filtered = preg_replace(self::FILTER_PATTERN, ' ', strtolower($line));

		return explode(' ', $filtered);
	}
}
