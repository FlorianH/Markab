<?php

App::import('Model', 'Thumbnail');
Configure::write('debug', 2);

class ThumbnailTestCase extends CakeTestCase
{

  function testCannotBeInstantiatedWithoutId()
  {
    $thumbnail = new Thumbnail(array());
    $this->assertFalse( $thumbnail->sourceFileExists() );
  }

  function testCannotBeInstantiatedWithWrongId()
  {
    $thumbnail = new Thumbnail(array('id' => 'Huibuh'));
    $this->assertFalse( $thumbnail->sourceFileExists() );
  }

  function testExistingFileCanBeInstantiated()
  {
    $thumbnail = new Thumbnail(array('id' => 'example/Untitled-17.jpg'));
    $this->assertTrue( $thumbnail->sourceFileExists() );
  }

  function testExistingFileHasContent()
  {
    $thumbnail = new Thumbnail(array('id' => 'example/Untitled-17.jpg'));
    $raw_data = $thumbnail->getData();
    $this->assertTrue( strlen($raw_data) > 0);
  }

}