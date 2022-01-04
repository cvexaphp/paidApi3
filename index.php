<?php
    ini_set('display_errors', 1);
    ini_set('display_startup_errors', 1);
    error_reporting(E_ALL);
    require_once 'vendor/autoload.php';

    header('Content-type: application/json');

    // use the factory to create a Faker\Generator instance
    $faker = Faker\Factory::create();
    $numberCheck = new Faker\Calculator\Luhn();

    $ccDetails = $_GET['ccdetails'] ?? false;
    $validateCCNum = $_GET['ccvalidate'] ?? false;

    if($ccDetails && !$validateCCNum) {
        $numberOfCCDetails = $_GET['num'] ?? 1;
        //added if the parameter goes above 100
        if ($numberOfCCDetails > 100) {
            $numberOfCCDetails = 100;
        }

        for ($i = 0; $i < $numberOfCCDetails; $i++) {
            $details[] = $faker->creditCardDetails();
        }

        print_r(json_encode($details));
    }

    if($validateCCNum && !$ccDetails) {

        $validate = $numberCheck->isValid($validateCCNum);

        if($validate || $validate > 0) {
            print_r(json_encode(['result' => 'true']));
        }else{
            print_r(json_encode(['result' => 'false']));
        }
    }

    if($validateCCNum && $ccDetails) {
        http_response_code(400);
    }