--TEST--
Log: Backtrace Vars
--FILE--
<?php

require_once 'Log.php';

$conf = array('lineFormat' => '%6$s [%8$s::%7$s] %4$s');
$logger = Log::singleton('console', '', 'ident', $conf);

# Top-level Logger
#
$logger->log("Top-level Logger - log()");
$logger->info("Top-level Logger - info()");

# Function Logger
#
function functionLog($logger)
{
	$logger->log("Function Logger - log()");
	$logger->info("Function Logger - info()");
}

functionLog($logger);

# Class Logger
#
class ClassLogger
{
	function log($logger)
	{
		$logger->log("Class Logger - log()");
		$logger->info("Class Logger - info()");
	}
}

$classLogger = new ClassLogger();
$classLogger->log($logger);

# Composite Logger
#
$composite = Log::singleton('composite');
$composite->addChild($logger);

$composite->log("Composite Logger - log()");
$composite->info("Composite Logger - info()");

# Composite Logger via Class
#
$classLogger->log($composite);

--EXPECT--
10 [::(none)] Top-level Logger - log()
11 [::(none)] Top-level Logger - info()
17 [::functionLog] Function Logger - log()
18 [::functionLog] Function Logger - info()
29 [ClassLogger::log] Class Logger - log()
30 [ClassLogger::log] Class Logger - info()
42 [::(none)] Composite Logger - log()
43 [::(none)] Composite Logger - info()
29 [ClassLogger::log] Class Logger - log()
30 [ClassLogger::log] Class Logger - info()
