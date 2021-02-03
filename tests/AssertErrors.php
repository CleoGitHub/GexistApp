<?php

namespace App\Tests;

use App\Entity\Category;

trait AssertErrors {

    public function assertHasErrors($cat, int $number = 0) {
        self::bootKernel();
        $errors = self::$container->get('validator')->validate($cat);

        $messages = [];
        foreach ($errors as $error)
            $messages[] = $error->getPropertyPath().": ".$error->getMessage();

        $this->assertCount($number, $errors, implode("\n",$messages));
    }
}