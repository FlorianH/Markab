<?php

class DboMyDboSource extends DboSource {

  
  
  public function connect() {
    $this->connected = true;
    return $this->connected;
  }
  public function disconnect() {
    $this->connected = false;
    return !$this->connected;
  }

}
