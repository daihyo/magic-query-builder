<?php

declare(strict_types=1);

namespace Src\Log;

use Monolog\Logger;
use Monolog\Level;
use Monolog\Formatter\LineFormatter;
use Monolog\Handler\StreamHandler;
use Monolog\Processor\IntrospectionProcessor;

 class Log
 {
     private static $logger = null;
     private const LOG_LEVEL = Level::Debug;
     private const LOG_PATH = "./app.log";

     public function __construct()
     {
         $lineFormat = "[%datetime%] %level_name% %extra.class%::%extra.function%(%extra.line%) - %message%\n";
         $dateFormat = "Y-m-d H:i:s";
         $lineFormatter = new LineFormatter($lineFormat, $dateFormat, true, true);

         $logger = new Logger('query-builder');
         $stdout = new StreamHandler('php://stdout', self::LOG_LEVEL);
         $file = new StreamHandler(self::LOG_PATH, self::LOG_LEVEL);
         $logger->pushHandler($stdout->setFormatter($lineFormatter));
         $logger->pushHandler($file->setFormatter($lineFormatter));
         $logger->pushProcessor(new IntrospectionProcessor(self::LOG_LEVEL, ['Monolog\\', 'Illuminate\\']));
         self::$logger = $logger;
     }

     public static function _()
     {
         if (self::$logger === null) {
             new Log();
         }
         return self::$logger;
     }

     // public function error($text="") {
        //     self::getLogger()->error(print_r($text, true));
        // }

        // public function warn($text="") {
        //     self::getLogger()->warning(print_r($text, true));
        // }

        // public function info($text="") {
        //     self::getLogger()->info(print_r($text, true));
        // }

        // public function debug($text="") {
        //     self::getLogger()->debug(print_r($text, true));
        // }
 }
