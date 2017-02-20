<?php

class WDG_Test extends PHPUnit_Framework_TestCase {
	private function prepareIncludeDirectory() {
		$path = dirname(__FILE__) . '/tmp';
		foreach (range(1,3) as $i) {
			file_put_contents($path . '/test' . $i . '.php', '<?php define("TEST_' . $i . '", true);');
		}
	}

	private function cleanTmpDirectory() {
		$files = glob(dirname(__FILE__) . '/tmp/*');
		foreach ($files as $file) {
			if (is_file($file)) {
				unlink($file);
			}
		}
	}

	public function testIncludeDirectory() {
		$this->prepareIncludeDirectory();

		WDG::include_directory(dirname(__FILE__) . '/tmp');

		$this->assertEquals(true, defined('TEST_1') && TEST_1 === true);
		$this->assertEquals(true, defined('TEST_2') && TEST_2 === true);
		$this->assertEquals(true, defined('TEST_3') && TEST_3 === true);

		$this->cleanTmpDirectory();
	}

	public function testAddBodyClass() {
		// single class string
		WDG::add_body_class('test');
		$this->assertEquals(1, count(WDG::$body_classes));
		$this->assertEquals(true, in_array('test', WDG::$body_classes));
		WDG::$body_classes = array();

		// multiple classes in a single string
		WDG::add_body_class('test1 test2 test3');
		$this->assertEquals(3, count(WDG::$body_classes));
		$this->assertEquals(true, in_array('test1', WDG::$body_classes));
		$this->assertEquals(true, in_array('test2', WDG::$body_classes));
		$this->assertEquals(true, in_array('test3', WDG::$body_classes));
		WDG::$body_classes = array();

		// multiple classes in a single array
		WDG::add_body_class(array('test1', 'test2', 'test3'));
		$this->assertEquals(3, count(WDG::$body_classes));
		$this->assertEquals(true, in_array('test1', WDG::$body_classes));
		$this->assertEquals(true, in_array('test2', WDG::$body_classes));
		$this->assertEquals(true, in_array('test3', WDG::$body_classes));
		WDG::$body_classes = array();

		// multiple classes in a single string inside a single array
		WDG::add_body_class(array('test1 test2', 'test3'));
		$this->assertEquals(3, count(WDG::$body_classes));
		$this->assertEquals(true, in_array('test1', WDG::$body_classes));
		$this->assertEquals(true, in_array('test2', WDG::$body_classes));
		$this->assertEquals(true, in_array('test3', WDG::$body_classes));
		WDG::$body_classes = array();

		// single class in multiple arrays
		WDG::add_body_class(array('test1'), array('test2'), array('test3'));
		$this->assertEquals(3, count(WDG::$body_classes));
		$this->assertEquals(true, in_array('test1', WDG::$body_classes));
		$this->assertEquals(true, in_array('test2', WDG::$body_classes));
		$this->assertEquals(true, in_array('test3', WDG::$body_classes));
		WDG::$body_classes = array();

		// multimensional arrays
		WDG::add_body_class(array('test1', array('test2', array('test3'))));
		$this->assertEquals(3, count(WDG::$body_classes));
		$this->assertEquals(true, in_array('test1', WDG::$body_classes));
		$this->assertEquals(true, in_array('test2', WDG::$body_classes));
		$this->assertEquals(true, in_array('test3', WDG::$body_classes));
		WDG::$body_classes = array();

		// multiple classes as multiple string arguments
		WDG::add_body_class('test1', 'test2', 'test3');
		$this->assertEquals(3, count(WDG::$body_classes));
		$this->assertEquals(true, in_array('test1', WDG::$body_classes));
		$this->assertEquals(true, in_array('test2', WDG::$body_classes));
		$this->assertEquals(true, in_array('test3', WDG::$body_classes));
		WDG::$body_classes = array();

		// error on object
		$data = (object) array('test1', 'test2', 'test3');
		$return = WDG::add_body_class('test', $data);
		$this->assertEquals(0, count(WDG::$body_classes));
		$this->assertEquals(true, is_wp_error($return));
		WDG::$body_classes = array();
	}
}
