<?php

namespace Unit\Counter;

use Counter\CountWords;

class CountWordsTest extends \PHPUnit_Framework_TestCase {

	/** @var CountWords */
	private $counter;

	protected function setUp() {
		$this->counter = new CountWords();
	}

	public function testAppendWords() {
		$this->counter->appendWords("one two three");
		$this->counter->appendWords("one two");
		$word_count = $this->counter->getWordCount();
		$this->assertEquals(["one" => 2, "two" => 2, "three" => 1], $word_count);
	}

	public function testResetCount() {
		$this->counter->appendWords("one two three");
		$this->counter->resetCount();
		$word_count = $this->counter->getWordCount();
		$this->assertEquals([], $word_count);
	}
}
