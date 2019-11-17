<?php
namespace LandingPage;
use Ratchet\MessageComponentInterface;
use Ratchet\ConnectionInterface;

class Status implements MessageComponentInterface {
	protected function getMemoryUsage() {
		$fh = fopen('/proc/meminfo','r');
		$totalmem = 0;
		$usedmem = 0;
		$totalswap = 0;
		$usedswap = 0;
		while ($line = fgets($fh)) {
			$pieces = array();
			if (preg_match('/^MemTotal:\s+(\d+)\skB$/', $line, $pieces)) {
				$totalmem = $pieces[1];
			}
			if (preg_match('/^MemAvailable:\s+(\d+)\skB$/', $line, $pieces)) {
				$usedmem = $totalmem - $pieces[1];
			}
			if (preg_match('/^SwapTotal:\s+(\d+)\skB$/', $line, $pieces)) {
				$totalswap = $pieces[1];
			}
			if (preg_match('/^SwapFree:\s+(\d+)\skB$/', $line, $pieces)) {
				$usedswap = $totalswap - $pieces[1];
			}
		}
		fclose($fh);
		if ($totalswap != 0) {
			return array('ram' => round($usedmem * 100 / $totalmem, 2), 'swap' => round($usedswap * 100 / $totalswap, 2));
		} else {
			return array('ram' => round($usedmem * 100 / $totalmem, 2), 'swap' => null);
		}
	}

	protected function getSysValues() {
		$load_avg = sys_getloadavg();
		
		$mem = $this->getMemoryUsage();
		$df = disk_free_space("/");
		$dt = disk_total_space("/");
		$du = round(($dt - $df) * 100 / $dt, 2);

		return array('avg' => $load_avg, 'mem' => $mem, 'du' => $du);
	}

	public function onOpen(ConnectionInterface $conn) {
		echo "New connection! ({$conn->resourceId})\n";
		$conn->send(json_encode($this->getSysValues()));
	}
	
	public function onMessage(ConnectionInterface $from, $msg) {
		$from->send(json_encode($this->getSysValues()));
	}

	public function onClose(ConnectionInterface $conn) {
		echo "Connection {$conn->resourceId} has disconnected\n";
	}

	public function onError(ConnectionInterface $conn, \Exception $e) {
		echo "An error has occurred: {$e->getMessage()}\n";

		$conn->close();
	}
}